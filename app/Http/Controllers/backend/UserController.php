<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\User;
use App\Models\backend\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreUserRequest;
use Auth;
use File;
use App\Services\ImageService;

class UserController extends Controller
{
    protected $user  = NULL;
    protected $limit = 5;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.user.';
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
        $data->title   = 'Danh Sách Admin';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['users'] = User::searchUser($data->keyword, $this->limit);
        }else {
            $data['users'] = User::listUser(NULL, 'admin');
        }

        return View($data->view,compact('data'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexEmployee()
    {
        $data = new Collection();
        $data->title   = 'Danh Sách Nhân Viên';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['users'] = User::searchUser($data->keyword, $this->limit);
        }else {
            $data['users'] = User::listUser(NULL, 'employee');
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
        $data->title   = 'Thêm Mới User';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $message = 'Đã thêm mới thành công user.';

        $user_id = $this->getUserData()->id ?? 1;

        $request->birthday = str_replace('/','-',$request->birthday);

        $birthday = !empty( $request->birthday ) ? date_format( date_create( $request->birthday ),"Y-m-d") : "";

        $data = [
            'name'             =>  $request->name,
            'avatar'           =>  $request->avatar,
            'fullname'         =>  $request->fullname,
            'email'            =>  $request->email,
            'password'         =>  bcrypt( $request->password ),
            'phone'            =>  $request->phone,
            'birthday'         =>  $birthday,
            'address'          =>  $request->address,
            'created_by'       =>  $user_id,
            'status'           =>  1,
        ];

        try{
            ConfigLogo::create( $data );

            return redirect()->route('user.index')->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('user.index')->with('error', $error);
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
    public function edit($id)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật User';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về user này. Vui lòng thử lại.';

        if( User::checkExists( $id ) ) {
            $user           = User::find($id);
            $data['user']   = $user;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('user.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserRequest $request, $id)
    {
        $message        = 'Đã cập nhật user thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( User::checkExists( $id ) ) {
            $user           = User::find($id);

            $user_id = $this->getUserData()->id ?? $user->created_by;
            
            $request->birthday = str_replace('/','-',$request->birthday);
            
            $birthday = !empty( $request->birthday ) ? date_format( date_create( $request->birthday ),"Y-m-d") : "";

            $data = [
                'name'             =>  $request->name,
                'avatar'           =>  $request->avatar,
                'fullname'         =>  $request->fullname,
                'email'            =>  $request->email,
                'phone'            =>  $request->phone,
                'birthday'         =>  $birthday,
                'address'          =>  $request->address,
                'updated_by'       =>  $user_id,
            ];

            if( !empty( $request->password ) ) {
                $data['password']  = bcrypt( $request->password );
            }

            try{
                $user->update( $data );

                return redirect('admin/user/'. $user->id .'/edit')->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect('admin/user/'. $user->id .'/edit')->with('error', $error);
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
        $user = User::find($id);

        $data = [
            'status'    =>  -2
        ];

        $user->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }
}
