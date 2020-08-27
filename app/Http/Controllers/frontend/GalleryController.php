<?php

namespace App\Http\Controllers\frontend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Models\backend\Category;
use App\Models\backend\Post;
use App\Models\backend\Gallery;
use App\Models\backend\ConfigSeo;
use App\Models\backend\ConfigLogo;

class GalleryController extends Controller
{
    protected $limit = 21;
    private $layout  = 'frontend.layouts.';
    private $view    = 'frontend.pages.gallery.';
    private $content = 'content';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request, $alias
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $alias)
    {
        $data = new Collection();
		$data->title   = 'Gallery';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'index';
        $data->content = $this->content;

        $page = $request->page && $request->page > 0 ? $request->page : 1;

        $catCurrentIDS = $catIDS = [];

        if($request->alias != null) {

            $category = Category::where("alias",trim($alias))->first();

            if(!$category) abort('404');

            $catCurrentIDS = $catIDS = [$category->id];

            /* Current cat id + All cat child level 1 id */
            $catIDS = getAllCatIdChildLevel1($category->id, $catIDS) ?? array();

            $galleries = Gallery::where('status', 1)->whereIn('category_id', $catIDS)->orderBy('id', 'desc')->paginate($this->limit);
    		process_json_field($galleries);

            $logo = ConfigLogo::where("status",1)->get();
            $logo->top = $logo->where("type",1)->first();

            if( !empty( $category->images ) ) {
                $cat_img = $category->images;
            }elseif( !empty( $logo->top->image ) ) {
                $cat_img = $logo->top->image;
            }else {
                $cat_img = asset('assets/client/dist/images/favicon.png');
            }

            $alias      = $request->alias;
            $dataSeo    = ConfigSeo::where('status', 1)->first();
            $seo_title          = $dataSeo->seo_title ?? '';
            $seo_keywords       = $dataSeo->seo_keywords ?? '';
            $seo_description    = $dataSeo->seo_description ?? '';

            $data['catCurrentIDS']   = $catCurrentIDS;
            $data['catIDS']       	 = $catIDS;
            $data['galleries']       = $galleries;
            $data['category']        = $category;

            $data['title']           = $category->title;
            $data['og_image']        = $cat_img;
            $data['og_url']          = $category->alias;
            $data['seo_title']       = $category->seo_title ?? $seo_title;
            $data['seo_keywords']    = $category->seo_keyword ?? $seo_keywords;
            $data['seo_description'] = $category->seo_desciption ?? $seo_description;

            return View($data->view,compact('data'));

        }else {
            abort('404');
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request, $alias
     * @return \Illuminate\Http\Response
     */
    public function index1(Request $request, $alias)
    {
        $data = new Collection();
		$data->title   = 'Gallery';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'index';
        $data->content = $this->content;

        $page = $request->page && $request->page > 0 ? $request->page : 1;

        if($request->alias != null) {

            $category = Category::where("alias",trim($alias))->first();

            if(!$category) abort('404');

            $allCatGallery = Category::getCategoryByType(4, true, true);

            $galleries = Gallery::listGallery(NUll, true, $this->limit );
            process_json_field($galleries);

            $logo = ConfigLogo::where("status",1)->get();
            $logo->top = $logo->where("type",1)->first();

            if( !empty( $category->images ) ) {
                $cat_img = $category->images;
            }elseif( !empty( $logo->top->image ) ) {
                $cat_img = $logo->top->image;
            }else {
                $cat_img = asset('assets/client/dist/images/favicon.png');
            }

            $alias      = $request->alias;
            $dataSeo    = ConfigSeo::where('status', 1)->first();
            $seo_title          = $dataSeo->seo_title ?? '';
            $seo_keywords       = $dataSeo->seo_keywords ?? '';
            $seo_description    = $dataSeo->seo_description ?? '';

            $data['galleries']       = $galleries;
            $data['category']        = $category;
            $data['allCatGallery']   = $allCatGallery;

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

    /**
     * Display a listing of the resource.
     *
     * @param  $alias
     * @return \Illuminate\Http\Response
     */
    public function GalleryDetail( $alias = null )
    {
        $data = new Collection();
		$data->title   = 'Gallery Detail';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'detail';
        $data->content = $this->content;

        if( $alias != null ) {
            $gallery = Gallery::where([
	            	["status",1],
	            	["alias",$alias]
	            ])->first();

            if( $gallery != null ){
                $category = Category::find( $gallery->category_id );

                $relatedPostIDS = $related_posts = [];
                if(isset($gallery['related_post']) && !empty($gallery['related_post'])) {
                    $relatedPostIDS     = json_decode($gallery['related_post'],true);
                    $related_posts      = Post::whereIn('id', $relatedPostIDS)
                                            ->where('status',1)
											->get();

                }

                $relatedGalleryIDS = $related_gallerys = [];
                if(isset($gallery['related_gallery']) && !empty($gallery['related_gallery'])) {

                    $relatedGalleryIDS  = json_decode($gallery['related_gallery'],true);
                    $related_gallerys   = Gallery::whereIn('id', $relatedGalleryIDS)
                        ->where('status',1)
						->get();

                }

                $logo = ConfigLogo::where("status",1)->get();
                $logo->top = $logo->where("type",1)->first();

                if( !empty( $gallery->images[0] ) ) {
                    $cat_img = $gallery->images;
                }elseif( !empty( $logo->top->image ) ) {
                    $cat_img = $logo->top->image;
                }else {
                    $cat_img = asset('assets/client/dist/images/favicon.png');
                }

                $dataSeo    = ConfigSeo::where('status', 1)->first();
                $seo_title          = $dataSeo->seo_title ?? '';
                $seo_keywords       = $dataSeo->seo_keywords ?? '';
                $seo_description    = $dataSeo->seo_description ?? '';

                $data['gallery_detail']     = $gallery;
                $data['related_posts']      = $related_posts;
                $data['related_gallerys']   = $related_gallerys;

                $data['title']           = $gallery->title;
                $data['og_image']        = $cat_img;
                $data['og_url']          = $gallery->alias;
                $data['seo_title']       = $gallery->seo_title ?? $seo_title;
                $data['seo_keywords']    = $gallery->seo_keyword ?? $seo_keywords;
                $data['seo_description'] = $gallery->seo_desciption ?? $seo_description ;

            }else {
                abort('404');
            }

            return View($data->view,compact('data'));
        }else {
            abort('404');
        }

    }

}
