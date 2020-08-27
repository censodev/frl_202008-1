<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\User;

class ConfigEmail extends Model
{
    protected $table = 'config_emails';

    protected $fillable = [
    	'title', 'smtp_title', 'smtp_email', 'smtp_pass', 'smtp_port', 'smtp_host', 'smtp_content','smtp_content_cart','created_by', 'updated_by', 'status'
    ];

    public function User() {
    	return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchConfigEmail( $title = NULL ,$limit = 15){
        return  ConfigEmail::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listConfigEmail( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return ConfigEmail::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigEmail::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return ConfigEmail::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigEmail::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = ConfigEmail::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }
}
