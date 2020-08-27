<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\ConfigEmail;
use App\Models\backend\Order;
use App\Models\backend\Agency;
use Illuminate\Http\Request;
use App\Models\backend\Url;
use App\Models\backend\Guarantee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Models\backend\Product;
use Illuminate\Support\Facades\Storage;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Auth;

class OrderController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.order.';
    private $content = 'content';
    private $order_status = [
        'Đã Đặt',
        'Đang Xử Lí',
        'Đang Vận Chuyển',
        'Hoàn Tất',
        'Đã Hủy',
    ];

    public function getUserData() {
        $this->user = Auth::user();
        return $this->user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = new Collection();
        $data->title   = 'Danh Sách Đơn Hàng';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;
        $data->order_status = $this->order_status;

        $data->agency = Agency::listAgency();

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['orders'] = Order::searchOrder($data->keyword,NULL,50);
        }else {
            $data['orders'] = Order::listOrder(Null, true, $this->limit);
        }

        return View($data->view,compact('data'));

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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Đơn Hàng';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;
        $data->order_status = $this->order_status;

        $error = 'Không tìm thấy dữ liệu về đơn hàng này. Vui lòng thử lại.';

        if( Order::checkExists( $order->id ) ) {
            $data['order']       = $order;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('order.index')->with('error', $error);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $data_request = $request->all();
        $host_name = env('APP_URL');

        $message        = 'Đã cập nhật đơn hàng thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $order ) {

            $user_id = $this->getUserData()->id ?? $order->created_by;

            if($order->order_status == 3){
                $data_cart = unserialize($order->data_cart);

                foreach ($data_cart as $key => $item){
                    $code_product = $data_request['code_product_'.$key];
                    $seri_product = $data_request['seri_product_'.$key];
                    $link_bao_hanh = 'bao-hanh';

                    foreach ($seri_product as $item_seri){
                        $link_bao_hanh .= '-'.$item_seri;
                    }

                    $content_qrcode  = QrCode::format('png')->size(300)->generate($host_name.'/'.$link_bao_hanh);
                    $name_img_qr_code_bao_hanh = 'baohanh_'. $item['id'] .'_'.generateRandomString() . '.png';
                    Storage::disk('qr_code_bao_hanh')->put($name_img_qr_code_bao_hanh, $content_qrcode);

                    $data_cart[$key]['code_product']                = $code_product;
                    $data_cart[$key]['seri_product']                = $seri_product;
                    $data_cart[$key]['begin_guarantee']             = $data_request['begin_guarantee_'.$key];
                    $data_cart[$key]['end_guarantee']               = $data_request['end_guarantee_'.$key];
                    $data_cart[$key]['name_img_qr_code_bao_hanh']   = $name_img_qr_code_bao_hanh;
                    $data_cart[$key]['link_bao_hanh']               = $link_bao_hanh;


                    $old_guarantee = Guarantee::where('alias', $link_bao_hanh)
                        ->where('status',1)
                        ->get();

                    if(!empty($old_guarantee) && count($old_guarantee) == 0){
                        $data_guarantee = [
                            'order_id'      => $order->id,
                            'product_id'    => $key,
                            'alias'         => $link_bao_hanh,
                            'created_by'    =>  $user_id,
                            'status'        =>  1
                        ];
                        $guarantee = Guarantee::create( $data_guarantee );

                        $data_url = [
                            'url'       =>  $link_bao_hanh,
                            'module'    =>  'Guarantee',
                            'action'    =>  'index',
                            'object_id' =>  $guarantee->id,
                        ];
                        Url::create( $data_url );
                    }
                }

                $data = [
                    'code_cart'         =>  $request->code_cart,
                    'data_cart'         =>  serialize($data_cart),
                    'updated_by'        =>  $user_id,
                ];

                try{
                    $order->update( $data );
                    return redirect('admin/order/'. $order->id .'/edit')->with('message', $message);

                } catch(\Exception $e){
                    $error = $e->getMessage();
                    return redirect('admin/order/'. $order->id .'/edit')->with('error', $error);
                }
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        $data = [
            'status'    =>  -2
        ];

        $order_delete = $order->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

    public function delete( $id )
    {
        $message            = 'Xóa thành công.';
        $error_not_exist    = 'Lỗi khi xóa dữ liệu, hoặc dữ liệu không tồn tại. Vui lòng thử lại.';
        $error_save         = "Có lỗi xảy ra trong quá trình xóa dữ liệu. Vui lòng thử lại.";
        $order = Order::find($id);

        if( $order ) {
            $data = [
                'status'    =>  -2
            ];
            try{
                $delete_order = $order->update( $data );

                return redirect()->route('order.index')->with('message', $message);

            }catch(\Exception $e){
                return redirect()->route('order.index')->with('error', $error_save);

            }

        }else {
            return back()->with('error', $error_not_exist);

        }

    }

    public function changeAgency(Request $request)
    {
        $message  = 'Đã chọn đại lý thành công.';
        $error       = 'Đã có lỗi xảy ra. Xin vui lòng thử lại';
        $id_order       = $request->id_order;
        $id_agency       = $request->id_agency;

        try {
            $order = Order::find($id_order);
            $user_id = $this->getUserData()->id ?? $order->created_by;

            $data = [
                'agency_id'         =>  (int)$id_agency,
                'updated_by'        =>  $user_id,
            ];
            $order->update($data);
            $carts = unserialize($order->data_cart);

            //thông tin đại lý
            $agency = Agency::find($id_agency);

            //gửi thông tin đơn hàng cho đại lý
            $email = ConfigEmail::find(1);
            $content = $email->smtp_content_cart;

            $table_cart = '<table><tbody>
                            <tr>
                                <td>Sản Phẩm</td>
                                <td>Số Lượng</td>
                                <td>Giá</td>
                                <td>Thành Tiền</td>
                            </tr>';
            foreach ($carts as $key => $item_cart){
                $table_cart .= '<tr>
                                    <td>'.$item_cart['name'].'</td>
                                    <td>'.$item_cart['quantity'].'</td>
                                    <td>'.number_format($item_cart['price'],0, ".", ".").' đ'.'</td>
                                    <td>'.number_format($item_cart['total'], 0, ".", ".").' đ'.'</td>
                                </tr>';
            }

            $table_cart .= '<tr>
                                <td></td>
                                <td></td>
                                <td>Thành Tiền</td>
                                <td>'.number_format($order->total_price_cart, 0, ".", ".").' đ'.'</td>
                            </tr>';
            $table_cart .= '</tbody></table>';

            $table_customer = '<table><tbody>
                            <tr>
                                <td>Tên</td>
                                <td>'.$order->name.'</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>'.$order->email.'</td>
                            </tr>
                            <tr>
                                <td>Số điện thoại</td>
                                <td>'.$order->phone.'</td>
                            </tr>
                            <tr>
                                <td>Địa chỉ</td>
                                <td>'.$order->address.'</td>
                            </tr>
                            <tr>
                                <td>Ghi Chú</td>
                                <td>'.$order->note.'</td>
                            </tr>';
            $table_customer .= '</tbody></table>';

            $array_begin = ['code_cart', 'date_cart', 'pay_method_cart', 'table_cart', 'table_customer'];
            $array_change = [$order->code_cart, $order->created_at, $order->pay_method, $table_cart, $table_customer];
            $body_note = str_replace($array_begin, $array_change, $content);
            $this->sendMail($agency->name, $agency->email, false, $body_note);

            return response()->json(['message' => $message], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 200);
        }
    }

    public function changeStatus(Request $request)
    {
        $message            = 'Đã thay đổi trạng thái thành công.';
        $error              = 'Đã có lỗi xảy ra. Xin vui lòng thử lại';

        $id_order           = $request->id_order;
        $order_status       = $request->order_status;

        try {
            $order = Order::find($id_order);
            $user_id = $this->getUserData()->id ?? $order->created_by;

            $data = [
                'order_status'         =>  (int)$order_status,
                'updated_by'        =>  $user_id,
            ];
            $order->update($data);

            return response()->json(['message' => $message], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $error], 200);
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
