<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\HomepageManager;
use App\Models\backend\Post;
use App\Models\backend\Product;
use App\Models\backend\Gallery;
use App\Models\backend\Slider;
use App\Models\backend\Hot;
use App\Models\backend\Team;
use App\Models\backend\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreHomepageManagerRequest;
use Auth;
use File;
use App\Services\ImageService;

class HomepageManagerController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.homepageManager.';
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
        $data->title   = 'Danh Sách Quản Lý Trang Chủ';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['homepageManagers'] = HomepageManager::searchHomepageManager($data->keyword,$this->limit);
        }else {
            $data['homepageManagers'] = HomepageManager::listHomepageManager(Null, true, $this->limit);
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
        $data->title   = 'Thêm Mới Quản Lý Trang Chủ';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreHomepageManagerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHomepageManagerRequest $request)
    {
        $message = 'Đã thêm mới thành công quản lý trang chủ.';

        $user_id = $this->getUserData()->id ?? 1;

        $related_slider  = !empty( $request->related_slider ) ? Genratejsonarray( $request->related_slider ) : '';
        $related_post_service = !empty( $request->related_post_service ) ? Genratejsonarray( $request->related_post_service ) : '';
        $why_title            = !empty( $request->why_title ) ? Genratejsonarray( $request->why_title ) : '';
		$why_icon  	          = !empty( $request->why_icon ) ? Genratejsonarray( $request->why_icon ) : '';
        $why_description      = !empty( $request->why_description ) ? Genratejsonarray( $request->why_description ) : '';
		$related_product_hot  = !empty( $request->related_product_hot ) ? Genratejsonarray( $request->related_product_hot ) : '';
		$related_product_sale = !empty( $request->related_product_sale ) ? Genratejsonarray( $request->related_product_sale ) : '';
		$related_product_selling = !empty( $request->related_product_selling ) ? Genratejsonarray( $request->related_product_selling ) : '';
        $funfact_number  = !empty( $request->funfact_number ) ? Genratejsonarray( $request->funfact_number ) : '';
		$funfact_icon  	 = !empty( $request->funfact_icon ) ? Genratejsonarray( $request->funfact_icon ) : '';
        $funfact_description = !empty( $request->funfact_description ) ? Genratejsonarray( $request->funfact_description ) : '';
        $related_gallery = !empty( $request->related_gallery ) ? Genratejsonarray( $request->related_gallery ) : '';
        $related_team    = !empty( $request->related_team ) ? Genratejsonarray( $request->related_team ) : '';
        $related_post    = !empty( $request->related_post ) ? Genratejsonarray( $request->related_post ) : '';
        $related_partner = !empty( $request->related_partner ) ? Genratejsonarray( $request->related_partner ) : '';

        $data = [
            'title'                 =>  $request->title,
            'related_slider'        =>  $related_slider,
            'title_about'           =>  $request->title_about,
            'images_about'          =>  $request->images_about,
            'title_image_about'     =>  $request->title_image_about,
            'alt_image_about'       =>  $request->alt_image_about,
            'video_about'           =>  $request->video_about,
            'content_about'         =>  $request->content_about,
            'title_button_about'    =>  $request->title_button_about,
            'button_link_about'     =>  $request->button_link_about,
            'title_service'         =>  $request->title_service,
            'images_service'        =>  $request->images_service,
			'content_service'       =>  $request->content_service,
            'related_post_service'  =>  $related_post_service,
            'title_why'             =>  $request->title_why,
			'content_why'           =>  $request->content_why,
            'images_why'            =>  $request->images_why,
            'why_title'             =>  $why_title,
			'why_icon'        	    =>  $why_icon,
            'why_description'       =>  $why_description,
			'title_product_hot'     =>  $request->title_product_hot,
            'images_product_hot'    =>  $request->images_product_hot,
			'content_product_hot'   =>  $request->content_product_hot,
            'related_product_hot'  	=>  $related_product_hot,
			'title_product_sale'     =>  $request->title_product_sale,
            'images_product_sale'    =>  $request->images_product_sale,
			'content_product_sale'   =>  $request->content_product_sale,
			'related_product_sale'  	=>  $related_product_sale,
			'title_product_selling'     =>  $request->title_product_selling,
            'images_product_selling'    =>  $request->images_product_selling,
			'content_product_selling'   =>  $request->content_product_selling,
			'related_product_selling'  	=>  $related_product_selling,
            'title_funfact'         =>  $request->title_funfact,
			'content_funfact'       =>  $request->content_funfact,
            'images_funfact'        =>  $request->images_funfact,
            'funfact_number'        =>  $funfact_number,
			'funfact_icon'        	=>  $funfact_icon,
            'funfact_description'   =>  $funfact_description,
            'title_gallery'         =>  $request->title_gallery,
            'related_gallery'       =>  $related_gallery,
            'title_team'            =>  $request->title_team,
			'content_team'       	=>  $request->content_team,
            'images_team'           =>  $request->images_team,
            'related_team'          =>  $related_team,
            'title_feedback'        =>  $request->title_feedback,
            'content_feedback'      =>  $request->content_feedback,
            'images_feedback'       =>  $request->images_feedback,
            'title_news'            =>  $request->title_news,
            'images_news'           =>  $request->images_news,
            'related_post'          =>  $related_post,
            'related_partner'       =>  $related_partner,
            'created_by'            =>  $user_id,
            'status'                =>  1,
        ];

        try{
            HomepageManager::create( $data );

            return redirect()->route('homepageManager.index')->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('homepageManager.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\HomepageManager  $homepageManager
     * @return \Illuminate\Http\Response
     */
    public function show(HomepageManager $homepageManager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\HomepageManager  $homepageManager
     * @return \Illuminate\Http\Response
     */
    public function edit(HomepageManager $homepageManager)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Quản Lý Trang Chủ';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về quản lý trang chủ này. Vui lòng thử lại.';

        if( HomepageManager::checkExists( $homepageManager->id ) ) {

            $relatedSliderIds = $data['related_sliders'] = [];
            if(isset($homepageManager->related_slider) && !empty($homepageManager->related_slider)) {

                $relatedSliderIds           = json_decode($homepageManager->related_slider,true);
                $data['related_sliders']    = Slider::whereIn('id', $relatedSliderIds)
                    ->where('status',1)
					->get();

            }

            $relatedPartnerIds = $data['related_partners'] = [];
            if(isset($homepageManager->related_partner) && !empty($homepageManager->related_partner)) {

                $relatedPartnerIds          = json_decode($homepageManager->related_partner,true);
                $data['related_partners']   = Partner::whereIn('id', $relatedPartnerIds)
                    ->where('status',1)
					->get();

            }

            $relatedHotIds = $data['related_hots'] = [];
            if(isset($homepageManager->related_hot) && !empty($homepageManager->related_hot)) {

                $relatedHotIds = json_decode($homepageManager->related_hot, true);
                $data['related_hots'] = Hot::whereIn('id', $relatedHotIds)
                    ->where('status', 1)
                    ->get();

            }

            $data['homepageManager']        = $homepageManager;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('homepageManager.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreHomepageManagerRequest  $request
     * @param  \App\Models\backend\HomepageManager  $homepageManager
     * @return \Illuminate\Http\Response
     */
    public function update(StoreHomepageManagerRequest $request, HomepageManager $homepageManager)
    {
        $message        = 'Đã cập nhật quản lý trang chủ thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $homepageManager ) {

            $user_id = $this->getUserData()->id ?? $homepageManager->created_by;

            $related_slider  = !empty( $request->related_slider ) ? Genratejsonarray( $request->related_slider ) : '';
            $related_hot  = !empty( $request->related_hot ) ? Genratejsonarray( $request->related_hot ) : '';
            $related_hot_2  = !empty( $request->related_hot_2 ) ? Genratejsonarray( $request->related_hot_2 ) : '';
            $related_post  = !empty( $request->related_post ) ? Genratejsonarray( $request->related_post ) : '';
            $related_product_hot  = !empty( $request->related_product_hot ) ? Genratejsonarray( $request->related_product_hot ) : '';
            $related_product_sale  = !empty( $request->related_product_sale ) ? Genratejsonarray( $request->related_product_sale ) : '';
            $related_endow  = !empty( $request->related_endow ) ? Genratejsonarray( $request->related_endow ) : '';
            $related_certify  = !empty( $request->related_certify ) ? Genratejsonarray( $request->related_certify ) : '';
            $related_tv  = !empty( $request->related_tv ) ? Genratejsonarray( $request->related_tv ) : '';
            $related_newspaper  = !empty( $request->related_newspaper ) ? Genratejsonarray( $request->related_newspaper ) : '';
            $related_feedback  = !empty( $request->related_feedback ) ? Genratejsonarray( $request->related_feedback ) : '';
            $related_partner  = !empty( $request->related_partner ) ? Genratejsonarray( $request->related_partner ) : '';

            $funfact_number = !empty($request->funfact_number) ? Genratejsonarray($request->funfact_number): "";
            $funfact_icon = !empty($request->funfact_icon) ? Genratejsonarray($request->funfact_icon): "";
            $funfact_description = !empty($request->funfact_description) ? Genratejsonarray($request->funfact_description): "";

            $why_title = !empty($request->why_title) ? Genratejsonarray($request->why_title): "";
            $why_icon = !empty($request->why_icon) ? Genratejsonarray($request->why_icon): "";
            $why_description = !empty($request->why_description) ? Genratejsonarray($request->why_description): "";

            $services_name = !empty($request->services_name) ? Genratejsonarray($request->services_name): "";
            $services_url = !empty($request->services_url) ? Genratejsonarray($request->services_url): "";
            $services_description = !empty($request->services_description) ? Genratejsonarray($request->services_description): "";

            $video_hot_title = !empty($request->video_hot_title) ? Genratejsonarray($request->video_hot_title): "";
            $video_hot_embed = !empty($request->video_hot_embed) ? Genratejsonarray($request->video_hot_embed): "";

            $album_hot_title = !empty($request->album_hot_title) ? Genratejsonarray($request->album_hot_title): "";
            $album_hot_image = !empty($request->album_hot_image) ? Genratejsonarray($request->album_hot_image): "";

            $data = [
                'title'                             => $request->title,
                'related_slider'                    => $related_slider,
                'title_funfact'                     => $request->title_funfact,
                'images_funfact'                    => $request->images_funfact,
                'content_funfact'                   => $request->content_funfact,
                'funfact_number'                    => $funfact_number,
                'funfact_icon'                      => $funfact_icon,
                'funfact_description'               => $funfact_description,
                'title_hot'                         => $request->title_hot,
                'images_hot'                        => $request->images_hot,
                'description_hot'                   => $request->description_hot,
                'related_hot'                       => $related_hot,
                'title_hot_2'                       => $request->title_hot_2,
                'images_hot_2'                      => $request->images_hot_2,
                'description_hot_2'                 => $request->description_hot_2,
                'related_hot_2'                     => $related_hot_2,
                'title_post_hot'                    => $request->title_post_hot,
                'images_post_hot'                   => $request->images_post_hot,
                'content_post_hot'                  => $request->content_post_hot,
                'related_post'                      => $related_post,
                'title_product_hot'                    => $request->title_product_hot,
                'images_product_hot'                   => $request->images_product_hot,
                'content_product_hot'                  => $request->content_product_hot,
                'related_product_hot'                      => $related_product_hot,
                'title_endow'                       => $request->title_endow,
                'images_endow'                      => $request->images_endow,
                'description_endow'                 => $request->description_endow,
                'related_endow'                     => $related_endow,
                'title_service'                     => $request->title_service,
                'images_service'                    => $request->images_service,
                'content_service'                   => $request->content_service,
                'services_name'                    => $services_name,
                'services_url'                      => $services_url,
                'services_description'               => $services_description,
                'title_certify'                       => $request->title_certify,
                'images_certify'                      => $request->images_certify,
                'description_certify'                 => $request->description_certify,
                'related_certify'                     => $related_certify,
                'title_tv'                       => $request->title_tv,
                'images_tv'                      => $request->images_tv,
                'description_tv'                 => $request->description_tv,
                'related_tv'                     => $related_tv,
                'title_newspaper'                => $request->title_newspaper,
                'images_newspaper'               => $request->images_newspaper,
                'description_newspaper'          => $request->description_newspaper,
                'related_newspaper'              => $related_newspaper,
                'title_feedback'                => $request->title_feedback,
                'images_feedback'               => $request->images_feedback,
                'description_feedback'          => $request->description_feedback,
                'related_feedback'              => $related_feedback,
                'title_partner'                => $request->title_partner,
                'images_partner'               => $request->images_partner,
                'description_partner'          => $request->description_partner,
                'related_partner'              => $related_partner,

                'title_why'                     => $request->title_why,
                'content_why'                   => $request->content_why,
                'why_title'                     => $why_title,
                'why_icon'                      => $why_icon,
                'why_description'               => $why_description,

                'title_product_sale'            => $request->title_product_sale,
                'content_product_sale'          => $request->content_product_sale,
                'related_product_sale'          => $related_product_sale,

                'title_about'                   => $request->title_about,
                'content_about'                 => $request->content_about,

                'title_video_hot'               => $request->title_video_hot,
                'content_video_hot'             => $request->content_video_hot,
                'video_hot_title'               => $video_hot_title,
                'video_hot_embed'               => $video_hot_embed,

                'title_album_hot'               => $request->title_album_hot,
                'content_album_hot'             => $request->content_album_hot,
                'album_hot_title'               => $album_hot_title,
                'album_hot_image'               => $album_hot_image,

                'updated_by'                    => $user_id,
            ];
            try{
                $homepageManager->update( $data );
                if( !empty( $request->home_default ) && $request->home_default == 1 ) {
                    return redirect('admin')->with('message', $message);
                }else {
                    return redirect('admin/homepageManager/'. $homepageManager->id .'/edit')->with('message', $message);
                }

            } catch(\Exception $e){
                $error = $e->getMessage();
                if( !empty( $request->home_default ) && $request->home_default == 1 ) {
                    return redirect('admin')->with('error', $error);
                }else {
                    return redirect('admin/homepageManager/'. $homepageManager->id .'/edit')->with('error', $error);
                }

            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\backend\HomepageManager  $homepageManager
     * @return \Illuminate\Http\Response
     */
    /*
        public function destroy(HomepageManager $homepageManager)
        {
            $message = 'Xóa thành công.';
            $homepageManager->delete();

            return redirect()->route('homepageManager.index')->with('message', $message);

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
        $homepageManager = HomepageManager::find($id);

        $data = [
            'status'    =>  -2
        ];

        $homepageManager->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

}
