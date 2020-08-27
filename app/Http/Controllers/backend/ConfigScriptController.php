<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\ConfigScript;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreConfigScriptRequest;
use Auth;
use File;
use App\Services\ImageService;

class ConfigScriptController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.configScript.';
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
        $data->title   = 'Danh Sách Script, Style';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['configScripts'] = ConfigScript::searchConfigScript($data->keyword,$this->limit);
        }else {
            $data['configScripts'] = ConfigScript::listConfigScript(Null, true, $this->limit);
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
        $data->title   = 'Thêm Mới Script, Style';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigScriptRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConfigScriptRequest $request)
    {
        $message = 'Đã thêm mới thành công script, style.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'title'             =>  $request->title,
            'script_head'       =>  $request->script_head,
            'script_body'       =>  $request->script_body,
            'script_footer'     =>  $request->script_footer,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            ConfigScript::create( $data );

            return redirect()->route('configScript.index')->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('configScript.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConfigScript  $configScript
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigScript $configScript)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConfigScript  $configScript
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigScript $configScript)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Script, Style';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về script, style này. Vui lòng thử lại.';

        if( ConfigScript::checkExists( $configScript->id ) ) {
            $data['configScript']       = $configScript;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('configScript.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigScriptRequest  $request
     * @param  \App\ConfigScript  $configScript
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConfigScriptRequest $request, ConfigScript $configScript)
    {
        $message        = 'Đã cập nhật script, style thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $configScript ) {

            $user_id = $this->getUserData()->id ?? $configScript->created_by;

            $data = [
                'title'             =>  $request->title,
                'script_head'       =>  $request->script_head,
                'script_body'       =>  $request->script_body,
                'script_footer'     =>  $request->script_footer,
                'updated_by'        =>  $user_id,
            ];

            try{
                $configScript->update( $data );

                return redirect('admin/configScript/'. $configScript->id .'/edit')->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect('admin/configScript/'. $configScript->id .'/edit')->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConfigScript  $configScript
     * @return \Illuminate\Http\Response
     */
    /*
    public function destroy(ConfigScript $configScript)
    {
        $message = 'Xóa thành công.';
        $configScript->delete();

        return redirect()->route('configScript.index')->with('message', $message);

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
        $configScript = ConfigScript::find($id);

        $data = [
            'status'    =>  -2
        ];

        $configScript->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

}
