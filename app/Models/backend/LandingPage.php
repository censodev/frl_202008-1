<?php

namespace App\Models\backend;

use App\Models\backend\User;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $table = 'landing_pages';

    protected $fillable = [
        'title',
        'category_id',
        'alias',
        'image_landing',
        'title_image_landing',
        'alt_image_landing',
        'seo_title',
        'seo_desciption',
        'seo_keyword',
        'created_by',
        'updated_by',
        'home_default',
        'status'
    ];

    public function User() {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function items(){
        return $this->hasMany(LandingPageItem::class, 'id_landing');
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
