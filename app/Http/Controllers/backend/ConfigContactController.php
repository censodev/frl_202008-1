<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\ConfigContact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreConfigContactRequest;
use Auth;
use File;
use App\Services\ImageService;

class ConfigContactController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.configContact.';
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
        $data->title   = 'Danh Sách Liên Hệ';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['configContacts'] = ConfigContact::searchConfigContact($data->keyword,$this->limit);
        }else {
            $data['configContacts'] = ConfigContact::listConfigContact(Null, true, $this->limit);
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
        $data->title   = 'Thêm Mới Liên Hệ';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConfigContactRequest $request)
    {
        $message = 'Đã thêm mới thành công liên hệ.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'title'                 =>  $request->title,
            'title_contact'         =>  $request->title_contact,
            'images_background'     =>  $request->images_background,
            'google_map'            =>  $request->google_map,
            'description'           =>  $request->description,
            'title_contact_info'    =>  $request->title_contact_info,
            'description_info'      =>  $request->description_info,
            'contact_info'          =>  Genratejsonarray( $request->contact_info ),
            'created_by'            =>  $user_id,
            'status'                =>  1,
        ];

        try{
            ConfigContact::create( $data );

            return redirect()->route('configContact.index')->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('configContact.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConfigContact  $configContact
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigContact $configContact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConfigContact  $configContact
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigContact $configContact)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Liên Hệ';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về liên hệ này. Vui lòng thử lại.';

        if( ConfigContact::checkExists( $configContact->id ) ) {
            $data['configContact']       = $configContact;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('configContact.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigContactRequest  $request
     * @param  \App\ConfigContact  $configContact
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConfigContactRequest $request, ConfigContact $configContact)
    {
        $message        = 'Đã cập nhật liên hệ thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $configContact ) {

            $user_id = $this->getUserData()->id ?? $configContact->created_by;

            $data = [
                'title'                 =>  $request->title,
                'title_contact'         =>  $request->title_contact,
                'images_background'     =>  $request->images_background,
                'google_map'            =>  $request->google_map,
                'description'           =>  $request->description,
                'title_contact_info'    =>  $request->title_contact_info,
                'description_info'      =>  $request->description_info,
                'contact_info'          =>  Genratejsonarray( $request->contact_info ),
                'updated_by'        =>  $user_id,
            ];

            try{
                $configContact->update( $data );

                return redirect('admin/configContact/'. $configContact->id .'/edit')->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect('admin/configContact/'. $configContact->id .'/edit')->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConfigContact  $configContact
     * @return \Illuminate\Http\Response
     */
    /*
    public function destroy(ConfigContact $configContact)
    {
        $message = 'Xóa thành công.';
        $configContact->delete();

        return redirect()->route('configContact.index')->with('message', $message);

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
        $configContact = ConfigContact::find($id);

        $data = [
            'status'    =>  -2
        ];

        $configContact->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }
}
