<?php

namespace App\Http\Controllers\frontend;

use App\Models\backend\Product;
use App\Models\backend\Schema;
use App\Models\backend\SchemaBreadcrumb;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Models\backend\Category;
use App\Models\backend\LandingPage;
use App\Models\backend\Post;
use App\Models\backend\SchemaPost;
use App\Models\backend\Gallery;
use App\Models\backend\ConfigSeo;
use App\Models\backend\ConfigLogo;

class PostController extends Controller
{
    protected $limit = 18;
    private $layout  = 'frontend.layouts.';
    private $view    = 'frontend.pages.post.';
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
        $data->title   = 'Blog';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'index';
        $data->content = $this->content;

        $page = $request->page && $request->page > 0 ? $request->page : 1;

        $catCurrentIDS = $catIDS = [];

        if($request->alias != null) {

            $category = Category::where("alias",trim($alias))->first();
            $categoryPost = Category::where("parent_id", -1)->where("type", 1)->first();
            $landingPage = LandingPage::where("category_id", $category->id)
                ->where('status',1)
                ->paginate(6);

            if(!$category) abort('404');

            $catCurrentIDS = $catIDS = [$category->id];

            /* Current cat id + All cat child id */
            $catIDS = getAllCatIdChild($category->id, $catIDS) ?? array();

            $query = Post::where('status',1);
            $query->whereIn('category_id',$catIDS);

            $counter = Post::count();

            if(isset($request->page)){
                if($request->page <= ceil( $counter/$this->limit ) )  {
                    /* all post */
                    $category->posts = $query->orderBy('id','DESC')->skip($request->page*$this->limit)->take($this->limit)->paginate($this->limit, ['*'], 'page',$page);

                    /* all feature post */
                    $feature_post = $query->where('is_post_feature',1)->orderBy('id','DESC')->skip($request->page*$this->limit)->take($this->limit)->paginate($this->limit, ['*'], 'page',$page);
                }
            }else {
                /* all post */
                $category->posts = $query->orderBy('id','DESC')->paginate($this->limit, ['*'], 'page',$page);

                /* all feature post */
                $feature_post = $query->where('is_post_feature',1)->orderBy('id','DESC')->paginate($this->limit, ['*'], 'page',$page);
            }

            /* All cat child id has is_feature = 1 ( not included current cat id ) */
            $CatIDSHotChild = getAllCatIdHotChild($category->id, $CatIDSHotChild) ?? array();

            $feature_post_child = Post::where([
                ["status",1],
                ["is_cat_feature",1]
            ])->whereIn( "category_id",$CatIDSHotChild )->orderBy('id','desc')->take(18)->get();

            $feature_category_post_children = $feature_post_child->groupBy('category_id');

            $view = array();
            $view = !Session::has('view_post') ? [] : session("view_post");

            $view = count($view) <= 6 ? Post::whereIn("id", $view)->get() : Post::whereIn("id",  array_slice($view,count($view)-5, 4))->get();

            $count_feature_post = $count_cat_posts = 0;
            if( !empty( $feature_post ) ) {
                $count_feature_post = count( $feature_post );
            }

            if( !empty( $category->posts ) ) {
                $count_cat_posts = count( $category->posts );
            }

            if( $count_feature_post > $count_cat_posts ) {
                $data['pagiante'] = $data['feature_post'];
            }else {
                $data['pagiante'] = $category->posts;
            }

            $logo = ConfigLogo::where("status",1)->get();
            $logo->top = $logo->where("type",1)->first();

            if( !empty( $category->images ) ) {
                $cat_img = $category->images;
            }elseif( !empty( $logo->top->images ) ) {
                $cat_img = $logo->top->images;
            }else {
                $cat_img = asset('assets/client/dist/images/favicon.png');
            }

            $allCategoryPost = Category::getCategoryByType(1);

            //schema ô tìm kiếm
            $json_search = Schema::where('type', 'search')
                ->where('status',1)
                ->first();
            if($json_search){
                $data['schema_search'] = json_encode(unserialize($json_search->contents));
            }

            //schema breadcrumb
            $json_breadcrumb = SchemaBreadcrumb::where('type', 'danh-muc-bai-viet')->where('id_post_cat', $category->id)
                ->where('status',1)
                ->first();
            if($json_breadcrumb){
                $data['schema_breadcrumb'] = json_encode(unserialize($json_breadcrumb->content));
            }

            $alias      = $request->alias;
            $dataSeo    = ConfigSeo::where('status', 1)->first();
            $seo_title          = $dataSeo->seo_title ?? '';
            $seo_keywords       = $dataSeo->seo_keywords ?? '';
            $seo_description    = $dataSeo->seo_description ?? '';
            $seo_google         = $dataSeo->seo_google ?? '';
            $seo_facebook       = $dataSeo->seo_facebook ?? '';

            $data['allCategoryPost'] = $allCategoryPost;
            $data['category']        = $category;
            $data['categoryPost']    = $categoryPost;
            $data['landingPage']     = $landingPage;
            $data['feature_post']    = $feature_post;
            $data['feature_category_post_children']    = $feature_category_post_children;
            $data['viewed_post']     = $view;

            $data['title']           = $category->title;
            $data['og_image']        = $cat_img;
            $data['og_url']          = $category->alias;
            $data['seo_title']       = $category->seo_title ?? $seo_title;
            $data['seo_keywords']    = $category->seo_keyword ?? $seo_keywords;
            $data['seo_description'] = $category->seo_desciption ?? $seo_description ;
            $data['seo_google']      = $category->seo_google ?? $seo_google ;
            $data['seo_facebook']    = $category->seo_facebook ?? $seo_facebook ;

            return View($data->view,compact('data'));

        }else {
            abort('404');
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $alias
     * @return \Illuminate\Http\Response
     */
    public function PostDetail( $alias = null )
    {
        $data = new Collection();
        $data->title   = 'Blog Detail';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'detail';
        $data->content = $this->content;
        if( $alias != null ) {
            $post = Post::findDetailbyalias($alias);

            if( $post != null ){
                $post->view =$post->view + 1;
                $post->save();
                $categoryPost = Category::where("parent_id", -1)->where("type", 1)->first();
                $detail_category =  Category::where('id',$post->category_id)->first();

                //schema chi tiết bài viết
                $schema = SchemaPost::where("id_post", $post->id)->first();
                if( $schema != null ){
                    $data['schema_post'] = json_encode(unserialize($schema->content));
                }

                //schema ô tìm kiếm
                $json_search = Schema::where('type', 'search')
                    ->where('status',1)
                    ->first();
                if($json_search){
                    $data['schema_search'] = json_encode(unserialize($json_search->contents));
                }

                //schema breadcrumb
                $json_breadcrumb = SchemaBreadcrumb::where('type', 'bai-viet-don')->where('id_post', $post->id)
                    ->where('status',1)
                    ->first();
                if($json_breadcrumb){
                    $data['schema_breadcrumb'] = json_encode(unserialize($json_breadcrumb->content));
                }

                $view = array();
                if(!Session::has('view_post')  ){
                    $tmp = array();
                    array_push($tmp, $post->id);
                    Session::put("view_post",$tmp);
                    $view = $tmp;
                }
                else{
                    if(count(session('view_post'))  > 0){

                        $tmp = session('view_post');
                        if(count($tmp)==4){
                            array_shift($tmp);
                        }
                        array_push($tmp, $post->id);
                        $tmp= array_unique($tmp);
                        Session::put("view_post",$tmp);
                        $view = $tmp;
                    }
                    else{
                        $tmp = array();
                        array_push($tmp, $post->id);
                        Session::put("view", $tmp);
                        $view = $tmp;
                    }
                }
                if(count($view) <= 4){
                    $view = Post::whereIn("id",$view)->where('id', '!=', $post->id)->get();
                }
                else{
                    $view = Post::whereIn("id",array_slice($view,count($view)-5, 4))->where('id', '!=', $post->id)->get();
                }

                $relatedPostIDS = $related_posts = [];
                if(isset($post['related_post']) && !empty($post['related_post'])) {
                    $relatedPostIDS     = json_decode($post['related_post'],true);
                    $related_posts      = Post::whereIn('id', $relatedPostIDS)
                        ->where('status',1)
                        ->get();

                }

                $relatedProductIDS = $related_products = [];
                if(isset($post['related_product']) && !empty($post['related_product'])) {
                    $relatedProductIDS     = json_decode($post['related_product'],true);
                    $related_products      = Product::whereIn('id', $relatedProductIDS)
                        ->where('status',1)
                        ->get();

                }

                $logo = ConfigLogo::where("status",1)->get();
                $logo->top = $logo->where("type",1)->first();

                if( !empty( $post->images ) ) {
                    $cat_img = $post->images;
                }elseif( !empty( $logo->top->images ) ) {
                    $cat_img = $logo->top->images;
                }else {
                    $cat_img = asset('assets/client/dist/images/favicon.png');
                }


                $dataSeo    = ConfigSeo::where('status', 1)->first();
                $seo_title          = $dataSeo->seo_title ?? '';
                $seo_keywords       = $dataSeo->seo_keywords ?? '';
                $seo_description    = $dataSeo->seo_description ?? '';
                $seo_google         = $dataSeo->seo_google ?? '';
                $seo_facebook       = $dataSeo->seo_facebook ?? '';

                $data['categoryPost']       = $categoryPost;
                $data['post_detail']        = $post;
                $data['related_posts']      = $related_posts ?? [];
                $data['related_products']      = $related_products ?? [];
                $data['related_gallerys']   = $related_gallerys ?? [];
                $data['viewed_post']        = $view;

                $data['title']           = $post->title;
                $data['og_image']        = $cat_img;
                $data['og_url']          = $post->alias;
                $data['seo_title']       = $post->seo_title ?? $seo_title;
                $data['seo_keywords']    = $post->seo_keyword ?? $seo_keywords;
                $data['seo_description'] = $post->seo_desciption ?? $seo_description ;
                $data['seo_google']      = $post->seo_google ?? $seo_google ;
                $data['seo_facebook']    = $post->seo_facebook ?? $seo_facebook ;

                $data['category_detail'] = $detail_category;
            }else {
                abort('404');
            }

            return View($data->view,compact('data'));
        }else {
            abort('404');
        }

    }

}
