<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Certify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreCertifyRequest;
use Auth;
use File;
use App\Services\ImageService;

class CertifyController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.certify.';
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
        $data->title   = 'Danh Sách Chứng nhận';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['certifies'] = Certify::searchCertify($data->keyword, $this->limit);
        }else {
            $data['certifies'] = Certify::listCertify(Null, true, $this->limit);
        }

        $data['keyword'] = $data->keyword;
        $data['create_new'] = route('certify.create');

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
        $data->title   = 'Thêm Mới Chứng Nhận';
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
    public function store(StoreCertifyRequest $request)
    {
        $message = 'Đã thêm mới thành công chứng nhận.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'title'             =>  $request->title,
            'images'            =>  Genratejsonarray( $request->images ),
            'title_image'       =>  Genratejsonarray( $request->title_image ),
            'alt_image'         =>  Genratejsonarray( $request->alt_image ),
            'button_title'      =>  Genratejsonarray( $request->button_title ),
            'button_link'       =>  Genratejsonarray( $request->button_link ),
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            $create_certify =  Certify::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('certify.index')->with('message', $message);
            }

            return redirect()->route('certify.edit',$create_certify->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('certify.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Certify $certify)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Certify $certify)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Chứng Nhận';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về chứng nhận này. Vui lòng thử lại.';

        if( Certify::checkExists( $certify->id ) ) {
            $data['certify']       = $certify;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('certify.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCertifyRequest $request, Certify $certify)
    {
        $message        = 'Đã cập nhật đối tác thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $certify ) {

            $user_id = $this->getUserData()->id ?? $certify->created_by;

            $data = [
                'title'             =>  $request->title,
                'images'            =>  Genratejsonarray( $request->images ),
                'title_image'       =>  Genratejsonarray( $request->title_image ),
                'alt_image'         =>  Genratejsonarray( $request->alt_image ),
                'button_title'      =>  Genratejsonarray( $request->button_title ),
                'button_link'       =>  Genratejsonarray( $request->button_link ),
                'updated_by'        =>  $user_id,
            ];

            try{
                $certify->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('certify.index')->with('message', $message);
                }

                return redirect()->route('certify.edit',$certify->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect()->route('certify.edit',$certify->id)->with('error', $error);
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
        $certify = Certify::find($id);

        $data = [
            'status'    =>  -2
        ];

        $certify->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

    /**
     * [searchRelative partner]
     * @param  Request $rq
     * @return search html
     */
    public function searchRelative(Request $rq)
    {
        $data = new Collection();
        $data->view    = $this->view.'search';

        $certifies       = Certify::searchCertify($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "certify";
        $html           = View($data->view, compact("certifies",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

}
