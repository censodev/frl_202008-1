<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Banner;
use App\Models\backend\Certify;
use App\Models\backend\Endow;
use App\Models\backend\HomepageManager;
use App\Models\backend\Hot;
use App\Models\backend\Newspaper;
use App\Models\backend\Post;
use App\Models\backend\Product;
use App\Models\backend\Gallery;
use App\Models\backend\Slider;
use App\Models\backend\Team;
use App\Models\backend\Partner;
use App\Models\backend\Tv;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Auth;
use File;
use App\Services\ImageService;

class DashboardController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
	protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.dashboard';
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
		$data->title   = 'Quản Lý Trang Chủ';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view;
        $data->content = $this->content;
        $data['home_default'] = HomepageManager::getHomeDefault();

        if( $data['home_default'] ) {

            $relatedSliderIds = $data['related_sliders'] = [];
            if(isset($data['home_default']->related_slider) && !empty($data['home_default']->related_slider)) {

                $relatedSliderIds = json_decode($data['home_default']->related_slider, true);
                $data['related_sliders'] = Slider::whereIn('id', $relatedSliderIds)
                    ->where('status', 1)
                    ->get();
            }

            // $relatedPartnerIds = $data['related_partners'] = [];
            // if(isset($data['home_default']->related_partner) && !empty($data['home_default']->related_partner)) {

            //     $relatedPartnerIds          = json_decode($data['home_default']->related_partner,true);
            //     $data['related_partners']   = Partner::whereIn('id', $relatedPartnerIds)
            //         ->where('status',1)
			// 		->get();
            // }

            $relatedHotIds = $data['related_hots'] = [];
            if(isset($data['home_default']->related_hot) && !empty($data['home_default']->related_hot)) {

                $relatedHotIds          = json_decode($data['home_default']->related_hot,true);
                $data['related_hots']   = Hot::whereIn('id', $relatedHotIds)
                    ->where('status',1)
                    ->get();
            }


            // $relatedHot2Ids = $data['related_hot2s'] = [];
            // if(isset($data['home_default']->related_hot_2) && !empty($data['home_default']->related_hot_2)) {

            //     $relatedHot2Ids          = json_decode($data['home_default']->related_hot_2,true);
            //     $data['related_hot2s']   = Hot::whereIn('id', $relatedHot2Ids)
            //         ->where('status',1)
            //         ->get();
            // }

            $relatedEndowIds = $data['related_endows'] = [];
            if(isset($data['home_default']->related_endow) && !empty($data['home_default']->related_endow)) {

                $relatedEndowIds          = json_decode($data['home_default']->related_endow,true);
                $data['related_endows']   = Endow::whereIn('id', $relatedEndowIds)
                    ->where('status',1)
                    ->get();
            }

            $relatedPostIds = $data['related_posts'] = [];
            if(isset($data['home_default']->related_post) && !empty($data['home_default']->related_post)) {

                $relatedPostIds          = json_decode($data['home_default']->related_post,true);

                $data['related_posts']   = Post::whereIn('id', $relatedPostIds)
                    ->where('status',1)
                    ->get();
            }

            $relatedProductsHotIds = $data['related_products_hot'] = [];
            if(isset($data['home_default']->related_product_hot) && !empty($data['home_default']->related_product_hot)) {

                $relatedProductsHotIds          = json_decode($data['home_default']->related_product_hot,true);

                $data['related_products_hot']   = Product::whereIn('id', $relatedProductsHotIds)
                    ->where('status',1)
                    ->get();
            }

            $relatedProductsSaleIds = $data['related_products_sale'] = [];
            if(isset($data['home_default']->related_product_sale) && !empty($data['home_default']->related_product_sale)) {

                $relatedProductsSaleIds          = json_decode($data['home_default']->related_product_sale,true);

                $data['related_products_sale']   = Product::whereIn('id', $relatedProductsSaleIds)
                    ->where('status',1)
                    ->get();
            }

            // $relatedCertifyIds = $data['related_certifies'] = [];
            // if(isset($data['home_default']->related_certify) && !empty($data['home_default']->related_certify)) {

            //     $relatedCertifyIds              = json_decode($data['home_default']->related_certify,true);
            //     $data['related_certifies']       = Certify::whereIn('id', $relatedCertifyIds)
            //         ->where('status',1)
            //         ->get();
            // }

            // $relatedTvIds = $data['related_tvs'] = [];
            // if(isset($data['home_default']->related_tv) && !empty($data['home_default']->related_tv)) {

            //     $relatedTvIds              = json_decode($data['home_default']->related_tv,true);
            //     $data['related_tvs']       = Tv::whereIn('id', $relatedTvIds)
            //         ->where('status',1)
            //         ->get();
            // }

            // $relatedNewspaperIds = $data['related_newspapers'] = [];
            // if(isset($data['home_default']->related_newspaper) && !empty($data['home_default']->related_newspaper)) {

            //     $relatedNewspaperIds              = json_decode($data['home_default']->related_newspaper,true);
            //     $data['related_newspapers']       = Newspaper::whereIn('id', $relatedNewspaperIds)
            //         ->where('status',1)
            //         ->get();
            // }

        }

        return View($data->view,compact('data'));

    }

}
