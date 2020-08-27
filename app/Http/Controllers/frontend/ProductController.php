<?php

namespace App\Http\Controllers\frontend;

use App\Models\backend\Color;
use App\Models\backend\Endow;
use App\Models\backend\Material;
use App\Models\backend\ProductConfig;
use App\Models\backend\ProductItem;
use App\Models\backend\Schema;
use App\Models\backend\SchemaBreadcrumb;
use Illuminate\Support\Str;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Models\backend\Category;
use App\Models\backend\Product;
use App\Models\backend\SchemaProduct;
use App\Models\backend\Post;
use App\Models\backend\Gallery;
use App\Models\backend\ConfigSeo;
use App\Models\backend\ConfigLogo;

class ProductController extends Controller
{
    protected $limit = 8;
    private $layout  = 'frontend.layouts.';
    private $view    = 'frontend.pages.product.';
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
        $data->title   = 'Product';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'index';
        $data->content = $this->content;

        $page = $request->page && $request->page > 0 ? $request->page : 1;
        $catCurrentIDS = $catIDS = [];

        if($request->alias != null) {

            $category = Category::where("status", 1)->where("alias",trim($alias))->first();
            $categoryProduct = Category::where("parent_id", -1)->where("type", 5)->first();

            if($category->type == 5 && $category->parent_id == -1 ){

                $data['list_product'] = Product::where("status", 1)->orderBy('id', 'DESC')->paginate($this->limit);
                if ($request->name) {
                    $value_name = $request->name;
                    $data['list_product'] = Product::where("status", 1)->orderBy('title', $value_name)->paginate($this->limit)->appends('price', $value_name);
                }

                if ($request->type) {
                    $value_type = $request->type;
                    if ($value_type === 'new') {
                        $data['list_product'] = Product::where("status", 1)->where('is_product_new', 1)->orderBy('id', 'DESC')->paginate($this->limit)->appends('type', $value_type);
                    }
                    if ($value_type === 'hot') {
                        $data['list_product'] = Product::where("status", 1)->where('is_product_feature', 1)->orderBy('id', 'DESC')->paginate($this->limit)->appends('type', $value_type);
                    }
                    if ($value_type === 'sale') {
                        $data['list_product'] = Product::where("status", 1)->where('is_product_sale', 1)->orderBy('id', 'DESC')->paginate($this->limit)->appends('type', $value_type);
                    }
                    if ($value_type === 'selling') {
                        $data['list_product'] = Product::where("status", 1)->where('is_product_selling', 1)->orderBy('id', 'DESC')->paginate($this->limit)->appends('type', $value_type);
                    }
                }

                if ($request->price) {
                    $value_price = $request->price;
                    $data['list_product'] = Product::where("status", 1)->orderBy("price", $value_price)->paginate($this->limit)->appends('price', $value_price);
                }

                if ($request->number) {
                    $value_number = (int)$request->number;
                    $data['list_product'] = Product::where("status", 1)->orderBy('id', 'DESC')->paginate($value_number)->appends('number', $value_number);
                }

            }else {

                $data['list_product'] = $category->products()->where("status", 1)->orderBy('id', 'DESC')->paginate($this->limit);
                if ($request->name) {
                    $value_name = $request->name;
                    $data['list_product'] = $category->products()->where("status", 1)->orderBy('title', $value_name)->paginate($this->limit)->appends('price', $value_name);
                }

                if ($request->type) {
                    $value_type = $request->type;
                    if ($value_type === 'new') {
                        $data['list_product'] = $category->products()->where("status", 1)->where('is_product_new', 1)->orderBy('id', 'DESC')->paginate($this->limit)->appends('type', $value_type);
                    }
                    if ($value_type === 'hot') {
                        $data['list_product'] = $category->products()->where("status", 1)->where('is_product_feature', 1)->orderBy('id', 'DESC')->paginate($this->limit)->appends('type', $value_type);
                    }
                    if ($value_type === 'sale') {
                        $data['list_product'] = $category->products()->where("status", 1)->where('is_product_sale', 1)->orderBy('id', 'DESC')->paginate($this->limit)->appends('type', $value_type);
                    }
                    if ($value_type === 'selling') {
                        $data['list_product'] = $category->products()->where("status", 1)->where('is_product_selling', 1)->orderBy('id', 'DESC')->paginate($this->limit)->appends('type', $value_type);
                    }
                }

                if ($request->price) {
                    $value_price = $request->price;
                    $data['list_product'] = $category->products()->where("status", 1)->orderBy("price", $value_price)->paginate($this->limit)->appends('price', $value_price);
                }

                if ($request->number) {
                    $value_number = (int)$request->number;
                    $data['list_product'] = $category->products()->where("status", 1)->orderBy('id', 'DESC')->paginate($value_number)->appends('number', $value_number);
                }
            }


            $view_product = array();
            $view_product = !Session::has('view_product') ? [] : session("view_product");
            $view_product = Product::whereIn("id", $view_product)->get();
            $data['viewed_product']  = $view_product;

            $logo = ConfigLogo::where("status",1)->get();
            $logo->top = $logo->where("type",1)->first();

            if( !empty( $category->images ) ) {
                $cat_img = $category->images;
            }elseif( !empty( $logo->top->images ) ) {
                $cat_img = $logo->top->images;
            }else {
                $cat_img = asset('assets/client/dist/images/favicon.png');
            }

            $data['materials'] = Material::all();

            //schema ô tìm kiếm
            $json_search = Schema::where('type', 'search')
                ->where('status',1)
                ->first();
            if($json_search){
                $data['schema_search'] = json_encode(unserialize($json_search->contents));
            }

            //schema breadcrumb
            $json_breadcrumb = SchemaBreadcrumb::where('type', 'danh-muc-san-pham')->where('id_product_cat', $category->id)
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

            $data['category']        = $category;
            $data['categoryProduct'] = $categoryProduct;
            $data['title']           = $category->title;
            $data['limit']           = $this->limit;
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
     * @param  \Illuminate\Http\Request  $request, $alias
     * @return \Illuminate\Http\Response
     */

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $alias
     * @return \Illuminate\Http\Response
     */

    public function selectPrice(Request $request)
    {
        $id = $request->id;
        $item = ProductItem::where('id', $id)->get();

        if(count($item) > 0){
            $price_buy = number_format($item[0]->price_buy, 0, ".", ".") . ' đ';
            $price_promotion = number_format($item[0]->price_promotion, 0, ".", ".") . ' đ';
        }
        return response()->json(['status' => 1, 'price_buy' => $price_buy, 'price_promotion' => $price_promotion]);
    }

    public function ProductDetail( $alias = null )
    {
        $data = new Collection();
        $data->title   = 'Product Detail';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'detail';
        $data->content = $this->content;

        if( $alias != null ) {
            $product = Product::findDetailbyalias($alias);

            $list_color = Color::all();
            $list_material = Material::all();
            $list_endows = Endow::all();

            $colors = [];
            $materials = [];
            if(!empty($list_color) && count($list_color) >0){
                foreach ($list_color as $key => $item){
                    $colors[$item->id] = $item->name;
                }
            }
            if(!empty($list_material) && count($list_material) >0){
                foreach ($list_material as $key => $item){
                    $materials[$item->id] = $item->name;
                }
            }
            $data['colors'] = $colors;
            $data['materials'] = $materials;
            $data['list_endows'] = $list_endows;

            if( $product != null ){
                $product->view =$product->view + 1;
                $product->save();

                $categories = $product->categories()->get();
                $data['category'] = $categories[0];

                $categoryProduct = Category::where("parent_id", -1)->where("type", 5)->first();

                //schema chi tiết sản phẩm
                $schema = SchemaProduct::where("id_product", $product->id)->first();
                if( $schema != null ){
                    $data['schema_product'] = json_encode(unserialize($schema->content));
                }

                //schema ô tìm kiếm
                $json_search = Schema::where('type', 'search')
                    ->where('status',1)
                    ->first();
                if($json_search){
                    $data['schema_search'] = json_encode(unserialize($json_search->contents));
                }

                //schema breadcrumb
                $json_breadcrumb = SchemaBreadcrumb::where('type', 'san-pham-don')->where('id_product', $product->id)
                    ->where('status',1)
                    ->first();
                if($json_breadcrumb){
                    $data['schema_breadcrumb'] = json_encode(unserialize($json_breadcrumb->content));
                }

                $view = array();
                if(!Session::has('view_product')  ){
                    $tmp = array();
                    array_push($tmp, $product->id);
                    Session::put("view_product",$tmp);
                    $view = $tmp;
                }
                else{
                    if(count(session('view_product'))  > 0){

                        $tmp = session('view_product');
                        if(count($tmp)==4){
                            array_shift($tmp);
                        }
                        array_push($tmp, $product->id);
                        $tmp= array_unique($tmp);
                        Session::put("view_product",$tmp);
                        $view = $tmp;
                    }
                    else{
                        $tmp = array();
                        array_push($tmp, $product->id);
                        Session::put("view", $tmp);
                        $view = $tmp;
                    }
                }
                if(count($view) <= 4){
                    $view = Product::whereIn("id",$view)->where('id', '!=', $product->id)->get();
                }else{
                    $view = Product::whereIn("id",array_slice($view,count($view)-5, 4))->where('id', '!=', $product->id)->get();
                }

                $relatedProductIDS = $related_products = [];
                if(isset($product['related_product']) && !empty($product['related_product'])) {
                    $relatedProductIDS     = json_decode($product['related_product'],true);
                    $related_products      = Product::whereIn('id', $relatedProductIDS)
                        ->where('status',1)
                        ->get();

                }

                $relatedPostIDS = $related_posts = [];
                if(isset($product['related_post']) && !empty($product['related_post'])) {
                    $relatedPostIDS     = json_decode($product['related_post'],true);
                    $related_posts      = Post::whereIn('id', $relatedPostIDS)
                        ->where('status',1)
                        ->get();

                }

                $view_product = array();
                $view_product = !Session::has('view_product') ? [] : session("view_product");
                $view_product = Product::whereIn("id", $view_product)->get();
                $data['viewed_product']  = $view_product;


                $logo = ConfigLogo::where("status",1)->get();
                $logo->top = $logo->where("type",1)->first();

                if( !empty( $product->images ) ) {
                    $cat_img = $product->images;
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

                $data['product_detail']     = $product;
                $data['related_products']   = $related_products ?? [];
                $data['related_posts']      = $related_posts ?? [];
                $data['related_gallerys']   = $related_gallerys ?? [];
                $data['viewed_product']     = $view;

                $data['categoryProduct'] = $categoryProduct;
                $data['title']           = $product->title;
                $data['og_image']        = $cat_img;
                $data['og_url']          = $product->alias;
                $data['seo_title']       = $product->seo_title ?? $seo_title;
                $data['seo_keywords']    = $product->seo_keyword ?? $seo_keywords;
                $data['seo_description'] = $product->seo_desciption ?? $seo_description ;
                $data['seo_google']      = $product->seo_google ?? $seo_google ;
                $data['seo_facebook']    = $product->seo_facebook ?? $seo_facebook ;

            }else {
                abort('404');
            }

            return View($data->view,compact('data'));
        }else {
            abort('404');
        }
    }

    public  function filterName(Request $request)
    {
        $id_category = $request->id;
        $value = $request->value;

        if ($value != null)
        {
            $category = Category::where("id", $id_category)->first();
            $list_product = $category->products()->where("status", 1)->orderBy('title', $value)->paginate($this->limit);
            $html = render_products($list_product);
            return response()->json(['status' => 1, 'html' => $html]);
        }
    }

    public  function filterType(Request $request)
    {
        $id_category            = $request->id;
        $value                  = $request->value;

        $category = Category::where("id", $id_category)->first();
        if($value === 'new'){
            $list_product = $category->products()->where("status", 1)->where('is_product_new', 1)->paginate($this->limit);
        }
        if($value === 'hot'){
            $list_product = $category->products()->where("status", 1)->where('is_product_feature', 1)->paginate($this->limit);
        }
        if($value === 'sale'){
            $list_product = $category->products()->where("status", 1)->where('is_product_sale', 1)->paginate($this->limit);
        }
        if($value === 'selling'){
            $list_product = $category->products()->where("status", 1)->where('is_product_selling', 1)->paginate($this->limit);
        }

        if ($value != null){
            $html = render_products($list_product);
            return response()->json(['status' => 1, 'html' => $html]);
        }
    }

    public  function filterPrice(Request $request){
        $id_category            = $request->id;
        $value                  = $request->value;

        if ($value != null)
        {
            $category = Category::where("id", $id_category)->first();
            $list_product = $category->products()->where("status", 1)->orderBy("price", $value)->paginate($this->limit);
            $html = render_products($list_product);
            return response()->json(['status' => 1, 'html' => $html]);
        }
    }
}
