<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\Category;
use App\Models\backend\User;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
    	'category_id', 'title', 'alias', 'images', 'title_image', 'alt_image', 'view', 'rating', 'sapo', 'description', 'seo_title', 'seo_desciption', 'seo_keyword', 'seo_google', 'seo_facebook','related_product', 'related_post', 'related_gallery', 'created_by', 'updated_by', 'is_cat_feature', 'is_post_feature', 'status'
    ];

    public function Category() {
    	return $this->belongsTo(Category::class,'category_id','id');
    }

    public function User() {
    	return $this->belongsTo(User::class,'created_by','id');
    }

    public function getCategoryAttribute(){
        return Category::where("id",$this->category_id)->first()->title;
    }

	public function getCategoryAliasAttribute(){
        return Category::where("id",$this->category_id)->first()->alias;
    }

    public static function searchPost( $title = NULL, $category_id = NULL , $option = NULL ,$limit = 15){
        if( $category_id == NULL ){
            return  Post::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        } else{
            return  Post::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ['category_id',$category_id],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        }

    }

    public static function searchPostType( $type_product = 'hot',$title = NULL, $category_id = NULL , $option = NULL ,$limit = 15, $product_type = Null){
        switch( $type_product ) {
            case 'sale':
                $query_type = 'is_post_sale';
                break;
            case 'selling':
                $query_type = 'is_post_selling';
                break;
            default:
                $query_type = 'is_post_feature';
                break;
        }
        if( $category_id == NULL ){
            return  Post::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                [$query_type, 1],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        } else{
            return  Post::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ['category_id',$category_id],
                [$query_type, 1],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        }

    }

    public static function listPost( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Post::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Post::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Post::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return Post::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = Post::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

    public static function getPostById($id){
        return Post::find($id);
    }

    public static function findDetailbyalias($alias){

        $posts =  Post::where([
                'status' => 1,
                'alias' => $alias
            ])->get();
        // dd($posts);
        if( $posts->count() > 0 ) {
            return $post =  Post::where([
                ["status",1],
                ["alias",$alias]
            ])->first() ;
        }else {
            return  null;
        }

    }

    public static function SearchPostsByName($title ,$limit=10){
        return  Post::where('title',"like",'%'.mb_strtolower($title,'UTF-8').'%')->OrWhere('description',"like",'%'.mb_strtolower($title,'UTF-8').'%')->where("status",1)->paginate($limit);
    }

}
