<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\ConfigSeo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreConfigSeoRequest;
use Auth;
use File;
use App\Services\ImageService;

class ConfigSeoController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.configSeo.';
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new Collection();
        $data->title   = 'Danh Sách Seo Website';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['configSeos'] = ConfigSeo::searchConfigSeo($data->keyword,$this->limit);
        }else {
            $data['configSeos'] = ConfigSeo::listConfigSeo(Null, true, $this->limit);
        }

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
        $data->title   = 'Thêm Mới Seo Website';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param   App\Http\Requests\StoreConfigSeoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConfigSeoRequest $request)
    {
        $message = 'Đã thêm mới thành công seo website.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'title'             =>  $request->title,
            'seo_title'         =>  $request->seo_title,
            'seo_description'   =>  $request->seo_description,
            'seo_keywords'      =>  $request->seo_keywords,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            ConfigSeo::create( $data );

            return redirect()->route('configSeo.index')->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('configSeo.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConfigSeo  $configSeo
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigSeo $configSeo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConfigSeo  $configSeo
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigSeo $configSeo)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Seo Website';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về seo website này. Vui lòng thử lại.';

        if( ConfigSeo::checkExists( $configSeo->id ) ) {
            $data['configSeo']       = $configSeo;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('configSeo.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigSeoRequest  $request
     * @param  \App\ConfigSeo  $configSeo
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConfigSeoRequest $request, ConfigSeo $configSeo)
    {
        $message        = 'Đã cập nhật seo website thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $configSeo ) {

            $user_id = $this->getUserData()->id ?? $configSeo->created_by;

            $data = [
                'title'             =>  $request->title,
                'seo_title'         =>  $request->seo_title,
                'seo_description'   =>  $request->seo_description,
                'seo_keywords'      =>  $request->seo_keywords,
                'updated_by'        =>  $user_id,
            ];

            try{
                $configSeo->update( $data );

                return redirect('admin/configSeo/'. $configSeo->id .'/edit')->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect('admin/configSeo/'. $configSeo->id .'/edit')->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConfigSeo  $configSeo
     * @return \Illuminate\Http\Response
     */
    /*
    public function destroy(ConfigSeo $configSeo)
    {
        $message = 'Xóa thành công.';
        $configSeo->delete();

        return redirect()->route('configSeo.index')->with('message', $message);

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
        $configSeo = ConfigSeo::find($id);

        $data = [
            'status'    =>  -2
        ];

        $configSeo->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

}
