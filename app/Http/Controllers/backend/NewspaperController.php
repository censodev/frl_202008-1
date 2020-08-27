<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Newspaper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreNewspaperRequest;
use Auth;
use File;
use App\Services\ImageService;

class NewspaperController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.newspaper.';
    private $content = 'content';

    public function __construct(ImageService $imageService) {
        $this->image_service = $imageService;
    }

    public function getUserData() {
        $this->user = Auth::user();
        return $this->user;
    }
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = new Collection();
        $data->title   = 'Danh Sách Báo chí';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['newspapers'] = Newspaper::searchNewspaper($data->keyword, $this->limit);
        }else {
            $data['newspapers'] = Newspaper::listNewspaper(Null, true, $this->limit);
        }

        $data['keyword'] = $data->keyword;
        $data['create_new'] = route('newspaper.create');

        return View($data->view,compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = new Collection();
        $data->title   = 'Thêm Mới Báo Chí';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewspaperRequest $request)
    {
        $message = 'Đã thêm mới thành công báo chí.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'name'              =>  $request->name,
            'link'              =>  $request->link,
            'link_title'        =>  $request->link_title,
            'images'            =>  $request->images,
            'title_image'       =>  $request->title_image,
            'alt_image'         =>  $request->alt_image,
            'description'       =>  $request->description,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            $create_newspaper =  Newspaper::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('newspaper.index')->with('message', $message);
            }

            return redirect()->route('newspaper.edit',$create_newspaper->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('newspaper.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Newspaper $newspaper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Newspaper $newspaper)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Báo Chí';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về đối tác này. Vui lòng thử lại.';

        if( Newspaper::checkExists( $newspaper->id ) ) {
            $data['newspaper']       = $newspaper;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('newspaper.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNewspaperRequest $request, Newspaper $newspaper)
    {
        $message        = 'Đã cập nhật báo chí thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $newspaper ) {

            $user_id = $this->getUserData()->id ?? $newspaper->created_by;

            $data = [
                'name'              =>  $request->name,
                'link'              =>  $request->link,
                'link_title'        =>  $request->link_title,
                'images'            =>  $request->images,
                'title_image'       =>  $request->title_image,
                'alt_image'         =>  $request->alt_image,
                'description'       =>  $request->description,
                'updated_by'        =>  $user_id,
            ];

            try{
                $newspaper->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('newspaper.index')->with('message', $message);
                }

                return redirect()->route('newspaper.edit',$newspaper->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect()->route('newspaper.edit',$newspaper->id)->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    /*
        public function destroy(Partner $partner)
        {
            $message = 'Xóa thành công.';
            $partner->delete();

            return redirect()->route('partner.index')->with('message', $message);

        }
    */

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $newspaper = Newspaper::find($id);

        $data = [
            'status'    =>  -2
        ];

        $newspaper->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

    /**
     * [searchRelative partner]
     * @param  Request $rq
     * @return search html
     */
    public function searchRelative(Request $rq)
    {
        $data = new Collection();
        $data->view    = $this->view.'search';

        $newspapers     = Newspaper::searchNewspaper($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "newspaper";
        $html           = View($data->view, compact("newspapers",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

}
