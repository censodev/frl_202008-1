<?php

namespace App\Http\Controllers\frontend;

use App\Models\backend\Color;
use App\Models\backend\ConfigEmail;
use App\Models\backend\Material;
use Illuminate\Support\Facades\Storage;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Session;
use App\Models\frontend\CheckOutV3;
use App\Models\frontend\alepay\Alepay;
use App\Models\frontend\alepay\Utils\AlepayUtils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Models\backend\Category;
use App\Models\backend\Product;
use App\Models\backend\ProductItem;
use App\Models\backend\Order;
use App\Models\backend\ConfigSeo;
use App\Models\backend\ConfigLogo;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use BaconQrCode;

class ShoppingController extends Controller
{
    private $layout  = 'frontend.layouts.';
    private $view    = 'frontend.pages.cart.';
    private $content = 'content';
    protected $next = 0;
    private $methods = [
        'COD'                   => 'Thanh toán khi giao hàng (COD)',
        'Visa/Master/JCB'       => 'Visa/Master/JCB',
        'ATM_ONLINE'            => 'Thanh toán bằng thẻ ATM',
        'IB_ONLINE'             => 'Thanh toán bằng Internet Banking',
        'QRCODE'                => 'Thanh toán bằng QRCode',
        'VAY_MUON'              => 'Thanh toán qua Lendmo.vn',
        'TRA_GOP'               => 'Thanh toán trả góp'
    ];


    public function index()
    {
        $data = new Collection();
        $data->title   = 'Giỏ hàng';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'index';
        $data->content = $this->content;

        $categoryProduct = Category::where("parent_id", -1)->where("type", 5)->first();
        $data->url = url( $categoryProduct->alias );

        return View($data->view,compact('data'));
    }

    public function checkOut(){
        $data = new Collection();
        $data->title   = 'Thanh Toán';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'checkout';
        $data->content = $this->content;

        return View($data->view,compact('data'));
    }

    public function success(){
        $data = new Collection();
        $data->title   = 'Cart Success';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'success';
        $data->content = $this->content;
        $data->message = 'Đặt Hàng Thành Công';
        $data->error = 'Đặt Hàng Không Thành Công';


        $carts = session('cart');
        $data_order = session('data_order');
        $host = session('host');
        $request_name = session('request_name');
        $request_email = session('request_email');


        $email = ConfigEmail::find(1);
        $content = $email->smtp_content_cart;
        $date_cart = date("H:i:s d/m/Y");

        //template email
        $table_cart = '<table><tbody>
                        <tr>
                            <td>Sản Phẩm</td>
                            <td>Số Lượng</td>
                            <td>Giá</td>
                            <td>Thành Tiền</td>
                        </tr>';
        foreach ($carts as $key => $item_cart) {
            $table_cart .= '<tr>
                                <td>' . $item_cart['name'] . '</td>
                                <td>' . $item_cart['quantity'] . '</td>
                                <td>' . number_format($item_cart['price'], 0, ".", ".") . ' đ' . '</td>
                                <td>' . number_format($item_cart['total'], 0, ".", ".") . ' đ' . '</td>
                            </tr>';
        }
        $table_cart .= '<tr>
                            <td></td>
                            <td></td>
                            <td>Thành Tiền</td>
                            <td>' . number_format($data_order['total_price_cart'], 0, ".", ".") . ' đ' . '</td>
                        </tr>';
        $table_cart .= '</tbody></table>';

        $table_customer = '<table><tbody>
                        <tr>
                            <td>Tên</td>
                            <td>' . $data_order['name'] . '</td>
                        </tr>
                        <tr>
                            <td>Số điện thoại</td>
                            <td>' . $data_order['phone'] . '</td>
                        </tr>
                        <tr>
                            <td>Địa chỉ</td>
                            <td>' . $data_order['address'] . '</td>
                        </tr>
                        <tr>
                            <td>Ghi Chú</td>
                            <td>' . $data_order['note'] . '</td>
                        </tr>';
        $table_customer .= '</tbody></table>';


        $content_qrcode = QrCode::format('png')->size(300)->generate(time());
        $name_img_qr_code = time() . '.png';
        Storage::disk('qr_code')->put($name_img_qr_code, $content_qrcode);
        $link_image_qrcode = $host . '/qr_code/' . $name_img_qr_code;

        $array_begin = ['date_cart', 'pay_method_cart', 'table_cart', 'table_customer'];
        $array_change = [$date_cart, $this->methods[$data_order['pay_method']], $table_cart, $table_customer];

        $body_note = str_replace($array_begin, $array_change, $content);

        //send mail
        $this->sendMail($request_name, $email->smtp_email, true, $body_note);

        //add order
        $data_order['image_qr_code'] = $name_img_qr_code;
        $order = Order::create($data_order);

        return View($data->view,compact('data'));
    }

