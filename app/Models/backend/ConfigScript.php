<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\User;

class ConfigScript extends Model
{
    protected $table = 'config_scripts';

    protected $fillable = [
    	'title', 'script_head', 'script_body', 'script_footer', 'created_by', 'updated_by', 'status'
    ];

    public function User() {
    	return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchConfigScript( $title = NULL ,$limit = 15){
        return  ConfigScript::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listConfigScript( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return ConfigScript::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigScript::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return ConfigScript::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigScript::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = ConfigScript::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }
}
