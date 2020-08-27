<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $table = 'agencys';

    protected $fillable = [
        'name',
        'password',
        'phone',
        'email',
        'address',
        'bank_code',
        'tax_code',
        'user_name',
        'user_phone',
        'user_date',
        'created_by',
        'updated_by',
        'status'
    ];

    public static function listAgency( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Agency::where(
                    ['id', '<>', $id])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Agency::where(
                ['id', '<>', $id])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Agency::orderBy('id', 'DESC')->paginate($limit);
            }

            return Agency::orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = Agency::find($id);

        if( !empty( $check ) ) {
            return true;
        }

        return false;
    }

    public static function getAgencyById($id){
        return Agency::find($id);
    }


    public static function SearchAgencyByName($title ,$limit=10){
        return  Agency::where('name',"like",'%'.mb_strtolower($title,'UTF-8').'%')->where("status",1)->paginate($limit);
    }
}
