<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\User;

class HomepageManager extends Model
{
    protected $table = 'homepage_managers';

    protected $fillable = [
        'title',
        'related_slider',
        'title_funfact',
        'images_funfact',
        'content_funfact',
        'funfact_number',
        'funfact_icon',
        'funfact_description',
        'title_hot',
        'images_hot',
        'description_hot',
        'related_hot',
        'title_hot_2',
        'images_hot_2',
        'description_hot_2',
        'related_hot_2',
        'title_post_hot',
        'images_post_hot',
        'content_post_hot',
        'related_post',
        'title_product_hot',
        'images_product_hot',
        'content_product_hot',
        'related_product_hot',
        'title_endow',
        'images_endow',
        'description_endow',
        'related_endow',
        'title_service',
        'images_service',
        'content_service',
        'services_name',
        'services_url',
        'services_description',
        'title_certify',
        'images_certify',
        'description_certify',
        'related_certify',
        'title_tv',
        'images_tv',
        'description_tv',
        'related_tv',
        'title_newspaper',
        'images_newspaper',
        'description_newspaper',
        'related_newspaper',
        'title_feedback',
        'images_feedback',
        'description_feedback',
        'related_feedback',
        'title_partner',
        'images_partner',
        'description_partner',
        'related_partner',
        'created_by',
        'updated_by'
    ];

    public function User() {
    	return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchHomepageManager( $title = NULL, $limit = 15 ){
        return  HomepageManager::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listHomepageManager( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return HomepageManager::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return HomepageManager::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return HomepageManager::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return HomepageManager::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = HomepageManager::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

    public static function getHomeDefault(){
        $home_default = HomepageManager::where([
            ['home_default', 1],
            ['status', 1]
        ])->first();

        return $home_default;
    }

}
