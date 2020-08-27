<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class ConfigSocialTopbar extends Model
{
    protected $table = 'config_social_topbars';

    protected $fillable = [
    	'title', 'link', 'icon','image', 'created_by', 'updated_by', 'hide_social','status'
    ];

    public function User() {
    	return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchConfigSocialTopbar( $title = NULL ,$limit = 15){
        return  ConfigSocialTopbar::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listConfigSocialTopbar( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return ConfigSocialTopbar::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigSocialTopbar::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return ConfigSocialTopbar::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigSocialTopbar::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = ConfigSocialTopbar::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

}
