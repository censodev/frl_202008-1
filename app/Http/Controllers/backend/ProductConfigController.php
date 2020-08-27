<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\ProductConfig;
use App\Models\backend\Color;
use App\Models\backend\Material;
use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Auth;
use File;
use App\Services\ImageService;

class ProductConfigController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $cat 	 = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.productConfig.';
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
        $data->title   = 'Danh Sách Bài Viết';
        $data->keyword = $this->keyword;
        $data->cat 	   = $this->cat;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';

        $data->content = $this->content;

        $data['colors'] = Color::all();
        $data['materials'] = Material::all();

        return View($data->view,compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message        = 'Đã cập nhật sản phẩm thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';
        $user_id = $this->getUserData()->id ?? 1;


        $data_material = [
            'material_id'        => $request->material_id,
            'name'               => $request->material_name,
        ];

        $data_color = [
            'color_id'        => $request->color_id,
            'name'           => $request->color_name,
            'value'           => $request->color_value,
        ];

        //update vật liệu
        if( !empty($data_material['material_id']) && count($data_material['material_id']) >0 ) {
            foreach ($data_material['material_id'] as $key => $item) {
                $data_item = [
                    'name' => $data_material['name'][$key],
                    'created_by' => $user_id,
                    'status' => 1,
                ];

                //nếu tồn tại id thì update
                if ($item != null) {
                    Material::where('id', $item)->update($data_item);
                } else {
                    //chưa có id thì tạo mới
                    Material::create($data_item);
                }
            }
        }

        //xoá vật liệu
        $list_material = Material::all();
        $array_id = [];

        if(!empty($list_material) && count($list_material) > 0){
            foreach ($list_material as $key => $item){
                $array_id[] = $item->id;
            }
        }
        if(!empty($array_id) && count($array_id) > 0){
            foreach ($array_id as $key => $item){
                if(!in_array( (string) $item, $data_material['material_id']) ){
                    Material::where('id',$item)->delete();
                }
            }
        }


        if( $request->save_and_exits == 2 ) {
            return redirect()->route('productConfig.index')->with('message', $message);
        }
        return redirect()->route('productConfig.index')->with('message', $message);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductConfig $productConfig)
    {
        $data = new Collection();
        $data->title   = 'Cấu Hình Sản Phẩm';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về cấu hình này. Vui lòng thử lại.';

        if( ProductConfig::checkExists( $productConfig->id ) ) {
            $data['productConfig'] = $productConfig;
            return View($data->view,compact('data'));
        }else {
            return redirect()->route('productConfig.index')->with('error', $error);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductConfig $productConfig)
    {

        $message        = 'Đã cập nhật bài viết thành công.';
        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'material'              =>  $request->material,
            'name_color'            =>  $request->name_color,
            'value_color'           =>  $request->value_color
        ];

        $color = [];
        foreach ($data['name_color'] as $key => $item_name){
            $item = [
                'name_color'  => $item_name,
                'value_color' => $data['value_color'][$key]
            ];
            $color[] = $item;
        }

        $data_insert = [
            'material'              =>  serialize($request->material),
            'color'                 =>  serialize($color),
            'created_by'            =>  $user_id,
            'status'                =>  1
        ];

        try{
            $productConfig->update( $data_insert );

            return redirect()->route('productConfig.edit',$productConfig->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();
            return redirect()->route('productConfig.edit')->with('error', $error);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
