<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Agency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreAgencyRequest;
use Auth;
use File;
use App\Services\ImageService;

class AgencyController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $cat 	 = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.agency.';
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
        $data->title   = 'Danh Sách Đại Lý';
        $data->keyword = $this->keyword;
        $data->cat 	   = $this->cat;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        $data['agencies'] = Agency::listAgency(Null, true, $this->limit);

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
        $data->title   = 'Thêm Mới Đại Lý';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAgencyRequest $request)
    {
        $message = 'Đã thêm mới thành công bài viết.';
        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'name'              =>  $request->name,
            'password'          =>  md5($request->password),
            'phone'             =>  $request->phone,
            'email'             =>  $request->email,
            'address'           =>  $request->address,
            'bank_code'         =>  $request->bank_code,
            'tax_code'          =>  $request->tax_code,
            'user_name'         =>  $request->user_name,
            'user_phone'        =>  $request->user_phone,
            'user_date'         =>  $request->user_date,
            'created_by'        =>  $user_id,
            'status'            =>  (int)$request->status
        ];

        try{
            $create_post = Agency::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('agency.index')->with('message', $message);
            }

            return redirect()->route('agency.edit',$create_post->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('agency.index')->with('error', $error);
        }
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
    public function edit(Agency $agency)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Đại Lý';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về bài viết này. Vui lòng thử lại.';
        $data['url_id'] = $url->id ?? '';

        if( Agency::checkExists( $agency->id ) ) {
            $data['agency']       = $agency;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('agency.index')->with('error', $error);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAgencyRequest $request, Agency $agency)
    {
        $message        = 'Đã cập nhật bài viết thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $agency ) {
            $user_id = $this->getUserData()->id ?? $agency->created_by;

            $data = [
                'name'              =>  $request->name,
                'phone'             =>  $request->phone,
                'email'             =>  $request->email,
                'address'           =>  $request->address,
                'bank_code'         =>  $request->bank_code,
                'tax_code'          =>  $request->tax_code,
                'user_name'         =>  $request->user_name,
                'user_phone'        =>  $request->user_phone,
                'user_date'         =>  $request->user_date,
                'created_by'        =>  $user_id,
                'status'            =>  (int)$request->status
            ];

            if(!empty($request->password)){
                $data['password'] = md5($request->password);
            }

            try{
                $update_post = $agency->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('agency.index',$agency->id)->with('message', $message);
                }

                return redirect()->route('agency.edit',$agency->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect()->route('agency.edit',$agency->id)->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

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
        $post = Agency::find($id);

        $data = [
            'status'    =>  -2
        ];

        $agency_delete = $post->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

    public function delete( $id )
    {
        $message            = 'Xóa thành công.';
        $error_not_exist    = 'Lỗi khi xóa dữ liệu, hoặc dữ liệu không tồn tại. Vui lòng thử lại.';
        $error_save         = "Có lỗi xảy ra trong quá trình xóa dữ liệu. Vui lòng thử lại.";
        $agency = Agency::find($id);

        if( $agency ) {
            $data = [
                'status'    =>  -2
            ];
            try{
                $delete_agency = $agency->update( $data );

                return redirect()->route('agency.index')->with('message', $message);

            }catch(\Exception $e){
                return redirect()->route('agency.index')->with('error', $error_save);

            }

        }else {
            return back()->with('error', $error_not_exist);

        }

    }
}
