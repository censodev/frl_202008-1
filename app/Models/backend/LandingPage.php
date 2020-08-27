<?php

namespace App\Models\backend;

use App\Models\backend\User;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $table = 'landing_pages';

    protected $fillable = [
        'title', 'category_id','alias', 'images','title_image','alt_image','seo_title', 'seo_desciption','seo_keyword','related_slider', 'title_about', 'images_about', 'title_image_about', 'alt_image_about', 'video_about', 'content_about', 'title_button_about', 'button_link_about', 'title_service', 'images_service', 'content_service', 'related_post_service','services_name','services_price','services_url','services_description', 'title_why', 'content_why', 'images_why', 'why_title', 'why_icon', 'why_description', 'title_product_hot', 'images_product_hot', 'content_product_hot', 'title_product_sale', 'images_product_sale', 'content_product_sale', 'title_product_selling', 'images_product_selling', 'content_product_selling', 'related_product_hot', 'related_product_sale', 'related_product_selling', 'title_funfact', 'content_funfact', 'images_funfact', 'funfact_number', 'funfact_icon', 'funfact_description', 'title_gallery', 'related_gallery', 'title_team', 'content_team', 'images_team', 'related_team', 'title_feedback', 'content_feedback', 'images_feedback', 'title_news', 'images_news', 'related_post', 'related_partner', 'created_by', 'updated_by', 'home_default', 'status', 'description_partner' ,'title_partner'
    ];

    public function User() {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public static function searchLandingPage( $title = NULL, $limit = 15 ){
        return LandingPage::where([
            ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
            ["status",1]
        ])->orderBy('id', 'DESC')->paginate($limit);

    }

    public static function listsearchLandingPage( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return LandingPage::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return LandingPage::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return LandingPage::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return LandingPage::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = LandingPage::find($id);

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

    public static function findDetailbyalias($alias){

        $landingPage =  LandingPage::where([
            'status' => 1,
            'alias' => $alias
        ])->get();
        if( $landingPage->count() > 0 ) {
            return $landingPage =  LandingPage::where([
                ["status",1],
                ["alias",$alias]
            ])->first() ;
        }else {
            return  null;
        }

    }

}
