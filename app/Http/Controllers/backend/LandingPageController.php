<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Category;
use App\Models\backend\LandingPage;
use App\Models\backend\Post;
use App\Models\backend\Product;
use App\Models\backend\Gallery;
use App\Models\backend\Slider;
use App\Models\backend\Team;
use App\Models\backend\Partner;
use App\Models\backend\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreLandingPageRequest;
use Auth;
use File;
use App\Services\ImageService;

class LandingPageController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.landingPage.';
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
        $data->title   = 'Danh Sách LandingPage';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['landingPages'] = LandingPage::searchLandingPage($data->keyword,$this->limit);
        }else {
            $data['landingPages'] = LandingPage::listsearchLandingPage(Null, true, $this->limit);
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
        $data->title   = 'Thêm Mới LandingPage';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        $data['category_level'] = Category::getCategoryPostLevel();

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreLandingPageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLandingPageRequest $request)
    {
        $message = 'Đã thêm mới thành công landingPage.';

        $user_id = $this->getUserData()->id ?? 1;

        if( !empty( $request->alias ) ) {
            $alias = $request->alias;
        }else {
            $alias = $request->title;
        }
        $alias = utf8tourl( $alias );

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
            'category_id'           =>  $request->category_id,
            'alias'                 =>  $alias,
            'images'                =>  $request->images,
            'title_image'           =>  $request->title_image,
            'alt_image'             =>  $request->alt_image,
            'seo_title'             =>  $request->seo_title,
            'seo_desciption'        =>  $request->seo_desciption,
            'seo_keyword'           =>  $request->seo_keyword,
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
            'title_partner'         =>  $request->title_partner,
            'related_partner'       =>  $related_partner,
            'created_by'            =>  $user_id,
            'status'                =>  1,
        ];

        try{
            $create_landing = LandingPage::create( $data );

            if( $create_landing ) {
                $data_url = [
                    'url'       =>  $alias,
                    'module'    =>  'LandingPage',
                    'action'    =>  'LandingPageDetail',
                    'object_id' =>  $create_landing->id,
                ];
                Url::create( $data_url );
            }

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('landingPage.index')->with('message', $message);
            }

            return redirect()->route('landingPage.edit',$create_landing->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('landingPage.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\HomepageManager  $homepageManager
     * @return \Illuminate\Http\Response
     */
    public function show(LandingPage $landingPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\LandingPage  $landingPage
     * @return \Illuminate\Http\Response
     */
    public function edit(LandingPage $landingPage)
    {
        $data = new Collection();
        $data->title   = 'Cập LandingPage';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về landingPage này. Vui lòng thử lại.';

        if( LandingPage::checkExists( $landingPage->id ) ) {

            $data['landingPage']           = $landingPage;
            $data['category_level'] = Category::getCategoryPostLevel();

            $relatedSliderIds = $data['related_sliders'] = [];
            if(isset($landingPage->related_slider) && !empty($landingPage->related_slider)) {

                $relatedSliderIds           = json_decode($landingPage->related_slider,true);
                $data['related_sliders']    = Slider::whereIn('id', $relatedSliderIds)
                    ->where('status',1)
                    ->get();

            }

            $relatedPostServiceIds = $data['related_posts_service'] = [];
            if(isset($landingPage->related_post_service) && !empty($landingPage->related_post_service)) {

                $relatedPostServiceIds           = json_decode($landingPage->related_post_service,true);
                $data['related_posts_service']   = Post::whereIn('id', $relatedPostServiceIds)
                    ->where('status',1)
                    ->get();

            }

            $services_name = $data['services_name'] = [];
            if(isset($landingPage->services_name) && !empty($landingPage->services_name)) {

                $data['services_name']   = json_decode($landingPage->services_name,true);
                $data['services_url']    = json_decode($landingPage->services_url,true);
                $data['services_description'] = json_decode($landingPage->services_description,true);
            }

            $relatedProductHotIds = $data['related_products_hot'] = [];
            if(isset($landingPage->related_product_hot) && !empty($landingPage->related_product_hot)) {

                $relatedProductHotIds          = json_decode($landingPage->related_product_hot,true);
                $data['related_products_hot']   = Product::whereIn('id', $relatedProductHotIds)
                    ->where('status',1)
                    ->get();

            }

            $relatedProductSaleIds = $data['related_products_sale'] = [];
            if(isset($landingPage->related_product_sale) && !empty($landingPage->related_product_sale)) {

                $relatedProductSaleIds          = json_decode($landingPage->related_product_sale,true);
                $data['related_products_sale']   = Product::whereIn('id', $relatedProductSaleIds)
                    ->where('status',1)
                    ->get();

            }

            $relatedProductSellingIds = $data['related_products_selling'] = [];
            if(isset($landingPage->related_product_selling) && !empty($landingPage->related_product_selling)) {

                $relatedProductSellingIds          = json_decode($landingPage->related_product_selling,true);
                $data['related_products_selling']   = Product::whereIn('id', $relatedProductSellingIds)
                    ->where('status',1)
                    ->get();

            }

            $relatedGalleryIds = $data['related_galleries'] = [];
            if(isset($landingPage->related_gallery) && !empty($landingPage->related_gallery)) {

                $relatedGalleryIds          = json_decode($landingPage->related_gallery,true);
                $data['related_galleries']  = Gallery::whereIn('id', $relatedGalleryIds)
                    ->where('status',1)
                    ->get();

            }

            $relatedTeamIds = $data['related_teams'] = [];
            if(isset($landingPage->related_team) && !empty($landingPage->related_team)) {

                $relatedTeamIds             = json_decode($landingPage->related_team,true);
                $data['related_teams']      = Team::whereIn('id', $relatedTeamIds)
                    ->where('status',1)
                    ->get();

            }

            $relatedPostIds = $data['related_posts'] = [];
            if(isset($landingPage->related_post) && !empty($landingPage->related_post)) {

                $relatedPostIds             = json_decode($landingPage->related_post,true);
                $data['related_posts']      = Post::whereIn('id', $relatedPostIds)
                    ->where('status',1)
                    ->get();

            }

            $relatedPartnerIds = $data['related_partners'] = [];
            if(isset($landingPage->related_partner) && !empty($landingPage->related_partner)) {

                $relatedPartnerIds          = json_decode($landingPage->related_partner,true);
                $data['related_partners']   = Partner::whereIn('id', $relatedPartnerIds)
                    ->where('status',1)
                    ->get();

            }

            $data['landingPage']        = $landingPage;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('landingPage.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreLandingPageRequest  $request
     * @param  \App\Models\backend\LandingPage  $landingPage
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLandingPageRequest $request, LandingPage $landingPage)
    {
        $message        = 'Đã cập nhật landingPage thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $landingPage ) {
            $alias_old   = $landingPage->alias;

            if( !empty( $request->alias ) ) {
                $alias = $request->alias;
            }else {
                $alias = $request->title;
            }

            $alias = utf8tourl( $alias );

            $user_id = $this->getUserData()->id ?? $landingPage->created_by;

            $related_slider  = !empty( $request->related_slider ) ? Genratejsonarray( $request->related_slider ) : '';
            $related_post_service = !empty( $request->related_post_service ) ? Genratejsonarray( $request->related_post_service ) : '';
            $services_name = !empty($request->services_name) ? Genratejsonarray($request->services_name): "";
            $services_url = !empty($request->services_url) ? Genratejsonarray($request->services_url): "";
            $services_description = !empty($request->services_description) ? Genratejsonarray($request->services_description): "";
            $why_title          = !empty( $request->why_title ) ? Genratejsonarray( $request->why_title ) : '';
            $why_icon  	        = !empty( $request->why_icon ) ? Genratejsonarray( $request->why_icon ) : '';
            $why_description    = !empty( $request->why_description ) ? Genratejsonarray( $request->why_description ) : '';
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
                'category_id'           =>  $request->category_id,
                'alias'                 =>  $alias,
                'images'                =>  $request->images,
                'title_image'           =>  $request->title_image,
                'alt_image'             =>  $request->alt_image,
                'seo_title'             =>  $request->seo_title,
                'seo_desciption'        =>  $request->seo_desciption,
                'seo_keyword'           =>  $request->seo_keyword,
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
                'services_name'         =>  $services_name,
                'services_url'          =>  $services_url,
                'services_description'  =>  $services_description,
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
                'title_partner'         =>  $request->title_partner,
                'related_partner'       =>  $related_partner,
                'updated_by'            =>  $user_id,
                'title_partner' => $request->title_partner,
                'description_partner' => $request->description_partner
            ];


            try{
                $update_landingPage = $landingPage->update( $data );

                if( $update_landingPage ) {
                    $url =  Url::findURLByModule( 'LandingPage', $request->id );

                    if( $url ) {
                        if( $alias != $alias_old ) {
                            $data_url = [
                                'url' => $alias
                            ];
                            $url->update($data_url);
                        }

                    }else {
                        $data_url = [
                            'url'       =>  $alias,
                            'module'    =>  'LandingPage',
                            'action'    =>  'LandingPageDetail',
                            'object_id' =>  $request->id,
                        ];
                        Url::create( $data_url );
                    }

                }

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('landingPage.index')->with('message', $message);
                }
                return redirect()->route('landingPage.edit',$landingPage->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();
                return redirect()->route('landingPage.index')->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\backend\LandingPage $landingPage
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
        $landingPage = LandingPage::find($id);

        $data = [
            'status'    =>  -2
        ];

        $landingPage->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

}
