<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'title',
        'image',
        'alt_image',
        'status',
    ];

    public static function list($limit)
    {
        return Image::where('status', 1)->paginate($limit);
    }

    public static function search( $name = NULL ,$limit = 15){
        return  Image::where([
            ['title',"like",'%'.mb_strtolower($name,'UTF-8').'%'],
            ["status",1]
        ])->orderBy('id', 'DESC')->paginate($limit);

    }
}
