<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colors';

    protected $fillable = [
        'name', 'value', 'created_by', 'updated_by', 'status'
    ];

    public function User() {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchColor( $name = NULL ,$limit = 15){
        return  Color::where([
            ['name',"like",'%'.mb_strtolower($name,'UTF-8').'%'],
            ["status",1]
        ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listColor( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Color::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Color::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Color::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return Color::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = Color::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

}
