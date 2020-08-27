<?php

namespace App\Models\backend;

use App\Models\backend\User;
use Illuminate\Database\Eloquent\Model;

class SchemaPost extends Model
{
    protected $table = 'schema_posts';

    protected $fillable = [
        'headline',
        'url',
        'id_post',
        'author_name',
        'publisher_name',
        'publisher_logo',
        'images',
        'content',
        'shows',
        'datePublished',
        'dateModified',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'status'
    ];

    public function User() {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchSchemaPost( $name = NULL ,$limit = 15){
        return  SchemaPost::where([
            ['headline',"like",'%'.mb_strtolower($name,'UTF-8').'%'],
            ["status",1]
        ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listSchemaPost( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return SchemaPost::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return SchemaPost::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return SchemaPost::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return SchemaPost::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = SchemaPost::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

}
