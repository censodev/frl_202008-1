<?php

namespace App\Models\backend;

use App\Models\backend\User;
use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    protected $table = 'popups';

    protected $fillable = [
        'link', 'link_title', 'images', 'title_image', 'alt_image', 'created_by', 'updated_by', 'status'
    ];

    public function User() {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchPopup( $name = NULL ,$limit = 15){
        return  Popup::where([
            ['name',"like",'%'.mb_strtolower($name,'UTF-8').'%'],
            ["status",1]
        ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listPopup( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Popup::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Popup::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Popup::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return Popup::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = Popup::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

}
