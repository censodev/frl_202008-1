<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\User;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = [
    	'name_customer', 'position', 'images', 'title_image', 'alt_image', 'description', 'created_by', 'updated_by', 'status'
    ];

    public function User() {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchFeedback( $name_customer = NULL, $limit = 15){
        return  Feedback::where([
                ['name_customer',"like",'%'.mb_strtolower($name_customer,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listFeedback( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Feedback::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Feedback::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Feedback::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return Feedback::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }
}
