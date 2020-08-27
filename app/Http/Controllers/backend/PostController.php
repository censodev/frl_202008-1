<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Post;
use App\Models\backend\Category;
use App\Models\backend\Product;
use App\Models\backend\Url;
use App\Models\backend\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StorePostRequest;
use Auth;
use File;
use App\Services\ImageService;

class PostController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
	private $cat 	 = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.post.';
    private $content = 'content';

    public function __construct(ImageService $imageService) {
        $this->image_service = $imageService;
    }

    public function getUserData() {
        $this->user = Auth::user();
        return $this->user;
    }
    /**
     * Display a listing of the resource.
     *
	 * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = new Collection();
        $data->title   = 'Danh Sách Bài Viết';
        $data->keyword = $this->keyword;
		$data->cat 	   = $this->cat;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

		$tmp_cat 	   = -1;

        if( !empty( $request->keyword ) || !empty( $request->cat ) ) {
            $data->keyword = $request->keyword;
			$data->cat	   = $request->cat ?? NULL;
            $data['posts'] = Post::searchPost($data->keyword,$data->cat,NULL,$this->limit);

			$tmp_cat 	   = $request->cat;
        }else {
            $data['posts'] = Post::listPost(Null, true, $this->limit);
        }

		$data['keyword'] 		= $data->keyword;
		$data['create_new'] 	= route('post.create');
		$data['tmp_cat'] 		= $tmp_cat;
		$data['category_list'] 	= Category::getCategoryByType(1, false, false, false);

        return View($data->view,compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = new Collection();
        $data->title   = 'Thêm Mới Bài Viết';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        /* 1: Danh mục bài viết, 2: liên hệ, 3: bài viết đơn */
        $data['category_level'] = Category::getCategoryPostLevel();

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $message = 'Đã thêm mới thành công bài viết.';
        if( !empty( $request->alias ) ) {
            $alias = $request->alias;
        }else {
            $alias = $request->title;
        }

        $alias = utf8tourl( $alias );

        $user_id = $this->getUserData()->id ?? 1;

        $related_product    = !empty( $request->related_product ) ? Genratejsonarray( $request->related_product ) : '';
        $related_post    = !empty( $request->related_post ) ? Genratejsonarray( $request->related_post ) : '';
        $related_gallery = !empty( $request->related_gallery ) ? Genratejsonarray( $request->related_gallery ) : '';

        $data = [
            'category_id'       =>  $request->category_id,
            'title'             =>  $request->title,
            'alias'             =>  $alias,
            'images'            =>  $request->images,
            'title_image'       =>  $request->title_image,
            'alt_image'         =>  $request->alt_image,
            'view'              =>  $request->view,
            'rating'            =>  $request->rating,
            'sapo'              =>  $request->sapo,
            'description'       =>  $request->description,
            'seo_title'         =>  $request->seo_title,
            'seo_desciption'    =>  $request->seo_desciption,
            'seo_keyword'       =>  $request->seo_keyword,
            'seo_google'        =>  $request->seo_google,
            'seo_facebook'      =>  $request->seo_facebook,
            'related_product'           =>  $related_product,
            'related_post'      =>  $related_post,
            'related_gallery'   =>  $related_gallery,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            $create_post = Post::create( $data );

            if( $create_post ) {
                $data_url = [
                    'url'       =>  $alias,
                    'module'    =>  'Post',
                    'action'    =>  'PostDetail',
                    'object_id' =>  $create_post->id,
                ];
                Url::create( $data_url );
            }

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('post.index')->with('message', $message);
            }

            return redirect()->route('post.edit',$create_post->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('post.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Bài Viết';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về bài viết này. Vui lòng thử lại.';

        $url =  Url::findURLByModule( 'Post', $post->id );
        $data['url_id'] = $url->id ?? '';

        if( Post::checkExists( $post->id ) ) {
            $data['post']       = $post;

            /* 1: Danh mục bài viết, 2: liên hệ, 3: bài viết đơn */
            $data['category_level'] = Category::getCategoryPostLevel();


            $relatedProductIds = $data['related_products'] = [];
            if(isset($post->related_product) && !empty($post->related_product)) {

                $relatedProductIds             = json_decode($post->related_product,true);
                $data['related_products']      = Product::whereIn('id', $relatedProductIds)
                    ->where('status',1)
                    ->get();
            }

            $relatedPostIds = $data['related_posts'] = [];
            if(isset($post->related_post) && !empty($post->related_post)) {

                $relatedPostIds             = json_decode($post->related_post,true);
                $data['related_posts']      = Post::whereIn('id', $relatedPostIds)
                    ->where('status',1)
					->get();

            }

            $relatedGalleryIds = $data['related_galleries'] = [];
            if(isset($post->related_gallery) && !empty($post->related_gallery)) {

                $relatedGalleryIds          = json_decode($post->related_gallery,true);
                $data['related_galleries']  = Gallery::whereIn('id', $relatedGalleryIds)
                    ->where('status',1)
					->get();

            }

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('post.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StorePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $message        = 'Đã cập nhật bài viết thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $post ) {
            $alias_old   = $post->alias;
            $images_old  = $post->images;

            if( !empty( $request->alias ) ) {
                $alias = $request->alias;
            }else {
                $alias = $request->title;
            }

            $alias = utf8tourl( $alias );

            if( !empty( $request->images ) ) {
                $images = $request->images;
            }else {
                $images = $images_old;
            }

            $user_id = $this->getUserData()->id ?? $post->created_by;

            $related_product = !empty( $request->related_product ) ? Genratejsonarray( $request->related_product ) : '';
            $related_post    = !empty( $request->related_post ) ? Genratejsonarray( $request->related_post ) : '';
            $related_gallery = !empty( $request->related_gallery ) ? Genratejsonarray( $request->related_gallery ) : '';

            $data = [
                'category_id'       =>  $request->category_id,
                'title'             =>  $request->title,
                'alias'             =>  $alias,
                'images'            =>  $images,
                'title_image'       =>  $request->title_image,
                'alt_image'         =>  $request->alt_image,
                'view'              =>  $request->view,
                'rating'            =>  $request->rating,
                'sapo'              =>  $request->sapo,
                'description'       =>  $request->description,
                'seo_title'         =>  $request->seo_title,
                'seo_desciption'    =>  $request->seo_desciption,
                'seo_keyword'       =>  $request->seo_keyword,
                'seo_google'        =>  $request->seo_google,
                'seo_facebook'      =>  $request->seo_facebook,
                'related_post'      =>  $related_post,
                'related_gallery'   =>  $related_gallery,
                'related_product'   =>  $related_product,
                'updated_by'        =>  $user_id,
            ];

            try{
                $update_post = $post->update( $data );
                $data_url = [];

                if( $update_post ) {
                    $url =  Url::findURLByModule( 'Post', $request->id );

                    if( $url ) {
                        if( $alias != $alias_old ) {
                            $data_url = [
                                'url'       =>  $alias
                            ];

                            $url->update( $data_url );
                        }
                    }else {
                        $data_url = [
                            'url'       =>  $alias,
                            'module'    =>  'Post',
                            'action'    =>  'PostDetail',
                            'object_id' =>  $request->id,
                        ];
                        Url::create( $data_url );
                    }

                }

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('post.index',$post->id)->with('message', $message);
                }

                return redirect()->route('post.edit',$post->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect()->route('post.edit',$post->id)->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    /*
        public function destroy(Post $post)
        {
            $message = 'Xóa thành công.';
            $post->delete();

            return redirect()->route('post.index')->with('message', $message);

        }
    */

   /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        $data = [
            'status'    =>  -2
        ];

        $post_delete = $post->update( $data );

        if( $post_delete ) {
            $url =  Url::findURLByModule( 'Post', $post->id );

            $url->update( $data );

        }

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function delete( $id )
    {
        $message            = 'Xóa thành công.';
        $error_not_exist    = 'Lỗi khi xóa dữ liệu, hoặc dữ liệu không tồn tại. Vui lòng thử lại.';
        $error_save         = "Có lỗi xảy ra trong quá trình xóa dữ liệu. Vui lòng thử lại.";
        $post = Post::find($id);

        if( $post ) {
            $data = [
                'status'    =>  -2
            ];
            try{
                $delete_post = $post->update( $data );

                if( $delete_post ) {
                    $url =  Url::findURLByModule( 'Post', $post->id );

                    $url->update( $data );

                    return redirect()->route('post.index')->with('message', $message);
                }

            }catch(\Exception $e){
                return redirect()->route('post.index')->with('error', $error_save);

            }

        }else {
            return back()->with('error', $error_not_exist);

        }

    }

    /**
     * [searchRelative post]
     * @param  Request $rq
     * @return search html
     */
    public function searchRelative(Request $rq)
    {
        $data = new Collection();
        $data->view    = $this->view.'search';

        $posts          = Post::searchPost($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "article";
        $html           = View($data->view, compact("posts",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

    public function searchRelativeHot(Request $rq)
    {
        $data = new Collection();
        $data->view     = $this->view.'searchHot';

        $posts          = Post::searchPostType('hot',$rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "article_hot";
        $html           = View($data->view, compact("posts",'isAppend','type_search'))->render();

        return response()->json(['status' => 1, 'message' => $html]);

    }

    /**
     * [searchRelativeService post]
     * @param  Request $rq
     * @return search html
     */
    public function searchRelativeService(Request $rq)
    {
        $data = new Collection();
        $data->view    = $this->view.'search-service';

        $posts          = Post::searchPost($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "article-service";
        $html           = View($data->view, compact("posts",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

    /**
     * Post Is Category Feature .
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function isCatFeature($id){
        $message_on  = 'Đã bật thành công.';
        $message_off = 'Đã tắt thành công.';
        $error       = 'Đã có lỗi xảy ra. Xin vui lòng thử lại';
        try {
            $post = Post::find($id);
            if($post->is_cat_feature == "1"){
                $post->is_cat_feature = 0;
                $message = $message_off;
            }
            else{
                $post->is_cat_feature = 1;
                $message = $message_on;
            }
            $post->save();

            return response()->json(['message' => $message], 200);

        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['error' => $error], 200);
        }

    }

    /**
     * Post Is Post Feature.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function isPostFeature($id){
        $message_on  = 'Đã bật thành công.';
        $message_off = 'Đã tắt thành công.';
        $error       = 'Đã có lỗi xảy ra. Xin vui lòng thử lại';
        try {
            $post = Post::find($id);
            if($post->is_post_feature == "1"){
                $post->is_post_feature = 0;
                $message = $message_off;
            }
            else{
                $post->is_post_feature = 1;
                $message = $message_on;
            }
            $post->save();

            return response()->json(['message' => $message], 200);

        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['error' => $error], 200);
        }

    }

}
