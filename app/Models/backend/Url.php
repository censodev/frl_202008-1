<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $table = 'urls';

    protected $fillable = [
    	'url', 'object_id', 'module', 'action', 'status'
    ];

    public static function findURLByModule($module = 'Category',$object_id)
    {

        $item = Url::whereModule($module)->whereObject_id($object_id)->limit(1)->first();
        if($item) return $item;

        return false;

    }

    public function findURL(string $url)
    {

        $item = Url::whereUrl($url)->limit(1)->first();
        if($item) return $item->toArray();

        abort('404');

    }

}
