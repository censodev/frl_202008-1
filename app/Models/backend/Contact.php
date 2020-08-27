<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = [
    	'fullname', 'phone', 'email', 'address', 'message', 'alias_contact', 'register_contact', 'status'
    ];

    public static function searchContact( $phone = NULL, $limit = 15){
        return  Contact::where([
                ['phone',"like",'%'.mb_strtolower($phone,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listContact( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Contact::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Contact::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Contact::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return Contact::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }
}
