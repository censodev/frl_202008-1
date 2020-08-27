<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Models\backend\Category;
use App\Models\backend\Post;
use App\Models\backend\Gallery;
use App\Models\backend\ConfigSeo;
use App\Models\backend\ConfigLogo;
use App\Models\backend\Product;

class SearchController extends Controller
{
    protected $limit = 12;
    private $layout  = 'frontend.layouts.';
    private $view    = 'frontend.pages.search.';
    private $content = 'content';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = new Collection();
		$data->title   = 'Tìm Kiếm';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'index';
        $data->content = $this->content;

        $query = $request->input('query','');

        $posts 		= Post::SearchPostsByName($query, $this->limit);
        $galleries 	= Gallery::SearchGalleriesByName($query, $this->limit);
		$products 	= Product::SearchProductsByName($query, $this->limit);

		$count_posts = $count_galleries = $count_products = 0;

		if( !empty( $posts ) ) {
			$count_posts = count( $posts );
		}

		if( !empty( $galleries ) ) {
			$count_galleries = count( $galleries );
		}

		if( !empty( $products ) ) {
			$count_products = count( $products );
		}

		$max_count = max($count_posts, $count_galleries, $count_products);

		if( $count_posts == $max_count ) {
			$data['pagiante'] = $posts;
		}elseif( $count_products == $max_count ) {
			$data['pagiante'] = $products;
		}else {
			$data['pagiante'] = $galleries;
		}

        $logo = ConfigLogo::where("status",1)->get();
        $logo->top = $logo->where("type",1)->first();

        if( !empty( $logo->top->image ) ) {
            $cat_img = $logo->top->image;
        }else {
            $cat_img = asset('assets/client/dist/images/favicon.png');
        }

        $alias      = $request->alias;
        $dataSeo    = ConfigSeo::where('status', 1)->first();
        $seo_title          = $dataSeo->seo_title ?? '';
        $seo_keywords       = $dataSeo->seo_keywords ?? '';
        $seo_description    = $dataSeo->seo_description ?? '';

        $data['query']      = $query;

        $data['posts']    	= $posts;
        $data['galleries']  = $galleries;
		$data['products']  	= $products;

        $data['title']           = 'Tìm Kiếm';
        $data['og_image']        = $cat_img;
        $data['og_url']          = route('search_all');
        $data['seo_title']       = 'Tìm Kiếm';
        $data['seo_keywords']    = 'Tìm Kiếm';
        $data['seo_description'] = 'Tìm Kiếm';

        return View($data->view,compact('data'));

    }

}
