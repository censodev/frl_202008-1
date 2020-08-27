<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Endow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreEndowRequest;
use Auth;
use File;
use App\Services\ImageService;

class EndowController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.endow.';
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
        $data->title   = 'Danh Sách Ưu Đãi';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['endows'] = Endow::searchEndow($data->keyword, $this->limit);
        }else {
            $data['endows'] = Endow::listEndow(Null, true, $this->limit);
        }

        $data['keyword'] = $data->keyword;
        $data['create_new'] = route('endow.create');

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
        $data->title   = 'Thêm Mới Ưu Đãi';
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
    public function store(StoreEndowRequest $request)
    {
        $message = 'Đã thêm mới thành công ưu đãi.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'name'              =>  $request->name,
            'icon'              =>  $request->icon,
            'description'        =>  $request->description,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            $create_endow =  Endow::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('endow.index')->with('message', $message);
            }

            return redirect()->route('endow.edit',$create_endow->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('endow.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Endow $endow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Endow $endow)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Ưu Đãi';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về đối tác này. Vui lòng thử lại.';

        if( Endow::checkExists( $endow->id ) ) {
            $data['endow']       = $endow;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('endow.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEndowRequest $request, Endow $endow)
    {

        $message        = 'Đã cập nhật đối tác thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $endow ) {

            $user_id = $this->getUserData()->id ?? $endow->created_by;

            $data = [
                'name'              =>  $request->name,
                'icon'              =>  $request->icon,
                'description'        =>  $request->description,
                'updated_by'        =>  $user_id,
            ];

            try{
                $endow->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('endow.index')->with('message', $message);
                }

                return redirect()->route('endow.edit',$endow->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect()->route('endow.edit',$endow->id)->with('error', $error);
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
        $endow = Endow::find($id);

        $data = [
            'status'    =>  -2
        ];

        $endow->update( $data );

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

        $endows         = Endow::searchEndow($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "endow";
        $html           = View($data->view, compact("endows",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

}
