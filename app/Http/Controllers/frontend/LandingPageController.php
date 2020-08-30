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
    protected $limit = 12;
    private $layout  = 'frontend.layouts.';
    private $view    = 'frontend.pages.landingpage.';
    private $content = 'content';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, $alias)
    {
        $data = new Collection();
        $data->title   = 'List LandingPage';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'index';
        $data->content = $this->content;

        $page = $request->page && $request->page > 0 ? $request->page : 1;

        $catCurrentIDS = $catIDS = [];

        if($request->alias != null) {

            $category = Category::where("alias",trim($alias))->first();

            if(!$category) abort('404');

            $data['list_landing'] = LandingPage::where("status", 1)->orderBy('id', 'DESC')->paginate($this->limit);

            $logo = ConfigLogo::where("status",1)->get();
            $logo->top = $logo->where("type",1)->first();

            if( !empty( $category->images ) ) {
                $cat_img = $category->images;
            }elseif( !empty( $logo->top->images ) ) {
                $cat_img = $logo->top->images;
            }else {
                $cat_img = asset('assets/client/dist/images/favicon.png');
            }

            $alias      = $request->alias;
            $dataSeo    = ConfigSeo::where('status', 1)->first();
            $seo_title          = $dataSeo->seo_title ?? '';
            $seo_keywords       = $dataSeo->seo_keywords ?? '';
            $seo_description    = $dataSeo->seo_description ?? '';

            $data['category']        = $category;

            $data['title']           = $category->title;
            $data['og_image']        = $cat_img;
            $data['og_url']          = $category->alias;
            $data['seo_title']       = $category->seo_title ?? $seo_title;
            $data['seo_keywords']    = $category->seo_keyword ?? $seo_keywords;
            $data['seo_description'] = $category->seo_desciption ?? $seo_description ;

            return View($data->view,compact('data'));

        }else {
            abort('404');
        }
    }

    public function LandingPageDetail($alias = null)
    {
        $data = new Collection();
        $data->title = 'LandingPage Detail';
        $data->layout = $this->layout . 'page';
        $data->view = $this->view . 'detail';
        $data->content = $this->content;

        if ($alias != null) {
            $landingPage = LandingPage::findDetailbyalias($alias);
            $data['landingPage'] = $landingPage;

            $data['category_landing'] = Category::where('type', 6)
                ->where('status', 1)
                ->get();

            if ($landingPage != null) {
                $sections = $landingPage->items()->orderBy("ordering", 'ASC')->get();
                $data['sections'] = $sections;
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

            $data['title'] = $landingPage->title ?? 'Trang Chủ';
            $data['og_image'] = $og_image;
            $data['og_url'] = url('/');
            $data['seo_title'] = $seo_title;
            $data['seo_keywords'] = $seo_keywords;
            $data['seo_description'] = $seo_description;

            return View($data->view, compact('data'));
        }
    }
}
