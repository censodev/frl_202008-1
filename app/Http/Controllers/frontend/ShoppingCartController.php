<?php

namespace App\Http\Controllers\frontend;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Models\backend\Category;
use App\Models\backend\Product;
use App\Models\backend\Order;
use App\Models\backend\ConfigSeo;
use App\Models\backend\ConfigLogo;

class ShoppingCartController extends Controller
{
    private $layout  = 'frontend.layouts.';
    private $view    = 'frontend.pages.cart.';
    private $content = 'content';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new Collection();
        $data->title   = 'Cart';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'index';
        $data->content = $this->content;

        return View($data->view,compact('data'));
    }

    public function addToCart($id,$quantity)
    {
        try{

            $product = Product::findbycode($id);

            $product['quantity'] = (int)$quantity;

            $product['flag'] = 0;
            if(isset($product['price_promotion']) && $product['price_promotion']!="" ){
                $tmp =$product['price'];
                $product['price'] = $product['price_promotion'];
                $product['price_promotion'] = $tmp ;
            }

            if(!Session::has('cart')){

                $tmp = array();
                array_push($tmp, $product);
                Session::put("cart",$tmp);
                $product["flag"] = 1;

            } else{
                if(count(session('cart')) > 0 ){
                    $tmp = session('cart');
                    if($this->checkArray($tmp,$product['id'])){
                        Session::push("cart",$product);
                        $product["flag"] = 2;
                    }
                    else {
                        $cart =session("cart");
                        $index = $this->getProductIncart($cart,$product['id']);
                        $cart[$index]['quantity'] = $cart[$index]['quantity'] + $quantity;
                        Session::put("cart",$cart);
                        $product['quantity'] = $cart[$index]['quantity'];

                        $product["flag"] = 3;
                    }
                }else {
                    $tmp = array();
                    array_push($tmp, $product);
                    Session::put("cart",$tmp);
                    $product["flag"] = 1;
                }
            }
            $tmp = session('cart');
            $tong= 0;
            foreach ($tmp as $value) {
                $tong = $tong + (int)$value['price']*(int)$value['quantity'];
            }
            $product['message']= 1;

            if( !empty( $product['images'] ) ) {
                $product['images'] = $product['images'];
                if(isset($product['title_image'])){
                    $product['title_image'] =$product['title_image'];
                }else{
                    $product['title_image']="";
                }
                if(isset($product['alt_image'])){
                    $product['alt_image'] =$product['alt_image'];
                }else{
                    $product['alt_image']="";
                }
            }else {
                $product['images'] = asset("assets/client/dist/img/no_image.png");
                $product['title_image'] = $product['alt_image'] = "";
            }

            if(isset($product['price_product'])){
                $product['price_product'] =$product['price_product'];
            }else{
                $product['price_product']=0;
            }

            $product['total']= count($tmp);
            $product['total_prices']= $tong;

        }
        catch(Exception $e){
            $product['message']= 0;
        }
        echo json_encode($product);
    }

    private function checkArray($arr1,$key){
        foreach ($arr1 as  $value1) {
            if($value1['id'] == $key){
                return false;
            }
        }
        return true;
    }

    private function getProductIncart($arr1,$key){
        foreach ($arr1 as $index=> $value1) {
            if($value1['id'] == $key){
                return $index;
            }
        }
    }

    public function deleteCart(Request $rq){

        $cart = session('cart');
        foreach ($cart as $key=>$product) {
            if($rq->id == $product['id']){
                unset($cart[$key]);
                break;
            }
        }

        Session::put("cart",$cart);
        $tong=0;
        foreach ($cart as $value) {
            $tong = $tong + (int)$value['price']*(int)$value['quantity'];
        }
        if($tong!=0){
            $cart['tong'] = $tong;
        }
        $result['tong'] = $tong;
        $result['code'] = $rq->code;
        $result['total'] = count(session('cart'));

        echo json_encode($result);
    }

    public function changeQuantity(Request $rq){

        $cart = session("cart");
        $cart[$this->getProductIncart($cart,$rq->id)]['quantity'] = $rq->quantity;
        Session::put('cart',$cart);
        $tong = $cart[$this->getProductIncart($cart,$rq->id)]['quantity'] * (int)$cart[$this->getProductIncart($cart,$rq->id)]['price'];
        $total =0;
        foreach ($cart as  $value) {
            $total = $total + (int)$value['quantity']*(int)$value['price'];
        }
        $result['tong'] = $tong;
        $result['total'] =$total;
        echo json_encode($result);
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function checkOut(Request $rq){

        if(Session::has('cart') && count(session('cart')) >0 ){
            $order = new Order();
            $cart = session('cart');
            foreach($cart as $value){
                $tmp = Product::find($value['id']);
                $tmp->bought =  $tmp->bought +1;
                $tmp->save();
            }
            $tong =0;
            $customer_data['name'] = $rq->name;
            $customer_data['email'] = $rq->email;
            $customer_data['phone' ]= $rq->phone;
            $customer_data['address'] = $rq->address;
            $customer_data['note'] = $rq->note;
            $order->note = $rq->note;
            foreach ($cart as $value) {
                $tong = $tong + (int)$value['price']*(int)$value['quantity'];
            }

            $order->order_code = $this->generateRandomString(5);
            $order->products_data = json_encode($cart);
            $order->customer_data = json_encode($customer_data);
            $order->total_price = $tong;
            #$this->sendMail($rq->name,$rq->email);
            $order->save();
            Session::forget('cart');
            return Redirect('thanh-toan')->with("message","Đặt Hàng thành công");
        }
        else {
            return Redirect('thanh-toan')->with("message","Chưa có đơn hàng nào");
        }
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
