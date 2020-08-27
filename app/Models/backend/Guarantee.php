<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    protected $table = 'guarantees';

    protected $fillable = [
        'order_id', 'product_id', 'alias', 'created_by', 'updated_by', 'status'
    ];

    public static function findDetailbyalias($alias){

        $guarantee =  Guarantee::where([
            'status' => 1,
            'alias' => $alias
        ])->get();

        if( $guarantee->count() > 0 ) {
            return $guarantee =  Guarantee::where([
                ["status",1],
                ["alias",$alias]
            ])->first() ;
        }else {
            return  null;
        }

    }
}
