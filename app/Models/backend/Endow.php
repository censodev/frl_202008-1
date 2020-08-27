<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\User;

class Endow extends Model
{
    protected $table = 'endows';

    protected $fillable = [
        'name', 'description', 'icon', 'created_by', 'updated_by', 'status'
    ];

    public function User() {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchEndow( $name = NULL ,$limit = 15){
        return Endow::where([
            ['name',"like",'%'.mb_strtolower($name,'UTF-8').'%'],
            ["status",1]
        ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listEndow( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Endow::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Endow::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Endow::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return Endow::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = Endow::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

}
