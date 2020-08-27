<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Category;
use App\Models\backend\SchemaBreadcrumb;
use App\Models\backend\Post;
use App\Models\backend\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Auth;
use File;
use App\Services\ImageService;

class SchemaBreadcrumbController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.schemaBreadcrumb.';
    private $content = 'content';
    protected $show_where = [
        'trang-chu'             => 'Trang chủ',
        'danh-muc-bai-viet'     => 'Trang danh mục bài viết',
        'danh-muc-san-pham'     => 'Trang danh mục sản phẩm',
        'bai-viet-don'          => 'Trang bài viết đơn',
        'san-pham-don'          => 'Trang sản phẩm đơn',
        'lien-he'               => 'Liên hệ'
    ];

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
        $data->title   = 'Danh Sách Schema Breadcrumb';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        $list_post = Post::select('title','id')->where('status', 1)->get();
        $list_product = Product::select('title','id')->where('status', 1)->get();
        $list_product_cat = Category::select('title','id')->where('type', 5)->where('status', 1)->get();
        $list_post_cat = Category::select('title','id')->where('type', 1)->where('status', 1)->get();
        $data['list_post']          = $list_post;
        $data['list_product']       = $list_product;
        $data['show_where']         = $this->show_where;
        $data['list_product_cat']   = $list_product_cat;
        $data['list_post_cat']      = $list_post_cat;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['schema'] = SchemaBreadcrumb::searchSchemaBreadcrumb($data->keyword, $this->limit);
        }else {
            $data['schema'] = SchemaBreadcrumb::listSchemaBreadcrumb(Null, true, $this->limit);
        }

        $data['keyword'] = $data->keyword;
        $data['create_new'] = route('schema_breadcrumb.create');

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
        $data->title   = 'Thêm Mới Schema Breadcrumb';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;
        $list_post = Post::select('title','id')->where('status', 1)->get();
        $list_product = Product::select('title','id')->where('status', 1)->get();
        $list_product_cat = Category::select('title','id')->where('type', 5)->where('status', 1)->get();
        $list_post_cat = Category::select('title','id')->where('type', 1)->where('status', 1)->get();
        $data['list_post']          = $list_post;
        $data['list_product']       = $list_product;
        $data['list_product_cat']   = $list_product_cat;
        $data['list_post_cat']      = $list_post_cat;

        return View($data->view,compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message        = 'Đã cập nhật schema thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        $user_id = $this->getUserData()->id ?? 1;

        $data_schema = [
            "name_last"             => $request->name_last,
            "name"                  => $request->name,
            "url"                   => $request->url,
        ];

        $itemListElement = [];
        if(!empty($data_schema['name']) && count($data_schema['name']) > 0){
            foreach ($data_schema['name'] as $key => $item){
                $q = [
                    '@type' => 'ListItem',
                    "position" =>  $key+1,
                    'name' => $item,
                    'item' => $data_schema['url'][$key],
                ];
                $itemListElement[] = $q;
            }
            $p = [
                '@type' => 'ListItem',
                "position" => count($data_schema['name'])+1,
                'name' => $request->name_last
            ];
            $itemListElement[] = $p;
        }

        $content = [
            "@context"          => "https://schema.org",
            "@type"             => "BreadcrumbList",
            "itemListElement"   => $itemListElement
        ];

        $data = [
            "name_breadcrumb"           => $request->name_breadcrumb,
            "type"                      => $request->type,
            "id_product"                => (int) $request->id_product,
            "id_post"                   => (int) $request->id_post,
            "id_product_cat"            => (int) $request->id_product_cat,
            "id_post_cat"               => (int) $request->id_post_cat,
            "name_last"                 => $request->name_last,
            "name"                      => serialize($request->name),
            "url"                       => serialize($request->url),
            "content"                   => serialize($content),
            'status'                    => (int) $request->status,
            'created_by'                =>  $user_id
        ];

        try{
            $create_schema =  SchemaBreadcrumb::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('schema_breadcrumb.index')->with('message', $message);
            }
            return redirect()->route('schema_breadcrumb.edit',$create_schema->id)->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_breadcrumb.index')->with('error', $error);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(SchemaBreadcrumb $SchemaBreadcrum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(SchemaBreadcrumb $SchemaBreadcrumb)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Schema Breadcrumb';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;
        $list_post = Post::select('title','id')->where('status', 1)->get();
        $list_product = Product::select('title','id')->where('status', 1)->get();
        $list_product_cat = Category::select('title','id')->where('type', 5)->where('status', 1)->get();
        $list_post_cat = Category::select('title','id')->where('type', 1)->where('status', 1)->get();
        $data['list_post']          = $list_post;
        $data['list_product']       = $list_product;
        $data['list_product_cat']   = $list_product_cat;
        $data['list_post_cat']      = $list_post_cat;

        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if( $SchemaBreadcrumb::checkExists( $SchemaBreadcrumb->id ) ) {
            $data['schema']       = $SchemaBreadcrumb;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('schema_breadcrumb.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchemaBreadcrumb $SchemaBreadcrumb)
    {
        $message        = 'Đã cập nhật schema thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $SchemaBreadcrumb ) {

            $user_id = $this->getUserData()->id ?? 1;

            $data_schema = [
                "name_last"             => $request->name_last,
                "name"                  => $request->name,
                "url"                   => $request->url,
            ];

            $itemListElement = [];
            if(!empty($data_schema['name']) && count($data_schema['name']) > 0){
                foreach ($data_schema['name'] as $key => $item){
                    $q = [
                        '@type' => 'ListItem',
                        "position" =>  $key+1,
                        'name' => $item,
                        'item' => $data_schema['url'][$key],
                    ];
                    $itemListElement[] = $q;
                }
                $p = [
                    '@type' => 'ListItem',
                    "position" => count($data_schema['name'])+1,
                    'name' => $request->name_last
                ];
                $itemListElement[] = $p;
            }

            $content = [
                "@context"          => "https://schema.org",
                "@type"             => "BreadcrumbList",
                "itemListElement"   => $itemListElement
            ];

            $data = [
                "name_breadcrumb"           => $request->name_breadcrumb,
                "type"                      => $request->type,
                "id_product"                => (int) $request->id_product,
                "id_post"                   => (int) $request->id_post,
                "id_product_cat"            => (int) $request->id_product_cat,
                "id_post_cat"               => (int) $request->id_post_cat,
                "name_last"                 => $request->name_last,
                "name"                      => serialize($request->name),
                "url"                       => serialize($request->url),
                "content"                   => serialize($content),
                'status'                    => (int) $request->status,
                'created_by'                =>  $user_id
            ];

            try{
                $SchemaBreadcrumb->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('schema_breadcrumb.index')->with('message', $message);
                }
                return redirect()->route('schema_breadcrumb.edit',$SchemaBreadcrumb->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();
                return redirect()->route('schema_breadcrumb.edit',$SchemaBreadcrumb->id)->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $SchemaBreadcrumb = SchemaBreadcrumb::find($id);

        $data = [
            'status'    =>  -2
        ];

        $SchemaBreadcrumb->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }
}
