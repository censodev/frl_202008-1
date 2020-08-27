<?php

namespace App\Models\backend;
use Illuminate\Database\Eloquent\Model;

class ProductConfig extends Model
{
    protected $table = 'config_product';

    protected $fillable = [
        'material', 'color', 'created_by', 'updated_by', 'status'
    ];

    public static function listProductConfig( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return ProductConfig::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return ProductConfig::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return ProductConfig::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return ProductConfig::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = ProductConfig::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

    public static function getProductConfigById($id){
        return ProductConfig::find($id);
    }

}
