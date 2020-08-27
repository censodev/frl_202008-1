<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StorePartnerRequest;
use Auth;
use File;
use App\Services\ImageService;

class PartnerController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.partner.';
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
        $data->title   = 'Danh Sách Đối Tác';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['partners'] = Partner::searchPartner($data->keyword, $this->limit);
        }else {
            $data['partners'] = Partner::listPartner(Null, true, $this->limit);
        }
		
		$data['keyword'] = $data->keyword;
		$data['create_new'] = route('partner.create');

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
        $data->title   = 'Thêm Mới Đối Tác';
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
    public function store(StorePartnerRequest $request)
    {
        $message = 'Đã thêm mới thành công đối tác.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'name'              =>  $request->name,
            'link'              =>  $request->link,
            'link_title'        =>  $request->link_title,
            'images'            =>  $request->images,
            'title_image'       =>  $request->title_image,
            'alt_image'         =>  $request->alt_image,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            $create_partner =  Partner::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('partner.index')->with('message', $message);
            }

            return redirect()->route('partner.edit',$create_partner->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('partner.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Đối Tác';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về đối tác này. Vui lòng thử lại.';

        if( Partner::checkExists( $partner->id ) ) {
            $data['partner']       = $partner;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('partner.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(StorePartnerRequest $request, Partner $partner)
    {
        $message        = 'Đã cập nhật đối tác thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $partner ) {

            $user_id = $this->getUserData()->id ?? $partner->created_by;

            $data = [
                'name'              =>  $request->name,
                'link'              =>  $request->link,
                'link_title'        =>  $request->link_title,
                'images'            =>  $request->images,
                'title_image'       =>  $request->title_image,
                'alt_image'         =>  $request->alt_image,
                'updated_by'        =>  $user_id,
            ];

            try{
                $partner->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('partner.index')->with('message', $message);
                }

                return redirect()->route('partner.edit',$partner->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect()->route('partner.edit',$partner->id)->with('error', $error);
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
        $partner = Partner::find($id);

        $data = [
            'status'    =>  -2
        ];

        $partner->update( $data );

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

        $partners          = Partner::searchPartner($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "partner";
        $html           = View($data->view, compact("partners",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

}
