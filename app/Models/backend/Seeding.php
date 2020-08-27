<?php

namespace App\Models\backend;

use App\Models\backend\User;
use Illuminate\Database\Eloquent\Model;

class Seeding extends Model
{
    protected $table = 'seedings';

    protected $fillable = [
        'name', 'content', 'time', 'images', 'title_image', 'alt_image', 'created_by', 'updated_by', 'status'
    ];

    public function User() {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchSeeding( $name = NULL ,$limit = 15){
        return  Seeding::where([
            ['name',"like",'%'.mb_strtolower($name,'UTF-8').'%'],
            ["status",1]
        ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listSeeding( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Seeding::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Seeding::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Seeding::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return Seeding::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = Seeding::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

}
