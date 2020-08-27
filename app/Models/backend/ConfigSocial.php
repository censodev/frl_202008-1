<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\User;
use App\Models\backend\ConfigSocialClick;

class ConfigSocial extends Model
{
    protected $table = 'config_socials';

    protected $fillable = [
    	'title', 'select_link', 'link', 'link_title', 'icon_default', 'images', 'alt_image', 'title_image', 'created_by', 'updated_by', 'hide_social','status'
    ];

    public function User() {
    	return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchConfigSocial( $title = NULL ,$limit = 15){
        return  ConfigSocial::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listConfigSocial( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return ConfigSocial::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigSocial::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return ConfigSocial::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigSocial::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = ConfigSocial::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

    public function getClickAttribute()
    {
        $number_click = ConfigSocialClick::where('social_id',$this->id)->sum('number_click');
        return $number_click;
    }

}
