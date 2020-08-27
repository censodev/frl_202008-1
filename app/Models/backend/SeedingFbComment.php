<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class SeedingFbComment extends Model
{
    protected $table = 'seedings_fb_comments';

    protected $fillable = [
        'name', 'content', 'likes', 'time', 'image', 'title_image', 'alt_image', 'created_by', 'updated_by', 'status'
    ];

    public static function searchSeeding( $name = NULL ,$limit = 15){
        return  SeedingFbComment::where([
            ['name','like', '%'.mb_strtolower($name,'UTF-8').'%'],
            ['status', 1]
        ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listSeeding( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return SeedingFbComment::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return SeedingFbComment::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return SeedingFbComment::where('status', 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return SeedingFbComment::where('status', 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = SeedingFbComment::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }
}
