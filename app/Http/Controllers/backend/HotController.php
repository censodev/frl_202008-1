<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Hot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreHotRequest;
use Auth;
use File;
use App\Services\ImageService;

class HotController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.hot.';
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
        $data->title   = 'Danh Sách Danh Mục Nổi Bật';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['hots'] = Hot::searchHot($data->keyword, $this->limit);
        }else {
            $data['hots'] = Hot::listHot(Null, true, $this->limit);
        }

        $data['keyword'] = $data->keyword;
        $data['create_new'] = route('hot.create');

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
        $data->title   = 'Thêm Mới Danh Mục Nổi Bật';
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
    public function store(StoreHotRequest $request)
    {
        $message = 'Đã thêm mới thành công Danh Mục Nổi Bật.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'name'              =>  $request->name,
            'link'              =>  $request->link,
            'link_title'        =>  $request->link_title,
            'images'            =>  $request->images,
            'title_image'       =>  $request->title_image,
            'alt_image'         =>  $request->alt_image,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            $create_hot =  Hot::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('hot.index')->with('message', $message);
            }

            return redirect()->route('hot.edit',$create_hot->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('hot.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Hot $hot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Hot $hot)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Danh Mục Nổi Bật';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về Danh Mục Nổi Bật này. Vui lòng thử lại.';

        if( Hot::checkExists( $hot->id ) ) {
            $data['hot']       = $hot;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('hot.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(StoreHotRequest $request, Hot $hot)
    {
        $message        = 'Đã cập nhật Danh Mục Nổi Bật thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $hot ) {

            $user_id = $this->getUserData()->id ?? $hot->created_by;

            $data = [
                'name'              =>  $request->name,
                'link'              =>  $request->link,
                'link_title'        =>  $request->link_title,
                'images'            =>  $request->images,
                'title_image'       =>  $request->title_image,
                'alt_image'         =>  $request->alt_image,
                'updated_by'        =>  $user_id,
            ];

            try{
                $hot->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('hot.index')->with('message', $message);
                }

                return redirect()->route('hot.edit',$hot->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect()->route('hot.edit',$hot->id)->with('error', $error);
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
        $hot = Hot::find($id);

        $data = [
            'status'    =>  -2
        ];

        $hot->update( $data );

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

        $hots           = Hot::searchHot($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "hot";
        $html           = View($data->view, compact("hots",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

    public function searchRelative2(Request $rq)
    {
        $data = new Collection();
        $data->view    = $this->view.'search2';

        $hots2           = Hot::searchHot($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "hot";
        $html           = View($data->view, compact("hots2",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

}
