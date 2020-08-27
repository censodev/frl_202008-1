<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\User;

class ConfigFooter extends Model
{
    protected $table = 'config_footers';

    protected $fillable = [
    	'title', 'footer_title', 'footer_description', 'footer_contact_info', 'footer_copyright', 'created_by', 'updated_by', 'status'
    ];

    public function User() {
    	return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchConfigFooter( $title = NULL ,$limit = 15){
        return  ConfigFooter::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listConfigFooter( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return ConfigFooter::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigFooter::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return ConfigFooter::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return ConfigFooter::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = ConfigFooter::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }
}
