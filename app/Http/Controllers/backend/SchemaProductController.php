<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\SchemaProduct;
use App\Models\backend\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreSchemaProductRequest;
use Auth;
use File;
use App\Services\ImageService;

class SchemaProductController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.schemaProduct.';
    private $content = 'content';
    protected $show_where = [
        'trang-chu'             => 'Trang chủ',
        'gioi-thieu'            => 'Giới thiệu',
        'danh-muc-bai-viet'     => 'Trang danh mục bài viết',
        'danh-muc-san-pham'     => 'Trang danh mục sản phẩm',
        'chi-tiet-bai-viet'     => 'Trang chi tiết bài viết',
        'chi-tiet-san-pham'     => 'Trang chi tiết sản phẩm',
        'lien-he'               => 'Liên Hệ'
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
        $data->title   = 'Danh Sách Schema Sản Phẩm';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;
        $list_product = Product::select('title','id')->where('status', 1)->get();
        $data['list_product'] = $list_product;


        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['schema'] = SchemaProduct::searchSchemaProduct($data->keyword, $this->limit);
        }else {
            $data['schema'] = SchemaProduct::listSchemaProduct(Null, true, $this->limit);
        }

        $data['keyword'] = $data->keyword;
        $data['create_new'] = route('schema_product.create');

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
        $data->title   = 'Thêm Mới Schema Sản Phẩm';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;
        $list_product = Product::select('title','id')->where('status', 1)->get();
        $data['list_product'] = $list_product;

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

        $content = [
            "@context"          => "https://schema.org",
            "@type"             => "Product",
            "name"              => $request->name,
            "image"             => $request->images,
            "description"       => $request->description,
            "brand"             => [
                "@type"     => "Brand",
                "name"      => $request->brand,
            ],
            "review"             => [
                "@type"             => "Review",
                "reviewRating"      => [
                    "@type"  =>  "Rating",
                    "ratingValue"  =>  $request->ratingValue,
                    "bestRating"   =>  "5",
                ],
                "author"           => [
                    "@type" => "Person",
                    "name"  => $request->personReviewName
                ]
            ],
            "aggregateRating"     => [
                "@type"             => "AggregateRating",
                "ratingValue"       => $request->ratingValueTotal,
                "reviewCount"       => $request->reviewCount,
            ],
            "offers"             => [
                "@type"             => "Offer",
                "url"               => $request->product_url,
                "priceCurrency"     => $request->priceCurrency,
                "price"             => $request->price,
                "priceValidUntil"   => $request->datePrice,
                "itemCondition"     => "https://schema.org/UsedCondition",
                "availability"      => "https://schema.org/InStock",
            ],
            "seller" => [
                "@type"             => "Organization",
                "name"              => $request->name_organization,
            ]
        ];

        $data = [
            "name"                      => $request->name,
            "id_product"                => (int) $request->id_product,
            "description"               => $request->description,
            "brand"                     => $request->brand,
            "personReviewName"          => $request->personReviewName,
            "ratingValue"               => (int) $request->ratingValue,
            "ratingValueTotal"          => $request->ratingValueTotal,
            "reviewCount"               => (int) $request->reviewCount,
            "priceCurrency"             => $request->priceCurrency,
            "price"                     => $request->price,
            "product_url"               => $request->product_url,
            "datePrice"                 => $request->datePrice,
            "name_organization"         => $request->name_organization,
            "images"                    => serialize($request->images),
            "content"                   => serialize($content),
            'shows'                     => serialize($request->shows),
            'status'                    => (int) $request->status,
            'created_by'                =>  $user_id
        ];

        try{
            $create_schema =  SchemaProduct::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('schema_product.index')->with('message', $message);
            }
            return redirect()->route('schema_product.edit',$create_schema->id)->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_product')->with('error', $error);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(SchemaProduct $SchemaProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(SchemaProduct $SchemaProduct)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Schema Sản Phẩm';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;

        $list_product = Product::select('title','id')->where('status', 1)->get();
        $data['list_product'] = $list_product;

        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if( SchemaProduct::checkExists( $SchemaProduct->id ) ) {
            $data['schema']       = $SchemaProduct;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('schema_product.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StorePartnerRequest  $request
     * @param  \App\Models\backend\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchemaProduct $SchemaProduct)
    {
        $message        = 'Đã cập nhật schema thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $SchemaProduct ) {

            $user_id = $this->getUserData()->id ?? 1;

            $content = [
                "@context"          => "https://schema.org",
                "@type"             => "Product",
                "name"              => $request->name,
                "image"             => $request->images,
                "description"       => $request->description,
                "brand"             => [
                    "@type"     => "Brand",
                    "name"      => $request->brand,
                ],
                "review"             => [
                    "@type"             => "Review",
                    "reviewRating"      => [
                        "@type"  =>  "Rating",
                        "ratingValue"  =>  $request->ratingValue,
                        "bestRating"   =>  "5",
                    ],
                    "author"           => [
                        "@type" => "Person",
                        "name"  => $request->personReviewName
                    ]
                ],
                "aggregateRating"     => [
                    "@type"             => "AggregateRating",
                    "ratingValue"       => $request->ratingValueTotal,
                    "reviewCount"       => $request->reviewCount,
                ],
                "offers"             => [
                    "@type"             => "Offer",
                    "url"               => $request->product_url,
                    "priceCurrency"     => $request->priceCurrency,
                    "price"             => $request->price,
                    "priceValidUntil"   => $request->datePrice,
                    "itemCondition"     => "https://schema.org/UsedCondition",
                    "availability"      => "https://schema.org/InStock",
                ],
                "seller" => [
                    "@type"             => "Organization",
                    "name"              => $request->name_organization,
                ]
            ];

            $data = [
                "name"                      => $request->name,
                "id_product"                => (int) $request->id_product,
                "description"               => $request->description,
                "brand"                     => $request->brand,
                "personReviewName"          => $request->personReviewName,
                "ratingValue"               => (int) $request->ratingValue,
                "ratingValueTotal"          => $request->ratingValueTotal,
                "reviewCount"               => (int) $request->reviewCount,
                "priceCurrency"             => $request->priceCurrency,
                "price"                     => $request->price,
                "product_url"               => $request->product_url,
                "datePrice"                 => $request->datePrice,
                "name_organization"         => $request->name_organization,
                "images"                    => serialize($request->images),
                "content"                   => serialize($content),
                'shows'                     => serialize($request->shows),
                'status'                    => (int) $request->status,
                'created_by'                =>  $user_id
            ];

            try{
                $SchemaProduct->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('schema_product.index')->with('message', $message);
                }
                return redirect()->route('schema_product.edit',$SchemaProduct->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();
                return redirect()->route('schema_product.edit',$SchemaProduct->id)->with('error', $error);
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
        $SchemaProduct = SchemaProduct::find($id);

        $data = [
            'status'    =>  -2
        ];

        $SchemaProduct->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }
}