    public function info(Request $request){

        $data = new Collection();
        $data->title   = 'Cart Success';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'success';
        $data->content = $this->content;

        $data->message = $request->message;

        return View($data->view,compact('data'));
    }

    public function order(Request $request){

        $host = $request->getSchemeAndHttpHost();
        $carts = session('cart');
        $count_item_cart = 0;
        foreach ($carts as $key => $cart){
            $count_item_cart += (int) $cart['quantity'];
        }

        $data_order = [
            'agency_id' => null,
            'code_cart' => time(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'province' => $request->province,
            'country' => $request->country,
            'note' => $request->note,
            'pay_method' => $request->pay_method,
            'bankcode' => $request->bankcode,
            'image_qr_code' => '',
            'total_price_cart' => $request->total_price_form,
            'data_cart' => serialize($carts),
            'order_status' => 0,
            'status' => 1
        ];

        session()->put('data_order', $data_order);
        session()->put('host', $host);
        session()->put('request_name', $request->name);
        session()->put('request_email', $request->email);

        //trường hợp chọn thanh toán qua alepay
        if($data_order['pay_method'] !="COD") {

            $config = config('alepay.config');
            $alepay = new Alepay($config);
            $data = array();
            parse_str(file_get_contents('php://input'), $params); // Lấy thông tin dữ liệu bắn vào

            $data['cancelUrl'] = config('alepay.URL_DEMO');
            $data['amount'] = (int) $data_order['total_price_cart'];
            $data['orderCode'] = time();
            $data['currency'] = 'VND';
            $data['orderDescription'] = $data_order['note'];
            $data['totalItem'] = $count_item_cart;
            $data['checkoutType'] = 3; // Thanh toán trả góp + nội địa + quốc tế
            $data['buyerName'] = $data_order['name'];
            $data['buyerEmail'] = $data_order['email'];
            $data['buyerPhone'] = $data_order['phone'];
            $data['buyerAddress'] = $data_order['address'];
            $data['buyerCity'] = $data_order['province'];
            $data['buyerCountry'] = $data_order['country'];
            $data['month'] = 3;
            $data['paymentHours'] = 48; //48 tiếng :  Thời gian cho phép thanh toán (tính bằng giờ)

            foreach ($data as $k => $v) {
                if (empty($v)) {
                    $alepay->return_json("NOK", "Bắt buộc phải nhập/chọn tham số [ " . $k . " ]");
                    die();
                }
            }
            $data['allowDomestic'] = true;

            $result = $alepay->sendOrderToAlepay($data); // Khởi tạo
            if (isset($result) && !empty($result->checkoutUrl)) {
                echo '<meta http-equiv="refresh" content="0;url=' . $result->checkoutUrl. '">';

                $encryptKey = config('alepay.encryptKey');
                $config = config('alepay.config');
                if (isset($_REQUEST['data']) && isset($_REQUEST['checksum'])) {
                    $alepay = new Alepay($config);
                    $utils = new AlepayUtils();
                    $result = $utils->decryptCallbackData($_REQUEST['data'], $encryptKey);
                    $obj_data = json_decode($result);

                }
            } else {
                echo $result->errorDescription;
            }

        }else{
            $this->success();
            $data = new Collection();
            $data->title   = 'Cart Success';
            $data->layout  = $this->layout.'page';
            $data->view    = $this->view.'success';
            $data->content = $this->content;

            $data->message = 'Đặt Hàng Thành Công';
            $data->error = 'Đặt Hàng Không Thành Công';

            return View($data->view,compact('data'));
        }
    }

    public function addToCart(Request $request){
        $id         = (int)$request->id;
        $quantity   = (int)$request->quantity;
        $product    = ProductItem::find($id);
        $main_product = Product::find($product->product_id);

        $images         = json_decode( $main_product->images );
        $title_image    = json_decode( $main_product->title_image );
        $alt_image      = json_decode( $main_product->alt_image );

        $price = (!empty($product->price_promotion)) ? $product->price_promotion : $product->price_buy;
        $cart = session()->get('cart');
        $cart_total_price = session()->get('cart_total_price');

        //vật liệu và màu
        $list_color = Color::all();
        $list_material = Material::all();

        $materials = [];
        if(!empty($list_material) && count($list_material) >0){
            foreach ($list_material as $key => $item_material){
                $materials[$item_material->id] = $item_material->name;
            }
        }

        switch ($cart) {
            // nếu giỏ hàng trống
            case null:
                $cart = [
                    $id => [
                        "id" => $id,
                        "code" => $main_product->code,
                        "material" => !empty($materials[$product->material]) ? $materials[$product->material] : '',
                        "name" => $main_product->title,
                        "alias" => url( $main_product->alias ),
                        "quantity" => $quantity,
                        "image" => $images[0],
                        "title" => $title_image[0],
                        "alt" => $alt_image[0],
                        "price" => (int)$price,
                        "total" => (int)$price * $quantity
                    ]
                ];
                $cart_total_price = $cart[$id]['total'];
                break;
            // nếu giỏ hàng không trống
            default:
                if( isset($cart[$id]) )//sản phẩm đã tồn tại
                {
                    $cart[$id]['quantity'] += $quantity;
                    $cart[$id]['total'] = (int)$cart[$id]['quantity'] * (int)$cart[$id]['price'];

                    $cart_total_price = 0;
                    foreach ($cart as $key => $item){
                        $cart_total_price += (int)$item['total'];
                    }
                }else {//sản phẩm chưa tồn tại
                    $cart[$id] = [
                        "id" => $id,
                        "code" => $main_product->code,
                        "material" => !empty($materials[$product->material]) ? $materials[$product->material] : '',
                        "name" => $main_product->title,
                        "alias" => url($main_product->alias),
                        "quantity" => $quantity,
                        "image" => $images[0],
                        "title" => $title_image[0],
                        "alt" => $alt_image[0],
                        "price" => (int)$price,
                        "total" => (int)$price * $quantity
                    ];

                    $cart_total_price = 0;
                    foreach ($cart as $key => $item) {
                        $cart_total_price += (int)$item['total'];
                    }
                }
        }

        session()->put('cart', $cart);
        session()->put('cart_total_price', $cart_total_price);

        $count_cart = 0;
        $html       = '';
        if(count($cart) > 0){
            $count_cart = count($cart);
            $cart_total = number_format($cart_total_price, 0, ".", ".") .' đ';
            foreach ($cart as $key => $element){
                $html .= '<li class="single-shopping-cart">
                            <div class="shopping-cart-img">
                                <a href="'.$element['alias'].'"><img style="width: 80px;" alt="'.$element['alt'].'" title="'.$element['title'].'" src="'.$element['image'].'"></a>
                            </div>
                            <div class="shopping-cart-title">
                                <h4><a href="'.$element['alias'].'">'.substr($element['name'],0,18). '...' .'</a></h4>
                                <h6>Số lượng : '.$element['quantity'].'</h6>
                                <span>'.number_format($element['total'], 0, ".", ".") .' đ</span>
                            </div>
                            <div class="shopping-cart-delete">
                                <a href="#" data-id="'.$element['id'] .'"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </div>
                        </li>';
            }
        }
        return response()->json(['status' => 1, 'count_cart' => $count_cart, 'html' => $html, 'cart_total' => $cart_total]);
    }

    public function updateToCart(Request $request)
    {
        $id         = (int)$request->id;
        $quantity   = (int)$request->quantity;

        $cart = session()->get('cart');
        $cart_total_price = 0;

        $cart[$id]["quantity"] = $quantity;
        $cart[$id]['total'] = (int) $cart[$id]["quantity"] * (int) $cart[$id]["price"];

        foreach ($cart as $key => $item){
            $cart_total_price += (int) $item['total'];
        }

        session()->put('cart', $cart);
        session()->put('cart_total_price', $cart_total_price);

        $count_cart = 0;
        $html       = '';
        if(is_array($cart) && count($cart) > 0){
            $count_cart = count($cart);
            $cart_total = number_format($cart_total_price, 0, ".", ".") .' đ';
            foreach ($cart as $key => $element){
                $html .= '<li class="single-shopping-cart">
                            <div class="shopping-cart-img">
                                <a href="'.$element['alias'].'"><img style="width: 80px;" alt="'.$element['alt'].'" title="'.$element['title'].'" src="'.$element['image'].'"></a>
                            </div>
                            <div class="shopping-cart-title">
                                <h4><a href="'.$element['alias'].'">'.substr($element['name'],0,18). '...' .'</a></h4>
                                <h6>Số lượng : '.$element['quantity'].'</h6>
                                <span>'.number_format($element['total'], 0, ".", ".") .' đ</span>
                            </div>
                            <div class="shopping-cart-delete">
                                <a href="#" data-id="'.$element['id'] .'"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </div>
                        </li>';
            }
        }

        return response()->json(['status' => 1, 'count_cart' => $count_cart, 'html' => $html, 'cart_total' => $cart_total, 'total_price' => number_format($cart[$id]['total'], 0, ".", ".").' đ', 'total_price_form' => $cart_total_price ]);
    }

    public function deleteCart(Request $request)
    {
        $cart = [];
        $cart_total_price = 0;

        $count_cart = count($cart);
        $cart_total = '0 đ';
        $html = '<h3 class="page-title">Không có sản phẩm nào trong giỏ hàng</h3>';

        session()->put('cart', $cart);
        session()->put('cart_total_price', $cart_total_price);

        return response()->json(['status' => 1, 'cart_total' => $cart_total, 'count_cart' => $count_cart, 'html' => $html]);
    }

    public function deleteProduct(Request $request)
    {
        $id = $request->id;
        if($id){
            $cart = session()->get('cart');
            unset($cart[$id]);
            $cart_total_price = 0;

            foreach ($cart as $key => $item){
                $cart_total_price += (int) $item['total'];
            }

            session()->put('cart', $cart);
            session()->put('cart_total_price', $cart_total_price);

            $count_cart = 0;
            $cart_total = '0 đ';
            $html       = '';
            $html_table       = '';
            if(is_array($cart) && count($cart) > 0){
                $count_cart = count($cart);
                $cart_total = number_format($cart_total_price, 0, ".", ".") .' đ';
                foreach ($cart as $key => $element){
                    $html .= '<li class="single-shopping-cart">
                            <div class="shopping-cart-img">
                                <a href="'.$element['alias'].'"><img style="width: 80px;" alt="'.$element['alt'].'" title="'.$element['title'].'" src="'.$element['image'].'"></a>
                            </div>
                            <div class="shopping-cart-title">
                                <h4><a href="'.$element['alias'].'">'.substr($element['name'],0,18). '...' .'</a></h4>
                                <h6>Số lượng : '.$element['quantity'].'</h6>
                                <span>'.number_format($element['total'], 0, ".", ".") .' đ</span>
                            </div>
                            <div class="shopping-cart-delete">
                                <a href="#" data-id="'.$element['id'] .'"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </div>
                        </li>';

                    $html_table .= '<tr>
                                        <td>1</td>
                                        <td class="product-thumbnail">
                                            <a href="'.$element['alias'].'"><img style="width: 150px;" alt="'.$element['alt'].'" title="'.$element['title'].'" src="'.$element['image'].'"></a>
                                        </td>
                                        <td class="product-name"><a href="'.$element['alias'].'" title="'.$element['name'].'">'.$element['name'].'</a></td>
                                        <td><a href="">'.$element['code'] .'</a></td>
                                        <td><a href="">'.$element['material'] .'</a></td>
                                        <td class="product-price-cart"><span class="amount">'.$element['price'].'</span></td>
                                        <td class="product-quantity">
                                            <div class="pro-dec-cart">
                                                <input class="cart-plus-minus-box" type="number" value="'.$element['quantity'].'" name="quantity[]" min="1">
                                            </div>
                                        </td>
                                        <td class="product-subtotal red-text">'.number_format($element['total'], 0, ".", ".") .' đ</td>
                                        <td class="product-remove">
                                            <a href="#" data-id="'.$element['id'] .'"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>';
                }
            }

            return response()->json(['status' => 1, 'cart_total' => $cart_total, 'count_cart' => $count_cart, 'html' => $html, 'html_table' => $html_table]);

        }
    }

    private function sendMail($name , $emailRep, $admin = false, $note = "", $phone = null){

        $email = ConfigEmail::find(1);

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->isSMTP();
            $mail->CharSet = "utf-8";
            $mail->SMTPAuth = true;
            $mail->Host = $email->smtp_host;
            $mail->Port = $email->smtp_port;
            $mail->Username = $email->smtp_email;
            $mail->Password = $email->smtp_pass;
            $mail->setFrom($email->smtp_email, $email->smtp_title);
            $mail->Subject = "Yêu Cầu Liên Hệ";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            if( !empty( $phone ) ) {
                $mail->Subject = "Yêu Cầu Liên Hệ - " . $phone;
            }

            $body="";
            if( $admin ) {
                $emailRep = $email->smtp_email;
                $body = !empty( $note ) ?  $note : "";
            }else {
                $body .= $note;
            }

            $mail->MsgHTML($body);
            $mail->addAddress($emailRep);
            $mail->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

}
