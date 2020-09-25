<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    protected $fillable = [
        'title',
        'image',
        'alt_image',
        'video_url',
        'status',
    ];

    public static function list($limit)
    {
        return Video::where('status', 1)->paginate($limit);
    }

    public static function search( $name = NULL ,$limit = 15){
        return  Video::where([
            ['title',"like",'%'.mb_strtolower($name,'UTF-8').'%'],
            ["status",1]
        ])->orderBy('id', 'DESC')->paginate($limit);

    }
}
