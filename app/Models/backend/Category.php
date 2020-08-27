<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\User;
use App\Models\backend\Post;
use App\Models\backend\Gallery;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
    	'parent_id', 'title', 'alias', 'alias_external', 'type', 'section_scroll', 'show_menu_alias', 'icons', 'images', 'title_image', 'alt_image','images_detail','title_image_detail','alt_image_detail', 'ordering', 'description', 'seo_title', 'seo_desciption', 'seo_keyword', 'seo_google', 'seo_facebook', 'is_feature', 'is_show_menu_main', 'is_show_menu_landingpage', 'is_show_menu_landingpage_single', 'created_by', 'updated_by', 'status'
    ];

    public function User() {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'product_category', 'category_id', 'product_id', 'id');
    }

    public function Post() {
    	return $this->hasMany(Post::class,'category_id','id');
    }

    public function categoryWithChild() {
        return $this->hasMany(self::class, 'parent_id')->where('status',1)->with("categoryWithChild");
    }

    public function Gallery() {
    	return $this->hasMany(Gallery::class,'category_id','id');
    }

    public static function searchCategory( $title = NULL, $id = NULL , $option = NULL ,$limit = 15){
        if( $id == NULL ){
            return  Category::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        } else{
            return  Category::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ['id',$id],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        }

    }

    public static function listCategory( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Category::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Category::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Category::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return Category::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = Category::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

    public static function getCategoryById($id){
        return Category::find($id);
    }

    public static function getCategoryByType($type, $is_feature = false, $sort_ordering = false, $paginate = false, $limit = 15){
        $where = [
                ["status",1],
                ["type",$type]
            ];

        if( $is_feature ) {
            $where[] = ["is_feature", 1];
        }

        if( $paginate ) {
            if( $sort_ordering ) {
                return Category::where( $where )->orderBy('id', 'DESC')->paginate($limit)->sortBy('ordering');
            }
            return Category::where( $where )->orderBy('id', 'DESC')->paginate($limit);
        }else {
            if( $sort_ordering ) {
                return Category::where( $where )->orderBy('id', 'DESC')->get()->sortBy('ordering');
            }
            return Category::where( $where )->orderBy('id', 'DESC')->get();
        }
    }

    public function getParentnameAttribute(){
        $categories = Category::find($this->id);

        if($categories->parent_id == -1 ){
            return "-";
        }else {
            return Category::find($categories->parent_id)->title;
        }
    }

    /* 1: Danh mục bài viết, 2: liên hệ, 3: bài viết đơn */
    public static function getCategoryPostLevel(){
        return Category::where("status",1)->whereBetween("type",[1,3])->with("categoryWithChild")->get();
    }

    /* 4: Danh mục bộ sưu tập */
    public static function getCategoryGalleryLevel(){
        return Category::where([
            ["type", 4],
            ["status", 1]
        ])->with("categoryWithChild")->get();
    }

    /* 5: Danh mục sản phẩm */
    public static function getCategoryProductLevel(){
        return Category::where([
            ["type", 5],
            ["status", 1]
        ])->with("categoryWithChild")->get();
    }

}
