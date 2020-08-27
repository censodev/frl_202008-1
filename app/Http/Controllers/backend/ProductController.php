<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Color;
use App\Models\backend\Material;
use App\Models\backend\Product;
use App\Models\backend\ProductItem;
use App\Models\backend\Post;
use App\Models\backend\Category;
use App\Models\backend\Url;
use App\Models\backend\Gallery;
use App\Models\backend\ProductConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreProductRequest;
use Auth;
use File;
use App\Services\ImageService;

class ProductController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $cat 	 = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.product.';
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
        $data->title   = 'Danh Sách Sản Phẩm';
        $data->keyword = $this->keyword;
        $data->cat 	   = $this->cat;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        $tmp_cat 	   = -1;

        if( !empty( $request->keyword ) || !empty( $request->cat ) ) {
            $data->keyword = $request->keyword;
            $data->cat	   = $request->cat ?? NULL;
            $data['products'] = Product::searchProduct($data->keyword,$data->cat,NULL,$this->limit);

            $tmp_cat 	   = $request->cat;
        }else {
            $data['products'] = Product::listProduct(Null, true, $this->limit);
        }

        $data['keyword'] = $data->keyword;
        $data['create_new'] = route('product.create');
        $data['tmp_cat'] 		= $tmp_cat;

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
        $data->title   = 'Thêm Mới Sản Phẩm';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        $data['colors'] = Color::all();
        $data['materials'] = Material::all();
        /* 5: Danh mục sản phẩm */
        $data['category_level'] = Category::getCategoryProductLevel();

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $message = 'Đã thêm mới thành công sản phẩm.';
        if( !empty( $request->alias ) ) {
            $alias = $request->alias;
        }else {
            $alias = $request->title;
        }
        $alias = utf8tourl( $alias );

        $user_id = $this->getUserData()->id ?? 1;

        $images    = !empty( $request->images ) ? Genratejsonarray( $request->images ) : '';
        $title_image    = !empty( $request->title_image ) ? Genratejsonarray( $request->title_image ) : '';
        $alt_image    = !empty( $request->alt_image ) ? Genratejsonarray( $request->alt_image ) : '';

        $related_product    = !empty( $request->related_product ) ? Genratejsonarray( $request->related_product ) : '';
        $related_post    = !empty( $request->related_post ) ? Genratejsonarray( $request->related_post ) : '';
        $related_gallery = !empty( $request->related_gallery ) ? Genratejsonarray( $request->related_gallery ) : '';

        $data_product = [
            'material'          => $request->material,
            'price_buy'         => $request->price_buy,
            'price_promotion'   => $request->price_promotion,
        ];

        $data = [
            'seo_title'                 =>  $request->seo_title,
            'seo_desciption'            =>  $request->seo_desciption,
            'seo_keyword'               =>  $request->seo_keyword,
            'seo_google'                =>  $request->seo_google,
            'seo_facebook'              =>  $request->seo_facebook,
            'title'                     =>  $request->title,
            'images'                    =>  $images,
            'title_image'               =>  $title_image,
            'alt_image'                 =>  $alt_image,
            'alias'                     =>  $alias,
            'view'                      =>  $request->view,
            'rating'                    =>  $request->rating,
            'bought'                    =>  $request->bought,
            'code'                      =>  $request->code,
            'short_description'         =>  $request->short_description,
            'description'               =>  $request->description,
            'sapo'                      =>  $request->sapo,
            'related_product'           =>  $related_product,
            'related_post'              =>  $related_post,
            'related_gallery'           =>  $related_gallery,
            'price'                     =>  $data_product['price_buy'][0],
            'created_by'                =>  $user_id,
            'status'                    =>  1,
        ];

        try{
            //tạo product
            $create_product = Product::create( $data );
            $id_product = $create_product->id;

            //thêm dữ liệu vào bảng trung gian
            $category_id = $request->category_id;
            if(!empty($category_id) && count($category_id) > 0){
                foreach ($category_id as $key => $item_id){
                    $category_id[$key] = (int) $item_id;
                }
            }
            $create_product->categories()->sync($category_id);


            foreach($data_product['price_buy'] as $key => $price_buy){
                $data_item = [
                    'product_id'        => $id_product,
                    'material'          => (int) $data_product['material'][$key],
                    'price_buy'         => $price_buy,
                    'price_promotion'   => $data_product['price_promotion'][$key],
                    'created_by'        => $user_id,
                    'status'            => 1,
                ];
                ProductItem::create( $data_item );
            }



            //tạo url cho product
            if( $create_product ) {
                $data_url = [
                    'url'       =>  $alias,
                    'module'    =>  'Product',
                    'action'    =>  'ProductDetail',
                    'object_id' =>  $create_product->id,
                ];
                Url::create( $data_url );
            }

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('product.index')->with('message', $message);
            }

            return redirect()->route('product.edit',$create_product->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('product.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Sản Phẩm';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $data['colors'] = Color::all();
        $data['materials'] = Material::all();
        $list_product = ProductItem::where('product_id',$product->id)->get();

        $data['list_product']  = $list_product;

        $error = 'Không tìm thấy dữ liệu về sản phẩm này. Vui lòng thử lại.';

        $url =  Url::findURLByModule( 'Product', $product->id );
        $data['url_id'] = $url->id ?? '';

        if( Product::checkExists( $product->id ) ) {
            $data['product']       = $product;

            /* 5: Danh mục sản phẩm */
            $data['category_level'] = Category::getCategoryProductLevel();

            $relatedProductIds = $data['related_products'] = [];
            if(isset($product->related_product) && !empty($product->related_product)) {

                $relatedProductIds             = json_decode($product->related_product,true);
                $data['related_products']      = Product::whereIn('id', $relatedProductIds)
                    ->where('status',1)
                    ->get();

            }

            $relatedPostIds = $data['related_posts'] = [];
            if(isset($product->related_post) && !empty($product->related_post)) {

                $relatedPostIds             = json_decode($product->related_post,true);
                $data['related_posts']      = Post::whereIn('id', $relatedPostIds)
                    ->where('status',1)
                    ->get();

            }

            $relatedGalleryIds = $data['related_galleries'] = [];
            if(isset($product->related_gallery) && !empty($product->related_gallery)) {

                $relatedGalleryIds          = json_decode($product->related_gallery,true);
                $data['related_galleries']  = Gallery::whereIn('id', $relatedGalleryIds)
                    ->where('status',1)
                    ->get();

            }

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('product.index')->with('error', $error);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Http\Requests\StoreProductRequest  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request, Product $product)
    {

        $message        = 'Đã cập nhật sản phẩm thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $product ) {

            $alias_old   = $product->alias;
            if( !empty( $request->alias ) ) {
                $alias = $request->alias;
            }else {
                $alias = $request->title;
            }
            $alias = utf8tourl( $alias );

            $user_id = $this->getUserData()->id ?? $product->created_by;

            $images    = !empty( $request->images ) ? Genratejsonarray( $request->images ) : '';
            $title_image    = !empty( $request->title_image ) ? Genratejsonarray( $request->title_image ) : '';
            $alt_image    = !empty( $request->alt_image ) ? Genratejsonarray( $request->alt_image ) : '';

            $related_product = !empty( $request->related_product ) ? Genratejsonarray( $request->related_product ) : '';
            $related_post    = !empty( $request->related_post ) ? Genratejsonarray( $request->related_post ) : '';
            $related_gallery = !empty( $request->related_gallery ) ? Genratejsonarray( $request->related_gallery ) : '';


            $data_product = [
                'item_id'           => $request->item_id,
                'material'          => $request->material,
                'price_buy'         => $request->price_buy,
                'price_promotion'   => $request->price_promotion,
            ];

            $data = [
                'seo_title'                 =>  $request->seo_title,
                'seo_desciption'            =>  $request->seo_desciption,
                'seo_keyword'               =>  $request->seo_keyword,
                'seo_google'                =>  $request->seo_google,
                'seo_facebook'              =>  $request->seo_facebook,
                'title'                     =>  $request->title,
                'images'                    =>  $images,
                'title_image'               =>  $title_image,
                'alt_image'                 =>  $alt_image,
                'alias'                     =>  $alias,
                'view'                      =>  $request->view,
                'rating'                    =>  $request->rating,
                'bought'                    =>  $request->bought,
                'code'                      =>  $request->code,
                'short_description'         =>  $request->short_description,
                'sapo'                      =>  $request->sapo,
                'description'               =>  $request->description,
                'related_product'           =>  $related_product,
                'related_post'              =>  $related_post,
                'related_gallery'           =>  $related_gallery,
                'price'                     =>  $data_product['price_buy'][0],
                'created_by'                =>  $user_id,
                'status'                    =>  1,
            ];

            try{
                //update san pham chinh
                $update_product = $product->update( $data );

                //thêm dữ liệu vào bảng trung gian
                $category_id = $request->category_id;

                if(!empty($category_id) && count($category_id) > 0){
                    foreach ($category_id as $key => $item_id){
                        $category_id[$key] = (int) $item_id;
                    }
                }
                $product->categories()->sync($category_id);

                //xoá item
                $list_product = ProductItem::select('id')->where('product_id',$product->id)->get();
                $array_id = [];

                if(!empty($list_product) && count($list_product) > 0){
                    foreach ($list_product as $key => $item){
                        $array_id[] = $item->id;
                    }
                }

                if(!empty($array_id) && count($array_id) > 0){
                    foreach ($array_id as $key => $item){
                        if(!in_array( (string) $item, $data_product['item_id']) ){
                            ProductItem::where('id',$item)->delete();
                        }
                    }
                }

                //update product item
                foreach($data_product['item_id'] as $key => $item){

                    $data_item = [
                        'product_id'        => $product->id,
                        'material'          => (int) $data_product['material'][$key],
                        'price_buy'         => $data_product['price_buy'][$key],
                        'price_promotion'   => $data_product['price_promotion'][$key],
                        'created_by'        =>  $user_id,
                        'status'            =>  1,
                    ];

                    //nếu tồn tại id thì update
                    if($item != null){
                        ProductItem::where('id',$item)->update($data_item);
                    }else{
                        //chưa có id thì tạo mới
                        $a = ProductItem::create($data_item);
                    }
                }


                //tao url
                $data_url = [];
                if( $update_product ) {
                    $url =  Url::findURLByModule( 'Product', $request->id );

                    if( $url ) {
                        if( $alias != $alias_old ) {
                            $data_url = [
                                'url'       =>  $alias
                            ];
                            $url->update( $data_url );
                        }
                    }else {
                        $data_url = [
                            'url'       =>  $alias,
                            'module'    =>  'Product',
                            'action'    =>  'ProductDetail',
                            'object_id' =>  $request->id,
                        ];
                        Url::create( $data_url );
                    }
                }

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('product.index')->with('message', $message);
                }
                return redirect()->route('product.edit',$product->id)->with('message', $message);

            } catch(\Exception $e){
                dd($e);
                $error = $e->getMessage();
                return redirect()->route('product.edit',$product->id)->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        $data = [
            'status'    =>  -2
        ];

        $product_delete = $product->update( $data );

        if( $product_delete ) {
            $url =  Url::findURLByModule( 'Product', $product->id );

            $url->update( $data );

        }

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

    /**
     * [searchRelative product]
     * @param  Request $rq
     * @return search html
     */
    public function searchRelative(Request $rq)
    {
        $data = new Collection();
        $data->view    = $this->view.'search';

        $products          = Product::searchProduct($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "product";
        $html           = View($data->view, compact("products",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

    /**
     * [searchRelative product hot]
     * @param  Request $rq
     * @return search html
     */
    public function searchRelativeNew(Request $rq)
    {
        $data = new Collection();
        $data->view    = $this->view.'searchNew';

        $products       = Product::searchProductType('new',$rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "product_new";
        $html           = View($data->view, compact("products",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

    /**
     * [searchRelative product hot]
     * @param  Request $rq
     * @return search html
     */
    public function searchRelativeHot(Request $rq)
    {
        $data = new Collection();
        $data->view    = $this->view.'searchHot';

        $products          = Product::searchProductType('hot',$rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "product_hot";
        $html           = View($data->view, compact("products",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

    /**
     * [searchRelative product sale]
     * @param  Request $rq
     * @return search html
     */
    public function searchRelativeSale(Request $rq)
    {
        $data = new Collection();
        $data->view    = $this->view.'searchSale';

        $products       = Product::searchProductType('sale',$rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "product_sale";
        $html           = View($data->view, compact("products",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

    /**
     * [searchRelative product selling]
     * @param  Request $rq
     * @return search html
     */
    public function searchRelativeSelling(Request $rq)
    {
        $data = new Collection();
        $data->view    = $this->view.'searchSelling';

        $products          = Product::searchProductType('selling',$rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "product_selling";
        $html           = View($data->view, compact("products",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

    /**
     * Product Is Category Feature .
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function isCatFeature($id){
        $message_on  = 'Đã bật thành công.';
        $message_off = 'Đã tắt thành công.';
        $error       = 'Đã có lỗi xảy ra. Xin vui lòng thử lại';
        try {
            $product = Product::find($id);
            if($product->is_cat_feature == "1"){
                $product->is_cat_feature = 0;
                $message = $message_off;
            }
            else{
                $product->is_cat_feature = 1;
                $message = $message_on;
            }
            $product->save();

            return response()->json(['message' => $message], 200);

        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['error' => $error], 200);
        }

    }

    /**
     * Product Is Product Feature.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function isProductNew($id){
        $message_on  = 'Đã bật thành công.';
        $message_off = 'Đã tắt thành công.';
        $error       = 'Đã có lỗi xảy ra. Xin vui lòng thử lại';
        try {
            $product = Product::find($id);
            if($product->is_product_new == "1"){
                $product->is_product_new = 0;
                $message = $message_off;
            }
            else{
                $product->is_product_new = 1;
                $message = $message_on;
            }
            $product->save();

            return response()->json(['message' => $message], 200);

        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['error' => $error], 200);
        }

    }

    /**
     * Product Is Product Feature.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function isProductFeature($id){
        $message_on  = 'Đã bật thành công.';
        $message_off = 'Đã tắt thành công.';
        $error       = 'Đã có lỗi xảy ra. Xin vui lòng thử lại';
        try {
            $product = Product::find($id);
            if($product->is_product_feature == "1"){
                $product->is_product_feature = 0;
                $message = $message_off;
            }
            else{
                $product->is_product_feature = 1;
                $message = $message_on;
            }
            $product->save();

            return response()->json(['message' => $message], 200);

        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['error' => $error], 200);
        }

    }

    /**
     * Product Is Product Sale.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function isProductSale($id){
        $message_on  = 'Đã bật thành công.';
        $message_off = 'Đã tắt thành công.';
        $error       = 'Đã có lỗi xảy ra. Xin vui lòng thử lại';
        try {
            $product = Product::find($id);
            if($product->is_product_sale == "1"){
                $product->is_product_sale = 0;
                $message = $message_off;
            }
            else{
                $product->is_product_sale = 1;
                $message = $message_on;
            }
            $product->save();

            return response()->json(['message' => $message], 200);

        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['error' => $error], 200);
        }

    }

    /**
     * Product Is Product Selling.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function isProductSelling($id){
        $message_on  = 'Đã bật thành công.';
        $message_off = 'Đã tắt thành công.';
        $error       = 'Đã có lỗi xảy ra. Xin vui lòng thử lại';
        try {
            $product = Product::find($id);
            if($product->is_product_selling == "1"){
                $product->is_product_selling = 0;
                $message = $message_off;
            }
            else{
                $product->is_product_selling = 1;
                $message = $message_on;
            }
            $product->save();

            return response()->json(['message' => $message], 200);

        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['error' => $error], 200);
        }

    }
}
