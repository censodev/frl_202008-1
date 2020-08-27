<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class SignupOffer extends Model
{
    protected $table = 'signup_offers';

    protected $fillable = [
    	'fullname', 'phone', 'email', 'message', 'alias_contact', 'register_contact', 'status'
    ];

    public static function searchSignupOffer( $phone = NULL, $limit = 15){
        return  SignupOffer::where([
                ['phone',"like",'%'.mb_strtolower($phone,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listSignupOffer( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return SignupOffer::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return SignupOffer::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return SignupOffer::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return SignupOffer::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }
}
