<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class ConfigSocialClick extends Model
{
    protected $table = 'config_social_clicks';

    protected $fillable = [
    	'social_id', 'date', 'ip', 'number_click','status'
    ];

    public static function checkExists($id){
        $check = ConfigSocial::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

    public static function getSocialClick($id){
        $social_click = ConfigSocialClick::join('config_socials', 'config_social_clicks.social_id', '=', 'config_socials.id')
                        ->where([['config_social_clicks.social_id',$id]])
                        ->select('config_socials.title', 'config_socials.images', 'config_social_clicks.*')
                        ->get();

        return $social_click;
    }

}
