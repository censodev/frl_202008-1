<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\ConfigEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreConfigEmailRequest;
use Auth;
use File;
use App\Services\ImageService;

class ConfigEmailController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.configEmail.';
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
        $data->title   = 'Danh Sách Email';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['configEmails'] = ConfigEmail::searchConfigEmail($data->keyword,$this->limit);
        }else {
            $data['configEmails'] = ConfigEmail::listConfigEmail(Null, true, $this->limit);
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
        $data->title   = 'Thêm Mới Email';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigEmailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConfigEmailRequest $request)
    {
        $message = 'Đã thêm mới thành công email.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'title'          =>  $request->title,
            'smtp_title'     =>  $request->smtp_title,
            'smtp_email'     =>  $request->smtp_email,
            'smtp_pass'      =>  $request->smtp_pass,
            'smtp_port'      =>  $request->smtp_port,
            'smtp_host'      =>  $request->smtp_host,
            'smtp_content'   =>  $request->smtp_content,
            'smtp_content_cart'   =>  $request->smtp_content_cart,
            'created_by'     =>  $user_id,
            'status'         =>  1,
        ];

        try{
            ConfigEmail::create( $data );

            return redirect()->route('configEmail.index')->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('configEmail.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConfigEmail  $configEmail
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigEmail $configEmail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConfigEmail  $configEmail
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigEmail $configEmail)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Email';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về email này. Vui lòng thử lại.';

        if( ConfigEmail::checkExists( $configEmail->id ) ) {
            $data['configEmail']       = $configEmail;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('configEmail.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigEmailRequest  $request
     * @param  \App\ConfigEmail  $configEmail
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConfigEmailRequest $request, ConfigEmail $configEmail)
    {
//        dd($request->smtp_content_cart);

        $message        = 'Đã cập nhật liên hệ thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $configEmail ) {

            $user_id = $this->getUserData()->id ?? $configEmail->created_by;

            $data = [
                'title'             =>  $request->title,
                'smtp_title'     =>  $request->smtp_title,
                'smtp_email'     =>  $request->smtp_email,
                'smtp_pass'      =>  $request->smtp_pass,
                'smtp_port'      =>  $request->smtp_port,
                'smtp_host'      =>  $request->smtp_host,
                'smtp_content'   =>  $request->smtp_content,
                'smtp_content_cart'   =>  $request->smtp_content_cart,
                'updated_by'        =>  $user_id,
            ];

            try{
                $configEmail->update( $data );

                return redirect('admin/configEmail/'. $configEmail->id .'/edit')->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect('admin/configEmail/'. $configEmail->id .'/edit')->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConfigEmail  $configEmail
     * @return \Illuminate\Http\Response
     */
    /*
    public function destroy(ConfigEmail $configEmail)
    {
        $message = 'Xóa thành công.';
        $configEmail->delete();

        return redirect()->route('configEmail.index')->with('message', $message);

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
        $configEmail = ConfigEmail::find($id);

        $data = [
            'status'    =>  -2
        ];

        $configEmail->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }
}
