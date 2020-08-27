<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\User;

class Tv extends Model
{
    protected $table = 'tvs';

    protected $fillable = [
        'name', 'name_video', 'link', 'link_title', 'images', 'title_image', 'alt_image', 'description', 'created_by', 'updated_by', 'status'
    ];

    public function User() {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchTv( $name = NULL ,$limit = 15){
        return  Tv::where([
            ['name',"like",'%'.mb_strtolower($name,'UTF-8').'%'],
            ["status",1]
        ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listTv( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Tv::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Tv::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Tv::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return Tv::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = Tv::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

}
