<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Gallery;
use App\Models\backend\Category;
use App\Models\backend\Url;
use App\Models\backend\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreGalleryRequest;
use Auth;
use File;
use App\Services\ImageService;

class GalleryController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.gallery.';
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
        $data->title   = 'Danh Sách Bộ Sưu Tập';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['gallerys'] = Gallery::searchGallery($data->keyword,NULL,NULL,$this->limit);
        }else {
            $data['gallerys'] = Gallery::listGallery(Null, true, $this->limit);
        }
		
		$data['keyword'] = $data->keyword;
		$data['create_new'] = route('gallery.create');

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
        $data->title   = 'Thêm Mới Bộ Sưu Tập';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        /* 4: Danh mục bộ sưu tập */
        $data['category_level'] = Category::getCategoryGalleryLevel();

        return View($data->view,compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreGalleryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGalleryRequest $request)
    {
        $message = 'Đã thêm mới thành công bộ sưu tập.';
        if( !empty( $request->alias ) ) {
            $alias = $request->alias;
        }else {
            $alias = $request->title;
        }

        $alias = utf8tourl( $alias );

        $user_id = $this->getUserData()->id ?? 1;

        $related_post    = !empty( $request->related_post ) ? Genratejsonarray( $request->related_post ) : '';
        $related_gallery = !empty( $request->related_gallery ) ? Genratejsonarray( $request->related_gallery ) : '';

        $data = [
            'category_id'       =>  $request->category_id,
            'title'             =>  $request->title,
            'alias'             =>  $alias,
            'view'              =>  $request->view,
            'rating'            =>  $request->rating,
            'images'            =>  Genratejsonarray( $request->images ),
            'title_image'       =>  Genratejsonarray( $request->title_image ),
            'alt_image'         =>  Genratejsonarray( $request->alt_image ),
            'videos'            =>  Genratejsonarray( $request->videos ),
            'sapo'              =>  $request->sapo,
            'description'       =>  $request->description,
            'seo_title'         =>  $request->seo_title,
            'seo_desciption'    =>  $request->seo_desciption,
            'seo_keyword'       =>  $request->seo_keyword,
            'seo_google'        =>  $request->seo_google,
            'seo_facebook'      =>  $request->seo_facebook,
            'related_post'      =>  $related_post,
            'related_gallery'   =>  $related_gallery,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            $create_gallery = Gallery::create( $data );

            if( $create_gallery ) {
                $data_url = [
                    'url'       =>  $alias,
                    'module'    =>  'Gallery',
                    'action'    =>  'GalleryDetail',
                    'object_id' =>  $create_gallery->id,
                ];
                Url::create( $data_url );
            }

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('gallery.index')->with('message', $message);
            }

            return redirect()->route('gallery.edit',$create_gallery->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('gallery.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Bộ Sưu Tập';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về bộ sưu tập này. Vui lòng thử lại.';

        $url =  Url::findURLByModule( 'Gallery', $gallery->id );
        $data['url_id'] = $url->id ?? '';

        if( Gallery::checkExists( $gallery->id ) ) {
            $data['gallery']       = $gallery;

            /* 4: Danh mục bộ sưu tập */
            $data['category_level'] = Category::getCategoryGalleryLevel();

            $relatedPostIds = $data['related_posts'] = [];
            if(isset($gallery->related_post) && !empty($gallery->related_post)) {

                $relatedPostIds             = json_decode($gallery->related_post,true);
                $data['related_posts']      = Post::whereIn('id', $relatedPostIds)
                    ->where('status',1)
					->get();

            }

            $relatedGalleryIds = $data['related_galleries'] = [];
            if(isset($gallery->related_gallery) && !empty($gallery->related_gallery)) {

                $relatedGalleryIds          = json_decode($gallery->related_gallery,true);
                $data['related_galleries']  = Gallery::whereIn('id', $relatedGalleryIds)
                    ->where('status',1)
					->get();

            }

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('gallery.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreGalleryRequest  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(StoreGalleryRequest $request, Gallery $gallery)
    {
        $message        = 'Đã cập nhật bộ sưu tập thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $gallery ) {
            $alias_old   = $gallery->alias;

            if( !empty( $request->alias ) ) {
                $alias = $request->alias;
            }else {
                $alias = $request->title;
            }

            $alias = utf8tourl( $alias );

            $user_id = $this->getUserData()->id ?? $gallery->created_by;

            $related_post    = !empty( $request->related_post ) ? Genratejsonarray( $request->related_post ) : '';
            $related_gallery = !empty( $request->related_gallery ) ? Genratejsonarray( $request->related_gallery ) : '';

            $data = [
                'category_id'       =>  $request->category_id,
                'title'             =>  $request->title,
                'alias'             =>  $alias,
                'view'              =>  $request->view,
                'rating'            =>  $request->rating,
                'images'            =>  Genratejsonarray( $request->images ),
                'title_image'       =>  Genratejsonarray( $request->title_image ),
                'alt_image'         =>  Genratejsonarray( $request->alt_image ),
                'videos'            =>  Genratejsonarray( $request->videos ),
                'sapo'              =>  $request->sapo,
                'description'       =>  $request->description,
                'seo_title'         =>  $request->seo_title,
                'seo_desciption'    =>  $request->seo_desciption,
                'seo_keyword'       =>  $request->seo_keyword,
                'seo_google'        =>  $request->seo_google,
                'seo_facebook'      =>  $request->seo_facebook,
                'related_post'      =>  $related_post,
                'related_gallery'   =>  $related_gallery,
                'updated_by'        =>  $user_id,
            ];

            try{
                $update_gallery = $gallery->update( $data );
                $data_url = [];

                if( $update_gallery ) {
                    $url =  Url::findURLByModule( 'Gallery', $request->id );

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
                            'module'    =>  'Gallery',
                            'action'    =>  'GalleryDetail',
                            'object_id' =>  $request->id,
                        ];
                        Url::create( $data_url );
                    }

                }

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('gallery.index')->with('message', $message);
                }

                return redirect()->route('gallery.edit',$gallery->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect()->route('gallery.edit',$gallery->id)->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    /*
        public function destroy(Gallery $gallery)
        {
            $message = 'Xóa thành công.';
            $gallery->delete();

            return redirect()->route('gallery.index')->with('message', $message);
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
        $gallery = Gallery::find($id);

        $data = [
            'status'    =>  -2
        ];

        $gallery_delete = $gallery->update( $data );

        if( $gallery_delete ) {
            $url =  Url::findURLByModule( 'Gallery', $gallery->id );

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
        $gallery = Gallery::find($id);

        if( $gallery ) {
            $data = [
                'status'    =>  -2
            ];
            try{
                $delete_cat = $gallery->update( $data );

                if( $delete_cat ) {
                    $url =  Url::findURLByModule( 'Gallery', $gallery->id );

                    $url->update( $data );

                    return redirect()->route('gallery.index')->with('message', $message);
                }

            }catch(\Exception $e){
                return redirect()->route('gallery.index')->with('error', $error_save);

            }

        }else {
            return back()->with('error', $error_not_exist);

        }

    }

    /**
     * [searchRelative gallery]
     * @param  Request $rq
     * @return search html
     */
    public function searchRelative(Request $rq)
    {
        $data = new Collection();
        $data->view    = $this->view.'search';

        $galleries      = Gallery::searchGallery($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "gallery";
        $html           = View($data->view, compact("galleries",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }
}
