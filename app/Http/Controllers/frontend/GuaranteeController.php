<?php

namespace App\Http\Controllers\frontend;

use App\Models\backend\Guarantee;
use App\Models\backend\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class GuaranteeController extends Controller
{
    private $layout  = 'frontend.layouts.';
    private $view    = 'frontend.pages.guarantee.';
    private $content = 'content';


    public function index( $alias = null ){
        $data = new Collection();
        $data->title   = 'Thông Tin Bảo Hành';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'detail';
        $data->content = $this->content;

        if( $alias != null ) {
            $guarantee = Guarantee::findDetailbyalias($alias);
            $order_id = $guarantee->order_id;
            $product_id = $guarantee->product_id;

            //tìm đơn hàng
            $order = Order::whereId($order_id)->first();
            //tìm qr sản phẩm
            $data_cart = unserialize($order->data_cart);
            $product = $data_cart[$product_id];
            $data['product'] = $product;
            return View($data->view,compact('data'));
        }
    }

//    public function detail($order_id, $product_id){
//        $data = new Collection();
//        $data->title   = 'Thông Tin Bảo Hành';
//        $data->layout  = $this->layout.'page';
//        $data->view    = $this->view.'detail';
//        $data->content = $this->content;
//
//        if($order_id && $product_id){
//            //tìm đơn hàng
//            $order = Order::whereId($order_id)->first();
//            //tìm qr sản phẩm
//            $data_cart = unserialize($order->data_cart);
//            $product = $data_cart[$product_id];
//            $data['product'] = $product;
//            return View($data->view,compact('data'));
//        }
//
//    }
}
