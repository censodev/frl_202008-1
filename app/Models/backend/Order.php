<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
    	'agency_id','code_cart','name', 'email', 'phone', 'address', 'note', 'pay_method', 'bankcode', 'data_cart', 'image_qr_code', 'total_price_cart','created_by', 'updated_by', 'order_status', 'status'
    ];

    public static function searchOrder( $order_code = NULL, $option = NULL ,$limit = 15){
        return  Order::where([
            ['order_code',"like",'%'.mb_strtolower($order_code,'UTF-8').'%'],
            ["status",1]
        ])->orderBy('id', 'DESC')->paginate($limit);
    }

    public static function listOrder( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Order::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Order::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Order::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return Order::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = Order::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

}
