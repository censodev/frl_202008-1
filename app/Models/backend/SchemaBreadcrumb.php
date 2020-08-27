<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class SchemaBreadcrumb extends Model
{
    protected $table = 'schema_breadcrumbs';

    protected $fillable = [
        'name_breadcrumb',
        'type',
        'id_product',
        'id_post',
        'id_product_cat',
        'id_post_cat',
        'name_last',
        'name',
        'url',
        'content',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'status',
    ];

    public function User() {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchSchemaBreadcrumb( $name = NULL ,$limit = 15){
        return  SchemaBreadcrumb::where([
            ['name_breadcrumb',"like",'%'.mb_strtolower($name,'UTF-8').'%'],
            ["status",1]
        ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listSchemaBreadcrumb( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return SchemaBreadcrumb::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return SchemaBreadcrumb::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return SchemaBreadcrumb::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }
            return SchemaBreadcrumb::where("status", 1)->orderBy('id', 'DESC')->get();
        }
    }

    public static function checkExists($id){
        $check = SchemaBreadcrumb::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }
        return false;
    }
}
