<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\User;

class ConfigLogo extends Model
{
    protected $table = 'config_logos';

    protected $fillable = [
    	'title', 'link', 'link_title', 'images', 'title_image', 'alt_image', 'type', 'created_by', 'updated_by', 'status'
    ];

    public function User() {
    	return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchConfigLogo( $title = NULL , $type = NULL ,$limit = 15){
        if( $type == NULL ){
            return  ConfigLogo::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        } else{
            return  ConfigLogo::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ['type',$type],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        }

    }

    public static function listConfigLogo( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return ConfigLogo::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigLogo::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return ConfigLogo::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigLogo::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = ConfigLogo::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

}
