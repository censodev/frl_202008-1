<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\User;

class ConfigSeo extends Model
{
    protected $table = 'config_seos';

    protected $fillable = [
    	'title', 'seo_title', 'seo_description', 'seo_keywords', 'created_by', 'updated_by', 'status'
    ];

    public function User() {
    	return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchConfigSeo( $title = NULL ,$limit = 15){
        return  ConfigSeo::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listConfigSeo( $id = NULL ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return ConfigSeo::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigSeo::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return ConfigSeo::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigSeo::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = ConfigSeo::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }
}
