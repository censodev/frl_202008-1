<?php

namespace App\Http\Controllers\frontend;

use App\Models\backend\ConfigLogo;
use App\Models\backend\ConfigSeo;
use App\Models\backend\Feedback;
use App\Models\backend\Gallery;
use App\Models\backend\HomepageManager;
use App\Models\backend\Partner;
use App\Models\backend\Post;
use App\Models\backend\LandingPage;
use App\Models\backend\Product;
use App\Models\backend\Slider;
use App\Models\backend\Team;
use App\Models\backend\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class LandingPageController extends Controller
{
    private $layout  = 'frontend.layouts.';
    private $view    = 'frontend.pages.landingpage.';
    private $content = 'content';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        echo "tb";
    }

    public function LandingPageDetail($alias = null)
    {
        $data = new Collection();
        $data->title = 'LandingPage Detail';
        $data->layout = $this->layout . 'landing';
        $data->view = $this->view . 'detail';
        $data->content = $this->content;

        if ($alias != null) {
            $data['landingPage'] = LandingPage::findDetailbyalias($alias);

            $data['category_landing'] = Category::where('type', 6)
                ->where('status', 1)
                ->get();

            if ($data['landingPage'] != null) {

                $relatedSliderIds = $data['related_sliders'] = [];
                if (isset($data['landingPage']->related_slider) && !empty($data['landingPage']->related_slider)) {

                    $relatedSliderIds = json_decode($data['landingPage']->related_slider, true);
                    $data['related_sliders'] = Slider::whereIn('id', $relatedSliderIds)
                        ->where('status', 1)
                        ->get();
                }

                $relatedPostServiceIds = $data['related_posts_service'] = [];
                if (isset($data['landingPage']->services_name) && !empty($data['landingPage']->services_name)) {

                    $data['services_url'] = json_decode($data['landingPage']->services_url, true);
                    $data['services_description'] = json_decode($data['landingPage']->services_description, true);

                    $data['related_posts_service'] = json_decode($data['landingPage']->services_name, true);
                }

                $relatedProductHotIds = $data['related_products_hot'] = [];
                if (isset($data['landingPage']->related_product_hot) && !empty($data['landingPage']->related_product_hot)) {

                    $relatedProductHotIds = json_decode($data['landingPage']->related_product_hot, true);
                    $data['related_products_hot'] = Product::whereIn('id', $relatedProductHotIds)
                        ->where('status', 1)
                        ->get();
                }

                $relatedProductSaleIds = $data['related_products_sale'] = [];
                if (isset($data['landingPage']->related_product_sale) && !empty($data['landingPage']->related_product_sale)) {

                    $relatedProductSaleIds = json_decode($data['landingPage']->related_product_sale, true);
                    $data['related_products_sale'] = Product::whereIn('id', $relatedProductSaleIds)
                        ->where('status', 1)
                        ->get();
                }

                $relatedProductSellingIds = $data['related_products_selling'] = [];
                if (isset($data['landingPage']->related_product_selling) && !empty($data['landingPage']->related_product_selling)) {

                    $relatedProductSellingIds = json_decode($data['landingPage']->related_product_selling, true);
                    $data['related_products_selling'] = Product::whereIn('id', $relatedProductSellingIds)
                        ->where('status', 1)
                        ->get();
                }

                $relatedGalleryIds = $data['related_galleries'] = [];
                if (isset($data['landingPage']->related_gallery) && !empty($data['landingPage']->related_gallery)) {

                    $relatedGalleryIds = json_decode($data['landingPage']->related_gallery, true);
                    $data['related_galleries'] = Gallery::whereIn('id', $relatedGalleryIds)
                        ->where('status', 1)
                        ->get();
                }

                $relatedTeamIds = $data['related_teams'] = [];
                if (isset($data['landingPage']->related_team) && !empty($data['landingPage']->related_team)) {

                    $relatedTeamIds = json_decode($data['landingPage']->related_team, true);
                    $data['related_teams'] = Team::whereIn('id', $relatedTeamIds)
                        ->where('status', 1)
                        ->get();
                }

                $relatedPostIds = $data['related_posts'] = [];
                if (isset($data['landingPage']->related_post) && !empty($data['landingPage']->related_post)) {

                    $relatedPostIds = json_decode($data['landingPage']->related_post, true);
                    $data['related_posts'] = Post::whereIn('id', $relatedPostIds)
                        ->where('status', 1)
                        ->get();
                }

                $relatedPartnerIds = $data['related_partners'] = [];
                if (isset($data['landingPage']->related_partner) && !empty($data['landingPage']->related_partner)) {

                    $relatedPartnerIds = json_decode($data['landingPage']->related_partner, true);
                    $data['related_partners'] = Partner::whereIn('id', $relatedPartnerIds)
                        ->where('status', 1)
                        ->get();
                }

                $data['feedbacks'] = Feedback::listFeedback();

            } else {
                abort('404');
            }

            $logo = ConfigLogo::where("status", 1)->get();
            $logo->top = $logo->where("type", 1)->first();

            if (!empty($logo->top->image)) {
                $og_image = $logo->top->image;
            } else {
                $og_image = asset('assets/client/dist/images/favicon.png');
            }

            $dataSeo = ConfigSeo::where('status', 1)->first();
            $seo_title = $dataSeo->seo_title ?? '';
            $seo_keywords = $dataSeo->seo_keywords ?? '';
            $seo_description = $dataSeo->seo_description ?? '';

            $data['title'] = $data['landingPage']->title ?? 'Trang Chủ';
            $data['og_image'] = $og_image;
            $data['og_url'] = url('/');
            $data['seo_title'] = $seo_title;
            $data['seo_keywords'] = $seo_keywords;
            $data['seo_description'] = $seo_description;

            return View($data->view, compact('data'));
        }
    }
}
