<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreBannerRequest;
use Auth;
use File;
use App\Services\ImageService;

class BannerController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.banner.';
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
        $data->title   = 'Danh Sách Banner';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['banners'] = Banner::searchBanner($data->keyword, $this->limit);
        }else {
            $data['banners'] = Banner::listBanner(Null, true, $this->limit);
        }

        $data['keyword'] = $data->keyword;
        $data['create_new'] = route('banner.create');

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
        $data->title   = 'Thêm Mới Banner';
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
    public function store(StoreBannerRequest $request)
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
            $create_banner =  Banner::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('banner.index')->with('message', $message);
            }
            return redirect()->route('banner.edit',$create_banner->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('banner.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Banner';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về banner này. Vui lòng thử lại.';

        if( Banner::checkExists( $banner->id ) ) {
            $data['banner']       = $banner;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('banner.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBannerRequest $request, Banner $banner)
    {
        $message        = 'Đã cập nhật banner thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $banner ) {

            $user_id = $this->getUserData()->id ?? $banner->created_by;

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
                $banner->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('banner.index')->with('message', $message);
                }
                return redirect()->route('banner.edit',$banner->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();
                return redirect()->route('banner.edit',$banner->id)->with('error', $error);
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
        $banner = Banner::find($id);

        $data = [
            'status'    =>  -2
        ];

        $banner->update( $data );

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

        $banners          = Banner::searchBanner($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "banner";
        $html           = View($data->view, compact("banners",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

}
