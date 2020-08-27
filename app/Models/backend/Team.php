<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\User;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = [
    	'name', 'position', 'images', 'title_image', 'alt_image', 'social', 'description', 'created_by', 'updated_by', 'status'
    ];

    public function User() {
    	return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchTeam( $name = NULL ,$limit = 15){
        return  Team::where([
                ['name',"like",'%'.mb_strtolower($name,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listTeam( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Team::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Team::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Team::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return Team::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = Team::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

}
