<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\User;

class ConfigContact extends Model
{
    protected $table = 'config_contacts';

    protected $fillable = [
    	'title', 'title_contact', 'images_background', 'google_map', 'description', 'title_contact_info', 'description_info', 'contact_info', 'created_by', 'updated_by', 'status'
    ];

    public function User() {
    	return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchConfigContact( $title = NULL ,$limit = 15 ){
        return  ConfigContact::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listConfigContact( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return ConfigContact::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigContact::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return ConfigContact::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigContact::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = ConfigContact::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

}
