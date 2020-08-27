<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Category;
use App\Models\backend\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreCategoryRequest;
use Auth;
use File;
use App\Services\ImageService;

class CategoryController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
	protected $title = '';
    protected $category_type = [
            'Danh mục bài viết',
            'Liên hệ',
            'Bài viết đơn',
            'Bộ sưu tập',
            'Danh mục sản phẩm',
            'Danh mục LandingPage'
        ];
    protected $section_scroll = [
        'gioi-thieu' => 'Giới thiệu',
        'linh-vuc' => 'Lĩnh Vực',
        'ly-do' => 'Lý Do',
        'thong-ke' => 'Thống Kê',
        'cam-nhan' => 'Cảm Nhận',
        'doi-tac' => 'Đối Tác'
    ];
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.category.';
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
		$data->title   = 'Danh Sách Danh Mục';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword    = $request->keyword;
            $data['category'] = Category::searchCategory($data->keyword,NULL,NULL,$this->limit);
        }else {
            $data['category'] = Category::listCategory(Null, true, $this->limit);
        }

		$data['keyword'] = $data->keyword;
		$data['create_new'] = route('category.create');

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
		$data->title   = 'Thêm Mới Danh Mục';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        $data['category_type'] = $this->category_type;
        $data['section_scroll'] = $this->section_scroll;

        $data['category_all'] = Category::listCategory();

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $message = 'Đã thêm mới thành công danh mục.';
        if( !empty( $request->alias ) ) {
            $alias = $request->alias;
        }else {
            $alias = $request->title;
        }

        $alias = utf8tourl( $alias );

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'parent_id'         =>  $request->parent_id,
            'title'             =>  $request->title,
            'alias'             =>  $alias,
            'alias_external'    =>  $request->alias_external,
            'type'              =>  $request->type,
            'section_scroll'    =>  $request->section_scroll,
            'show_menu_alias'   =>  $request->show_menu_alias,
            'icons'             =>  $request->icons,
            'images'            =>  $request->images,
            'title_image'       =>  $request->title_image,
            'alt_image'         =>  $request->alt_image,
            'images_detail'     =>  $request->images_detail,
            'title_image_detail'=>  $request->title_image_detail,
            'alt_image_detail'  =>  $request->alt_image_detail,
            'ordering'          =>  $request->ordering,
            'description'       =>  $request->description,
            'seo_title'         =>  $request->seo_title,
            'seo_desciption'    =>  $request->seo_desciption,
            'seo_keyword'       =>  $request->seo_keyword,
            'seo_google'        =>  $request->seo_google,
            'seo_facebook'      =>  $request->seo_facebook,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            $create_category = Category::create( $data );

            if( $create_category ) {
                $data_url = [
                    'url'       =>  $alias,
                    'module'    =>  'Category',
                    'action'    =>  $request->type,
                    'object_id' =>  $create_category->id,
                ];
                Url::create( $data_url );
            }

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('category.index')->with('message', $message);
            }

            return redirect()->route('category.edit',$create_category->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('category.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $data = new Collection();
        $data->title   = $category->title;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'show';
        $data->content = $this->content;

        return View($data->view,compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Danh Mục';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về danh mục này. Vui lòng thử lại.';

        $data['category_type'] = $this->category_type;
        $data['section_scroll'] = $this->section_scroll;

        $url =  Url::findURLByModule( 'Category', $category->id );
        $data['url_id'] = $url->id ?? '';

        if( Category::checkExists( $category->id ) ) {
            $data['category_all']   = Category::listCategory( $category->id );
            $data['category']       = $category;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('category.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $message        = 'Đã cập nhật danh mục thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $category ) {
            $alias_old   = $category->alias;
            $type_old    = $category->type;

            if( !empty( $request->alias ) ) {
                $alias = $request->alias;
            }else {
                $alias = $request->title;
            }

            $alias = utf8tourl( $alias );

            $user_id = $this->getUserData()->id ?? $category->created_by;

            $data = [
                'parent_id'         =>  $request->parent_id,
                'title'             =>  $request->title,
                'alias'             =>  $alias,
                'alias_external'    =>  $request->alias_external,
                'type'              =>  $request->type,
                'section_scroll'    =>  $request->section_scroll,
                'show_menu_alias'   =>  $request->show_menu_alias,
                'icons'             =>  $request->icons,
                'images'            =>  $request->images,
                'title_image'       =>  $request->title_image,
                'alt_image'         =>  $request->alt_image,
                'images_detail'     =>  $request->images_detail,
                'title_image_detail'=>  $request->title_image_detail,
                'alt_image_detail'  =>  $request->alt_image_detail,
                'ordering'          =>  $request->ordering,
                'description'       =>  $request->description,
                'seo_title'         =>  $request->seo_title,
                'seo_desciption'    =>  $request->seo_desciption,
                'seo_keyword'       =>  $request->seo_keyword,
                'seo_google'        =>  $request->seo_google,
                'seo_facebook'      =>  $request->seo_facebook,
                'updated_by'        =>  $user_id,
            ];

            try{
                $update_category = $category->update( $data );
                $data_url = [];

                if( $update_category ) {
                    $url =  Url::findURLByModule( 'Category', $request->id );

                    if( $url ) {
                        if( $alias != $alias_old && $type_old != $request->type ) {
                            $data_url = [
                                'url'       =>  $alias,
                                'action'    =>  $request->type
                            ];
                        }elseif( $alias != $alias_old && $type_old == $request->type ) {
                            $data_url = [
                                'url'       =>  $alias
                            ];
                        }elseif( $alias == $alias_old && $type_old != $request->type ) {
                            $data_url = [
                                'action'    =>  $request->type
                            ];
                        }

                        if( !empty( $data_url ) && sizeof( $data_url ) > 0 ) {
                            $data_url['module']     = 'Category';
                            $data_url['object_id']  = $request->id;

                            $url->update( $data_url );
                        }

                    }else {
                        $data_url = [
                            'url'       =>  $alias,
                            'module'    =>  'Category',
                            'action'    =>  $request->type,
                            'object_id' =>  $request->id,
                        ];
                        Url::create( $data_url );
                    }

                }

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('category.index')->with('message', $message);
                }

                return redirect()->route('category.edit',$category->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect()->route('category.edit',$category->id)->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    /*
        public function destroy(Category $category)
        {
            $message = 'Xóa thành công.';
            $error   = 'Không thể xóa khi còn bài viết hoặc bộ sưu tập thuộc danh mục này.';
            if( count( $category->Post ) === 0 && count( $category->Gallery ) === 0 ) {
                $category->delete();

                return redirect()->route('category.index')->with('message', $message);

            }else {
                return redirect()->route('category.index')->with('error', $error);

            }
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
        $category = Category::find($id);

        $data = [
            'status'    =>  -2
        ];

        $category_delete = $category->update( $data );

        if( $category_delete ) {
            $url =  Url::findURLByModule( 'Category', $category->id );

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
        $error_exist_post   = 'Không thể xóa khi còn bài viết hoặc bộ sưu tập thuộc danh mục này.';
        $error_not_exist    = 'Lỗi khi xóa dữ liệu, hoặc dữ liệu không tồn tại. Vui lòng thử lại.';
        $error_save         = "Có lỗi xảy ra trong quá trình xóa dữ liệu. Vui lòng thử lại.";
        $category = Category::find($id);

        if( $category ) {
            if( count( $category->Post ) === 0 && count( $category->Gallery ) === 0 ) {
                $data = [
                    'status'    =>  -2
                ];
                try{
                    $delete_cat = $category->update( $data );

                    if( $delete_cat ) {
                        $url =  Url::findURLByModule( 'Category', $category->id );

                        $url->update( $data );

                        return redirect()->route('category.index')->with('message', $message);
                    }

                }catch(\Exception $e){
                    return redirect()->route('category.index')->with('error', $error_save);

                }

            }else {
                return redirect()->route('category.index')->with('error', $error_exist_post);

            }

        }else {
            return back()->with('error', $error_not_exist);

        }

    }

    /**
     * Category Is Feature.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function isFeature($id){
        $message_on  = 'Đã bật thành công.';
        $message_off = 'Đã tắt thành công.';
        $error       = 'Đã có lỗi xảy ra. Xin vui lòng thử lại';
        try {
            $category = Category::find($id);
            if($category->is_feature == "1"){
                $category->is_feature = 0;
                $message = $message_off;
            }
            else{
                $category->is_feature = 1;
                $message = $message_on;
            }
            $category->save();

            return response()->json(['message' => $message], 200);

        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['error' => $error], 200);
        }

    }

    /**
     * Category Is Show Menu Main.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function isShowMenuMain($id){
        $message_on  = 'Đã bật thành công.';
        $message_off = 'Đã tắt thành công.';
        $error       = 'Đã có lỗi xảy ra. Xin vui lòng thử lại';
        try {
            $category = Category::find($id);
            if($category->is_show_menu_main == "1"){
                $category->is_show_menu_main = 0;
                $message = $message_off;
            }
            else{
                $category->is_show_menu_main = 1;
                $message = $message_on;
            }
            $category->save();

            return response()->json(['message' => $message], 200);

        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['error' => $error], 200);
        }

    }

}
