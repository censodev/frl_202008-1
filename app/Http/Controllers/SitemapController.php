<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\backend\Category;
use App\Models\backend\Post;
use App\Models\backend\Product;
use App\Models\backend\Gallery;
use App\Models\backend\Url;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
	{
	  $categories 	= Category::select('alias','created_at','updated_at')->where("status",1)->orderBy("id","desc")->get();
	  $articles 	= Post::select('alias','created_at','updated_at')->where("status",1)->orderBy("id","desc")->get();
	  $products 	= Product::select('alias','created_at','updated_at')->where("status",1)->orderBy("id","desc")->get();
	  $galleries 	= Gallery::select('alias','created_at','updated_at')->where("status",1)->orderBy("id","desc")->get();

	  return response()->view('sitemap', [
		  'categories' 	=> $categories,
		  'articles' 	=> $articles,
		  'products' 	=> $products,
		  'galleries' 	=> $galleries,
	  ])->header('Content-Type', 'text/xml');
	}
}
