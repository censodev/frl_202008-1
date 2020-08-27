<?php

namespace App\Models\backend;

use App\Models\backend\User;
use Illuminate\Database\Eloquent\Model;

class SchemaProduct extends Model
{
    protected $table = 'schema_products';

    protected $fillable = [
        'name',
        'id_product',
        'description',
        'brand',
        'personReviewName',
        'ratingValue',
        'ratingValueTotal',
        'reviewCount',
        'priceCurrency',
        'price',
        'product_url',
        'datePrice',
        'name_organization',
        'images',
        'content',
        'shows',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'status',
    ];

    public function User() {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchSchemaProduct( $name = NULL ,$limit = 15){
        return  SchemaProduct::where([
            ['name',"like",'%'.mb_strtolower($name,'UTF-8').'%'],
            ["status",1]
        ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listSchemaProduct( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return SchemaProduct::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return SchemaProduct::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return SchemaProduct::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return SchemaProduct::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = SchemaProduct::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

}
