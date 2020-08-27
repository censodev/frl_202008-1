<?php

namespace App\Models\backend;
use Illuminate\Database\Eloquent\Model;
use App\Models\backend\Category;
use App\Models\backend\ProductItem;
use App\Models\backend\User;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
    	'seo_title',
    	'seo_desciption',
    	'seo_keyword',
    	'seo_google',
    	'seo_facebook',
    	'title',
        'images',
        'title_image',
        'alt_image',
    	'alias',
    	'view',
    	'rating',
    	'bought',
    	'price',
    	'code',
    	'image',
    	'title_image',
        'alt_image',
    	'short_description',
    	'sapo',
    	'description',
    	'related_product',
    	'related_post',
    	'related_gallery',
    	'created_by',
    	'updated_by',
    	'created_at',
    	'updated_at',
    	'status'
    ];

    public function categories(){
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id', 'id');
    }

    public function items() {
        return $this->hasMany(ProductItem::class);
    }

    public function User() {
    	return $this->belongsTo(User::class,'created_by','id');
    }

//    public function getCategoryAttribute(){
//        return Category::where("id",$this->category_id)->first()->title;
//    }
//
//	public function getCategoryAliasAttribute(){
//        return Category::where("id",$this->category_id)->first()->alias;
//    }

    public static function searchProduct( $title = NULL, $category_id = NULL , $option = NULL ,$limit = 15){
        if( $category_id == NULL ){
            return  Product::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        } else{
            return  Product::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ['category_id',$category_id],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        }

    }

	public static function searchProductType( $type_product = 'hot',$title = NULL, $category_id = NULL , $option = NULL ,$limit = 15, $product_type = Null){
        switch( $type_product ) {
			case 'sale':
				$query_type = 'is_product_sale';
				break;
            case 'new':
                $query_type = 'is_product_new';
                break;
			case 'selling':
				$query_type = 'is_product_selling';
				break;
			default:
				$query_type = 'is_product_feature';
				break;
		}
		if( $category_id == NULL ){
            return  Product::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
				[$query_type, 1],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        } else{
            return  Product::where([
                ['title',"like",'%'.mb_strtolower($title,'UTF-8').'%'],
                ['category_id',$category_id],
				[$query_type, 1],
                ["status",1]
            ])->orderBy('id', 'DESC')->paginate($limit);
        }

    }

    public static function listProduct( $id = NULL, $paginate = false, $limit = 15 ) {
        if( !empty( $id ) ) {
            if( $paginate ) {
                return Product::where([
                    ['status', '1'],
                    ['id', '<>', $id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Product::where([
                ['status', '1'],
                ['id', '<>', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Product::where("status", 1)->orderBy('id', 'DESC')->paginate($limit);
            }

            return Product::where("status", 1)->orderBy('id', 'DESC')->get();

        }
    }

    public static function checkExists($id){
        $check = Product::find($id);

        if( !empty( $check ) && $check->status == 1 ) {
            return true;
        }

        return false;
    }

    public static function findDetailbyalias($alias){

        $products =  Product::where([
                ["status",1],
                ["alias",$alias]
            ])->get();
        if( $products->count() > 0 ) {
            return $product =  Product::where([
                ["status",1],
                ["alias",$alias]
            ])->first() ;
        }else {
            return  null;
        }

    }

    public static function findbycode($id){
        $result = array();
        $product = Product::find($id)->toArray();

		if($product != null){

			$result['title'] = $product['title'];

			if( isset($product['price_product'] )){
				$result['price'] = $product['price_product'];
			}
			else {
				$result['price'] = 0;
				$result['flag'] = "1";
			}
			if( isset($product['price_promotion']) ){
				$result['price_promotion'] = $product['price_promotion'];
			}
			if( isset($product['title_image']) ){
				$result['title_image'] = $product['title_image'];
			}
			if( isset($product['alt_image']) ){
				$result['alt_image'] = $product['alt_image'];
			}
			if( isset($product['images']) ){
				$result['images'] = $product['images'];
			}

           $result['id'] = $id ;
        }

        return $result;
    }

	public static function getProductSale( $category_id = Null, $paginate = false, $limit = 15 ) {
		if( !empty( $category_id ) ) {
            if( $paginate ) {
                return Product::where([
                    ['status', '1'],
					['is_product_sale',1],
                    ['category_id', $category_id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Product::where([
                ['status', '1'],
				['is_product_sale',1],
                ['category_id', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Product::where([
						["status", 1],
						['is_product_sale',1]
					])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Product::where([
						["status", 1],
						['is_product_sale',1]
					])->orderBy('id', 'DESC')->get();

        }
	}

	public static function getProductHot( $category_id = Null, $paginate = false, $limit = 15 ) {
		if( !empty( $category_id ) ) {
            if( $paginate ) {
                return Product::where([
                    ['status', '1'],
					['is_product_feature',1],
                    ['category_id', $category_id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Product::where([
                ['status', '1'],
				['is_product_feature',1],
                ['category_id', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Product::where([
						["status", 1],
						['is_product_feature',1]
					])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Product::where([
						["status", 1],
						['is_product_feature',1]
					])->orderBy('id', 'DESC')->get();

        }
	}

	public static function getProductSelling( $category_id = Null, $paginate = false, $limit = 15 ) {
		if( !empty( $category_id ) ) {
            if( $paginate ) {
                return Product::where([
                    ['status', '1'],
					['is_product_selling',1],
                    ['category_id', $category_id],
                ])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Product::where([
                ['status', '1'],
				['is_product_selling',1],
                ['category_id', $id],
            ])->orderBy('id', 'DESC')->get();

        }else {
            if( $paginate ) {
                return Product::where([
						["status", 1],
						['is_product_selling',1]
					])->orderBy('id', 'DESC')->paginate($limit);
            }

            return Product::where([
						["status", 1],
						['is_product_selling',1]
					])->orderBy('id', 'DESC')->get();

        }
	}

	public static function SearchProductsByName($title ,$limit=10){
        return  Product::where('title',"like",'%'.mb_strtolower($title,'UTF-8').'%')->OrWhere('description',"like",'%'.mb_strtolower($title,'UTF-8').'%')->where("status",1)->paginate($limit);
    }

}
