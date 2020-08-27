<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\ConfigFooter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreConfigFooterRequest;
use Auth;
use File;
use App\Services\ImageService;

class ConfigFooterController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.configFooter.';
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
        $data->title   = 'Danh Sách Footer';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['configFooters'] = ConfigFooter::searchConfigFooter($data->keyword,$this->limit);
        }else {
            $data['configFooters'] = ConfigFooter::listConfigFooter(Null, true, $this->limit);
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
        $data->title   = 'Thêm Mới Footer';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigFooterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConfigFooterRequest $request)
    {
        $message = 'Đã thêm mới thành công footer.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'title'                 =>  $request->title,
            'footer_title'          =>  Genratejsonarray( $request->footer_title ),
            'footer_description'    =>  Genratejsonarray( $request->footer_description ),
            'footer_contact_info'   =>  Genratejsonarray( $request->footer_contact_info ),
            'footer_copyright'      =>  $request->footer_copyright,
            'created_by'            =>  $user_id,
            'status'                =>  1,
        ];

        try{
            ConfigFooter::create( $data );

            return redirect()->route('configFooter.index')->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('configFooter.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConfigFooter  $configFooter
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigFooter $configFooter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConfigFooter  $configFooter
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigFooter $configFooter)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Footer';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về footer này. Vui lòng thử lại.';

        if( configFooter::checkExists( $configFooter->id ) ) {
            $data['configFooter']       = $configFooter;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('configFooter.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigFooterRequest  $request
     * @param  \App\ConfigFooter  $configFooter
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConfigFooterRequest $request, ConfigFooter $configFooter)
    {
        $message        = 'Đã cập nhật footer thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $configFooter ) {

            $user_id = $this->getUserData()->id ?? $configFooter->created_by;

            $data = [
                'title'                 =>  $request->title,
                'footer_title'          =>  Genratejsonarray( $request->footer_title ),
                'footer_description'    =>  Genratejsonarray( $request->footer_description ),
                'footer_contact_info'   =>  Genratejsonarray( $request->footer_contact_info ),
                'footer_copyright'      =>  $request->footer_copyright,
                'updated_by'            =>  $user_id,
            ];

            try{
                $configFooter->update( $data );

                return redirect('admin/configFooter/'. $configFooter->id .'/edit')->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect('admin/configFooter/'. $configFooter->id .'/edit')->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConfigFooter  $configFooter
     * @return \Illuminate\Http\Response
     */
    /*
    public function destroy(ConfigFooter $configFooter)
    {
        $message = 'Xóa thành công.';
        $configFooter->delete();

        return redirect()->route('configFooter.index')->with('message', $message);

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
        $configFooter = ConfigFooter::find($id);

        $data = [
            'status'    =>  -2
        ];

        $configFooter->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

}
