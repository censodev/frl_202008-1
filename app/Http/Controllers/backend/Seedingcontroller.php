<?php

namespace App\Http\Controllers\backend;

use App\Http\Requests\StoreSeedingRequest;
use App\Models\backend\Seeding;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreBannerRequest;
use Auth;
use File;
use App\Services\ImageService;

class SeedingController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.seeding.';
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
        $data->title   = 'Danh Sách Seeding';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['seeding'] = Seeding::searchSeeding($data->keyword, $this->limit);
        }else {
            $data['seeding'] = Seeding::listSeeding(Null, true, $this->limit);
        }

        $data['keyword'] = $data->keyword;
        $data['create_new'] = route('seeding.create');

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
        $data->title   = 'Thêm Mới Seeding';
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
    public function store(StoreSeedingRequest $request)
    {
        $message = 'Đã thêm mới thành công đối tác.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'name'              =>  $request->name,
            'content'           =>  $request->content,
            'time'              =>  $request->time,
            'images'            =>  $request->images,
            'title_image'       =>  $request->title_image,
            'alt_image'         =>  $request->alt_image,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            $create_seeding =  Seeding::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('seeding.index')->with('message', $message);
            }
            return redirect()->route('seeding.edit',$create_seeding->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('seeding.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Seeding $Seeding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Seeding $seeding)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Seeding';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về seeding này. Vui lòng thử lại.';

        if( Seeding::checkExists( $seeding->id ) ) {
            $data['seeding']       = $seeding;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('seeding.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSeedingRequest $request, Seeding $seeding)
    {
        $message        = 'Đã cập nhật seeding thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $seeding ) {

            $user_id = $this->getUserData()->id ?? $seeding->created_by;

            $data = [
                'name'              =>  $request->name,
                'content'           =>  $request->content,
                'time'              =>  $request->time,
                'images'            =>  $request->images,
                'title_image'       =>  $request->title_image,
                'alt_image'         =>  $request->alt_image,
                'updated_by'        =>  $user_id,
            ];

            try{
                $seeding->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('seeding.index')->with('message', $message);
                }
                return redirect()->route('seeding.edit',$seeding->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();
                return redirect()->route('seeding.edit',$seeding->id)->with('error', $error);
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
        $seeding = Seeding::find($id);

        $data = [
            'status'    =>  -2
        ];

        $seeding->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

}
