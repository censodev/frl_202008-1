<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\ConfigSocial;
use App\Models\backend\ConfigSocialClick;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreConfigSocialRequest;
use Auth;
use File;
use App\Services\ImageService;

class ConfigSocialController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.configSocial.';
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
        $data->title   = 'Danh Sách Social';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['configSocials'] = ConfigSocial::searchConfigSocial($data->keyword,$this->limit);
        }else {
            $data['configSocials'] = ConfigSocial::listConfigSocial(Null, true, $this->limit);
        }
		
		$data['keyword'] = $data->keyword;
		$data['create_new'] = route('configSocial.create');

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
        $data->title   = 'Thêm Mới Social';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigSocialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConfigSocialRequest $request)
    {
        $message = 'Đã thêm mới thành công social.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'title'             =>  $request->title,
            'select_link'       =>  $request->select_link,
            'link'              =>  $request->link,
            'link_title'        =>  $request->link_title,
            'icon_default'      =>  $request->icon_default,
            'images'            =>  $request->images,
            'title_image'       =>  $request->title_image,
            'alt_image'         =>  $request->alt_image,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            ConfigSocial::create( $data );

            return redirect()->route('configSocial.index')->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('configSocial.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConfigSocial  $configSocial
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigSocial $configSocial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConfigSocial  $configSocial
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigSocial $configSocial)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Social';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về social này. Vui lòng thử lại.';

        if( ConfigSocial::checkExists( $configSocial->id ) ) {
            $data['configSocial']       = $configSocial;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('configSocial.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigSocialRequest  $request
     * @param  \App\ConfigSocial  $configSocial
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConfigSocialRequest $request, ConfigSocial $configSocial)
    {
        $message        = 'Đã cập nhật social thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $configSocial ) {

            $user_id = $this->getUserData()->id ?? $configSocial->created_by;

            $data = [
                'title'             =>  $request->title,
                'select_link'       =>  $request->select_link,
                'link'              =>  $request->link,
                'link_title'        =>  $request->link_title,
                'icon_default'      =>  $request->icon_default,
                'images'            =>  $request->images,
                'title_image'       =>  $request->title_image,
                'alt_image'         =>  $request->alt_image,
                'updated_by'        =>  $user_id,
            ];

            try{
                $configSocial->update( $data );

                return redirect('admin/configSocial/'. $configSocial->id .'/edit')->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect('admin/configSocial/'. $configSocial->id .'/edit')->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConfigSocial  $configSocial
     * @return \Illuminate\Http\Response
     */
    /*
    public function destroy(ConfigSocial $configSocial)
    {
        $message = 'Xóa thành công.';
        $configSocial->delete();

        return redirect()->route('configSocial.index')->with('message', $message);

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
        $configSocial = ConfigSocial::find($id);

        $data = [
            'status'    =>  -2
        ];

        $configSocial->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

    public function viewSocialClick($id){
        $data = new Collection();
        $data->title   = 'Lịch Sử Click Social';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'view_click';
        $data->content = $this->content;

        $data['socialClicks']  = ConfigSocialClick::getSocialClick( $id );

        return View($data->view,compact('data'));

    }

    /**
     * Hide Social.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function hideSocial($id){
        $message_on  = 'Đã bật thành công.';
        $message_off = 'Đã tắt thành công.';
        $error       = 'Đã có lỗi xảy ra. Xin vui lòng thử lại';
        try {
            $social = ConfigSocial::find($id);
            if($social->hide_social == "1"){
                $social->hide_social = 0;
                $message = $message_off;
            }
            else{
                $social->hide_social = 1;
                $message = $message_on;
            }
            $social->save();

            return response()->json(['message' => $message], 200);

        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['error' => $error], 200);
        }

    }

}
