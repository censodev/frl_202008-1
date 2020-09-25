<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = 'abouts';

    protected $fillable = [
        'title',
        'content',
        'image',
        'alt_image',
        'title_image',
        'video_embed',
        'position',
        'status',
    ];

    public static function list($limit)
    {
        return About::where('status', 1)->paginate($limit);
    }

    public static function search( $name = NULL ,$limit = 15){
        return  About::where([
            ['title',"like",'%'.mb_strtolower($name,'UTF-8').'%'],
            ["status",1]
        ])->orderBy('id', 'DESC')->paginate($limit);

    }
}
