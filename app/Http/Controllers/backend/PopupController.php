<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Popup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StorePopupRequest;
use Auth;
use File;
use App\Services\ImageService;

class PopupController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.popup.';
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
        $data->title   = 'Danh Sách Popup';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['popups'] = Popup::searchPopup($data->keyword, $this->limit);
        }else {
            $data['popups'] = Popup::listPopup(Null, true, $this->limit);
        }

        $data['keyword'] = $data->keyword;
        $data['create_new'] = route('popup.create');

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
        $data->title   = 'Thêm Mới Popup';
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
    public function store(StorePopupRequest $request)
    {
        $message = 'Đã thêm mới thành công đối tác.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'link'              =>  $request->link,
            'link_title'        =>  $request->link_title,
            'images'            =>  $request->images,
            'title_image'       =>  $request->title_image,
            'alt_image'         =>  $request->alt_image,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            $create_popup =  Popup::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('popup.index')->with('message', $message);
            }
            return redirect()->route('popup.edit',$create_popup->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('popup.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Popup $popup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Popup $popup)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Popup';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về banner này. Vui lòng thử lại.';

        if( Popup::checkExists( $popup->id ) ) {
            $data['popup']       = $popup;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('popup.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(StorePopupRequest $request, Popup $popup)
    {
        $message        = 'Đã cập nhật banner thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $popup ) {

            $user_id = $this->getUserData()->id ?? $popup->created_by;

            $data = [
                'link'              =>  $request->link,
                'link_title'        =>  $request->link_title,
                'images'            =>  $request->images,
                'title_image'       =>  $request->title_image,
                'alt_image'         =>  $request->alt_image,
                'updated_by'        =>  $user_id,
            ];

            try{
                $popup->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('popup.index')->with('message', $message);
                }
                return redirect()->route('popup.edit',$popup->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();
                return redirect()->route('popup.edit',$popup->id)->with('error', $error);
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
        $popup = Popup::find($id);

        $data = [
            'status'    =>  -2
        ];

        $popup->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

}
