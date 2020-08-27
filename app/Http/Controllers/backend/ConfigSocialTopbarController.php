<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\ConfigSocialTopbar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreConfigSocialTopbarRequest;
use Auth;

class ConfigSocialTopbarController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.configSocialTopbar.';
    private $content = 'content';

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
        $data->title   = 'Danh Sách Social TopBar';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['configSocialTopbars'] = ConfigSocialTopbar::searchConfigSocialTopbar($data->keyword,$this->limit);
        }else {
            $data['configSocialTopbars'] = ConfigSocialTopbar::listConfigSocialTopbar(Null, true, $this->limit);
        }
		
		$data['keyword'] = $data->keyword;
		$data['create_new'] = route('configSocialTopbar.create');

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
        $data->title   = 'Thêm Mới Social TopBar';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigSocialTopbarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConfigSocialTopbarRequest $request)
    {
        $message = 'Đã thêm mới thành công social topbar.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'title'             =>  $request->title,
            'link'              =>  $request->link,
            'icon'              =>  $request->icon,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            ConfigSocialTopbar::create( $data );

            return redirect()->route('configSocialTopbar.index')->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('configSocialTopBar.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConfigSocialTopbar  $configSocialTopbar
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigSocialTopbar $configSocialTopbar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConfigSocialTopbar  $configSocialTopbar
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigSocialTopbar $configSocialTopbar)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Social TopBar';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về social topbar này. Vui lòng thử lại.';

        if( ConfigSocialTopbar::checkExists( $configSocialTopbar->id ) ) {
            $data['configSocialTopbar']       = $configSocialTopbar;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('configSocialTopbar.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigSocialTopbarRequest  $request
     * @param  \App\ConfigSocialTopbar  $configSocialTopbar
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConfigSocialTopbarRequest $request, ConfigSocialTopbar $configSocialTopbar)
    {
        $message        = 'Đã cập nhật social topbar thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $configSocialTopbar ) {

            $user_id = $this->getUserData()->id ?? $configSocialTopbar->created_by;

            $data = [
                'title'             =>  $request->title,
                'link'              =>  $request->link,
                'icon'              =>  $request->icon,
                'updated_by'        =>  $user_id,
                'image'             =>  $request->image,
            ];
            try{
                $configSocialTopbar->update( $data );        
                return redirect('admin/configSocialTopbar/'. $configSocialTopbar->id .'/edit')->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect('admin/configSocialTopbar/'. $configSocialTopbar->id .'/edit')->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConfigSocialTopbar  $configSocialTopbar
     * @return \Illuminate\Http\Response
     */
    /*
    public function destroy(ConfigSocialTopbar $configSocialTopbar)
    {
        $message = 'Xóa thành công.';
        $configSocialTopbar->delete();

        return redirect()->route('configSocialTopbar.index')->with('message', $message);

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
        $configSocialTopbar = ConfigSocialTopbar::find($id);

        $data = [
            'status'    =>  -2
        ];

        $configSocialTopbar->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

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
            $social = ConfigSocialTopbar::find($id);
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
