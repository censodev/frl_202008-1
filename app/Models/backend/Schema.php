<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class Schema extends Model
{
    protected $table = 'config_schema';

    protected $fillable = [
            'title','contents','shows','data_schema','type','status','created_by','updated_by'
    ];

    public static function searchSchema( $title = NULL, $category_id = NULL , $option = NULL ,$limit = 15){
        if( $category_id == NULL ){
            return  Schema::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        } else{
            return  Schema::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ['category_id',$category_id],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        }
    }

    public static function listSchema( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Schema::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Schema::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Schema::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return Schema::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = Schema::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

    public static function getSchemaById($id){
        return Schema::find($id);
    }

    public static function findDetailbyalias($alias){

        $schemas =  Schema::where([
            'status' => 1,
            'alias' => $alias
        ])->get();

        if( $schemas->count() > 0 ) {
            return $schemas =  Schema::where([
                ["status",1],
                ["alias",$alias]
            ])->first() ;
        }else {
            return  null;
        }

    }

    public static function SearchSchemaByName($title ,$limit=10){
        return  Schema::where('title',"like",'%'.mb_strtolower($title,'UTF-8').'%')->OrWhere('description',"like",'%'.mb_strtolower($title,'UTF-8').'%')->where("status",1)->paginate($limit);
    }
}
