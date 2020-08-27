<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\ConfigLogo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreConfigLogoRequest;
use Auth;
use File;
use App\Services\ImageService;

class ConfigLogoController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.configLogo.';
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
        $data->title   = 'Danh Sách Logo';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['configLogos'] = ConfigLogo::searchConfigLogo($data->keyword,NULL,$this->limit);
        }else {
            $data['configLogos'] = ConfigLogo::listConfigLogo(Null, true, $this->limit);
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
        $data->title   = 'Thêm Mới Logo';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigLogoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConfigLogoRequest $request)
    {
        $message = 'Đã thêm mới thành công logo.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'title'             =>  $request->title,
            'link'              =>  $request->link,
            'link_title'        =>  $request->link_title,
            'images'            =>  $request->images,
            'title_image'       =>  $request->title_image,
            'alt_image'         =>  $request->alt_image,
            'type'              =>  $request->type,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            ConfigLogo::create( $data );

            return redirect()->route('configLogo.index')->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('configLogo.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConfigLogo  $configLogo
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigLogo $configLogo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConfigLogo  $configLogo
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigLogo $configLogo)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Logo';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về logo này. Vui lòng thử lại.';

        if( ConfigLogo::checkExists( $configLogo->id ) ) {
            $data['configLogo']       = $configLogo;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('configLogo.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigLogoRequest  $request
     * @param  \App\ConfigLogo  $configLogo
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConfigLogoRequest $request, ConfigLogo $configLogo)
    {
        $message        = 'Đã cập nhật logo thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $configLogo ) {

            $user_id = $this->getUserData()->id ?? $configLogo->created_by;

            $data = [
                'title'             =>  $request->title,
                'link'              =>  $request->link,
                'link_title'        =>  $request->link_title,
                'images'            =>  $request->images,
                'title_image'       =>  $request->title_image,
                'alt_image'         =>  $request->alt_image,
                'type'              =>  $request->type,
                'updated_by'        =>  $user_id,
            ];

            try{
                $configLogo->update( $data );

                return redirect('admin/configLogo/'. $configLogo->id .'/edit')->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect('admin/configLogo/'. $configLogo->id .'/edit')->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConfigLogo  $configLogo
     * @return \Illuminate\Http\Response
     */
    /*
    public function destroy(ConfigLogo $configLogo)
    {
        $message = 'Xóa thành công.';
        $configLogo->delete();

        return redirect()->route('configLogo.index')->with('message', $message);

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
        $configLogo = ConfigLogo::find($id);

        $data = [
            'status'    =>  -2
        ];

        $configLogo->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

}
