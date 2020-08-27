<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\SchemaPost;
use App\Models\backend\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreSchemaPostRequest;
use Auth;
use File;
use App\Services\ImageService;

class SchemaPostController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.schemaPost.';
    private $content = 'content';
    protected $show_where = [
        'trang-chu'             => 'Trang chủ',
        'gioi-thieu'            => 'Giới thiệu',
        'danh-muc-bai-viet'     => 'Trang danh mục bài viết',
        'danh-muc-san-pham'     => 'Trang danh mục sản phẩm',
        'chi-tiet-bai-viet'     => 'Trang chi tiết bài viết',
        'chi-tiet-san-pham'     => 'Trang chi tiết sản phẩm',
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
        $data->title   = 'Danh Sách Schema Bài Viết';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;
        $list_post = Post::select('title','id')->where('status', 1)->get();
        $data['list_post'] = $list_post;


        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['schema'] = SchemaPost::searchSchemaPost($data->keyword, $this->limit);
        }else {
            $data['schema'] = SchemaPost::listSchemaPost(Null, true, $this->limit);
        }

        $data['keyword'] = $data->keyword;
        $data['create_new'] = route('schema_post.create');

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
        $data->title   = 'Thêm Mới Schema Bài Viết';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;
        $list_post = Post::select('title','id')->where('status', 1)->get();
        $data['list_post'] = $list_post;

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
        $message        = 'Đã thêm schema bài viết thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        $user_id = $this->getUserData()->id ?? 1;

        $content = [
            "@context"  => "https://schema.org",
            "@type"     => "NewsArticle",
            "mainEntityOfPage"=> [
                "@type" => "WebPage",
                "@id"   => $request->url
            ],
            "headline" => $request->headline,
            "image"    => $request->images,
            "datePublished" => $request->datePublished,
            "dateModified" => $request->dateModified,
            "author"    => [
                "@type" => "Person",
                "name"  => $request->author_name,
            ],
            "publisher" => [
                "@type" => "Organization",
                "name"  => $request->publisher_name,
                "logo"  => [
                    "@type" => "ImageObject",
                    "url"   => $request->publisher_logo,
                ]
            ]
        ];

        $data = [
            "headline"          => $request->headline,
            "url"               => $request->url,
            "id_post"           => (int) $request->id_post,
            "datePublished"     => $request->datePublished,
            "dateModified"      => $request->dateModified,
            "author_name"       => $request->author_name,
            "publisher_name"    => $request->publisher_name,
            "publisher_logo"    => $request->publisher_logo,
            "images"            => serialize($request->images),
            "content"           => serialize($content),
            'shows'             => serialize($request->shows),
            'status'            => (int) $request->status,
            'created_by'        =>  $user_id
        ];

        try{
            $create_schema =  SchemaPost::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('schema_post.index')->with('message', $message);
            }
            return redirect()->route('schema_post.edit',$create_schema->id)->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_post')->with('error', $error);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(SchemaPost $SchemaPost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(SchemaPost $SchemaPost)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Schema Bài Viết';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;
        $list_post = Post::select('title','id')->where('status', 1)->get();
        $data['list_post'] = $list_post;

        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if( SchemaPost::checkExists( $SchemaPost->id ) ) {
            $data['schema']       = $SchemaPost;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('schema_post.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchemaPost $SchemaPost)
    {
        $message        = 'Đã cập nhật schema thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $SchemaPost ) {

            $user_id = $this->getUserData()->id ?? 1;

            $content = [
                "@context"  => "https://schema.org",
                "@type"     => "NewsArticle",
                "mainEntityOfPage"=> [
                    "@type" => "WebPage",
                    "@id"   => $request->url
                ],
                "headline" => $request->headline,
                "image"    => $request->images,
                "datePublished" => $request->datePublished,
                "dateModified" => $request->dateModified,
                "author"    => [
                    "@type" => "Person",
                    "name"  => $request->author_name,
                ],
                "publisher" => [
                    "@type" => "Organization",
                    "name"  => $request->publisher_name,
                    "logo"  => [
                        "@type" => "ImageObject",
                        "url"   => $request->publisher_logo,
                    ]
                ]
            ];

            $data = [
                "headline"          => $request->headline,
                "url"               => $request->url,
                "id_post"           => (int) $request->id_post,
                "datePublished"     => $request->datePublished,
                "dateModified"      => $request->dateModified,
                "author_name"       => $request->author_name,
                "publisher_name"    => $request->publisher_name,
                "publisher_logo"    => $request->publisher_logo,
                "images"            => serialize($request->images),
                "content"           => serialize($content),
                'shows'             => serialize($request->shows),
                'status'            => (int) $request->status,
                'created_by'        =>  $user_id
            ];

            try{
                $SchemaPost->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('schema_post.index')->with('message', $message);
                }
                return redirect()->route('schema_post.edit',$SchemaPost->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();
                return redirect()->route('schema_post.edit',$SchemaPost->id)->with('error', $error);
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
        $SchemaPost = SchemaPost::find($id);

        $data = [
            'status'    =>  -2
        ];

        $SchemaPost->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }
}
