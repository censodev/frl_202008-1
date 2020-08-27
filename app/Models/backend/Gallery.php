<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\Category;
use App\Models\backend\User;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
    	'category_id', 'title', 'alias', 'view', 'rating', 'images', 'title_image', 'alt_image', 'videos', 'sapo', 'description', 'seo_title', 'seo_desciption', 'seo_keyword', 'seo_google', 'seo_facebook', 'related_post', 'related_gallery', 'created_by', 'updated_by', 'status'
    ];

    public function Category() {
    	return $this->belongsTo(Category::class,'category_id','id');
    }

    public function User() {
    	return $this->belongsTo(User::class,'created_by','id');
    }
	
	public function getCategoryAliasAttribute(){
        return Category::where("id",$this->category_id)->first()->alias;
    }

    public static function searchGallery( $title = NULL, $category_id = NULL , $option = NULL ,$limit = 15){
        if( $category_id == NULL ){
            return  Gallery::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        } else{
            return  Gallery::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ['category_id',$category_id],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        }

    }

    public static function listGallery( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Gallery::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Gallery::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Gallery::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return Gallery::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = Gallery::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

    public static function getGalleryById($id){
        return Gallery::find($id);
    }

    public static function SearchGalleriesByName($title ,$limit=10){
        return  Gallery::where('title',"like",'%'.mb_strtolower($title,'UTF-8').'%')->OrWhere('description',"like",'%'.mb_strtolower($title,'UTF-8').'%')->where("status",1)->paginate($limit);
    }
}
