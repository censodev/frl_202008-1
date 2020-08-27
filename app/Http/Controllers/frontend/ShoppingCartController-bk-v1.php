<?php

namespace App\Http\Controllers\frontend;

use Session;
use App\Models\frontend\ShoppingCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Models\backend\Category;
use App\Models\backend\Product;
use App\Models\backend\ConfigSeo;
use App\Models\backend\ConfigLogo;

class ShoppingCartController extends Controller
{
    private $layout  = 'frontend.layouts.';
    private $view    = 'frontend.pages.product.';
    private $content = 'content';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new Collection();
		$data->title   = 'Product';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'index';
        $data->content = $this->content;
    }

    public function getAddToCart( Request $request, $product_id, $qty )
    {
        /* kiểm tra xem sp có tồn tại ko */
        $product = Product::find( $product_id );
        /* kiểm tra trong Session có Session cart chưa */
        $olodCart = Session('cart') ? Session::get('cart') : null;
        /* khởi tạo giỏ hàng mới , gán vào giỏ hàng củ để dồn chung giỏ hàng */
        $cart = new ShoppingCart( $olodCart );

        /* Thêm 1 sản phẩm vào giỏ hàng */
        $cart->add($product, $product_id, $qty);

        /* Thêm cart vào session */
        $request->session()->put('cart', $cart);
        
        //return redirect()->back();
        echo json_encode( Session('cart') );
    }

    public function getDelItemCart( Request $request, $product_id )
    {
        $oldCart = Session('cart') ? Session::get('cart') : null;
        $cart = new ShoppingCart( $oldCart );

        /* Xóa, giảm số lượng 1 sản phẩm khỏi giỏ hàng ( ví dụ số lượng sp hiện tại là 5 => khí xóa còn 4 ) */
        //$cart->reduceByOne( $product_id );

        /* Xóa 1 sản phẩm khỏi giỏ hàng */
        $cart->removeItem( $product_id );

        if( count( $cart->items ) > 0 ) {
            /* làm mới Session cart */
            Session::put('cart', $cart);
        }else {
            /* xóa Session cart */
            Session::forget('cart');
        }

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\frontend\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\frontend\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function edit(ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\frontend\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\frontend\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingCart $shoppingCart)
    {
        //
    }
}
