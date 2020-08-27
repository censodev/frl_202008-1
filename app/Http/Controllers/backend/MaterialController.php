<?php

namespace App\Http\Controllers\backend;

use App\Http\Requests\StoreMaterialRequest;
use App\Models\backend\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreColorRequest;
use Auth;
use File;
use App\Services\ImageService;

class MaterialController extends Controller
{
    protected $user  = NULL;
    protected $limit = 10;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.material.';
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
        $data->title   = 'Danh Sách Vật Liệu';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['materials'] = Material::searchMaterial($data->keyword, $this->limit);
        }else {
            $data['materials'] = Material::listMaterial(Null, true, $this->limit);
        }

        $data['keyword'] = $data->keyword;
        $data['create_new'] = route('material.create');

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
        $data->title   = 'Thêm Mới Vật Liệu';
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
    public function store(StoreMaterialRequest $request)
    {
        $message = 'Đã thêm mới thành công vật liệu.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'name'              =>  $request->name,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            $create_material =  Material::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('material.index')->with('message', $message);
            }
            return redirect()->route('material.edit',$create_material->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('material.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Vật Liệu';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về vật liệu này. Vui lòng thử lại.';

        if( Material::checkExists( $material->id ) ) {
            $data['material']       = $material;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('material.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMaterialRequest $request, Material $material)
    {
        $message        = 'Đã cập nhật màu thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $material ) {

            $user_id = $this->getUserData()->id ?? $material->created_by;

            $data = [
                'name'              =>  $request->name,
                'updated_by'        =>  $user_id,
            ];

            try{
                $material->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('material.index')->with('message', $message);
                }
                return redirect()->route('material.edit',$material->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();
                return redirect()->route('material.edit',$material->id)->with('error', $error);
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
        $material = Material::find($id);

        $data = [
            'status'    =>  -2
        ];

        $material->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

}
