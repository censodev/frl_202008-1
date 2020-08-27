<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Schema;
use App\Models\backend\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreSchema;
use Auth;
use File;
use App\Services\ImageService;

class SchemaController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.schema.';
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
    protected $week = [
        'Monday'         => 'Thứ 2',
        'Tuesday'        => 'Thứ 3',
        'Wednesday'      => 'Thứ 4',
        'Thursday'       => 'Thứ 5',
        'Friday'         => 'Thứ 6',
        'Saturday'       => 'Thứ 7',
        'Sunday'         => 'Chủ Nhật'
    ];
    protected $type = [
        'Book'              => 'Sách',
        'Course'            => 'Khoá học',
        'Event'             => 'Sự kiện',
        'Game'              => 'Game',
        'LocalBusiness'     => 'Doanh nghiệp',
        'Organization'      => 'Tổ chức',
        'Product'           => 'Sản Phẩm',
        'Recipe'            => 'Công thức'
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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = new Collection();
        $data->title   = 'Danh Sách Schema';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword    = $request->keyword;
            $data['schema'] = Schema::searchSchema($data->keyword,NULL,NULL,$this->limit);
        }else {
            $data['schema'] = Schema::listSchema(Null, true, $this->limit);
        }

        return View($data->view,compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //bài viết
    public function schemaArticle()
    {
        $data = new Collection();
        $data->title   = 'Schema Bài Viết';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'article';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;

        $schema_article = Schema::where("type", 'article')->first();

        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if($schema_article){
            $data['schema_article'] = $schema_article;
        }
        return View($data->view,compact('data'));
    }
    public function postschemaArticle(Request $request)
    {

        $message        = 'Đã cập nhật schema thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';
        $data_schema = [
            "headline"          => $request->headline,
            "url"               => $request->url,
            "datePublished"     => $request->datePublished,
            "dateModified"      => $request->dateModified,
            "author_name"       => $request->author_name,
            "publisher_name"    => $request->publisher_name,
            "publisher_logo"    => $request->publisher_logo,
            "images"            => $request->images,
        ];

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
                "name"  => $request->author_name
            ],
            "publisher" => [
                "@type" => "Organization",
                "name"  => $request->publisher_name,
                "logo"  => [
                    "@type" => "ImageObject",
                    "url"   => $request->publisher_logo
                ]
            ]
        ];

        $data = [
            'title'             => 'Schema Bài Viết',
            'contents'          => serialize($content),
            'data_schema'       => serialize($data_schema),
            'shows'             => serialize($request->shows),
            'type'              => 'article',
            'status'            => (int) $request->status,
        ];

        try{

            $schema_article = Schema::where("type", 'article')->first();

            if($schema_article){
                Schema::where("type", 'article')->update($data);
            }else{
                Schema::create( $data );
            }
            return redirect()->route('schema_article')->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_article')->with('error', $error);
        }
    }

    //doanh nghiệp
    public function schemaBusiness()
    {
        $data = new Collection();
        $data->title   = 'Schema Doanh Nghiệp';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'business';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;
        $data['week'] = $this->week;

        $schema_business = Schema::where("type", 'business')->first();

        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if($schema_business){
            $data['schema_business'] = $schema_business;
        }
        return View($data->view,compact('data'));
    }
    public function postschemaBusiness(Request $request)
    {
        $message        = 'Đã cập nhật schema thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';
        $data_schema = [
            "name"                  => $request->name,
            "author"                => $request->author,
            "url"                   => $request->url,
            "streetAddress"         => $request->streetAddress,
            "addressLocality"       => $request->addressLocality,
            "addressRegion"         => $request->addressRegion,
            "postalCode"            => $request->postalCode,
            "addressCountry"        => $request->addressCountry,
            "latitude"              => $request->latitude,
            "longitude"             => $request->longitude,
            "url_address"           => $request->url_address,
            "priceRange"            => $request->priceRange,
            "telephone"             => $request->telephone,
            "images"                => $request->images,
            "ratingValue"           =>  $request->ratingValue,
            "day"                   => $request->day,
            "time_open"             => $request->time_open,
            "time_close"            => $request->time_close,
        ];

        $content = [
            "@context"          => "https://schema.org",
            "@type"             => "LocalBusiness",
            "image"             => $request->images,
            "@id"               => $request->url,
            "name"              => $request->name,
            "address"           => [
                "@type" => $request->images,
                "streetAddress" => $request->streetAddress,
                "addressLocality" => $request->addressLocality,
                "addressRegion" => $request->addressRegion,
                "postalCode" => $request->postalCode,
                "addressCountry" => $request->addressCountry,
            ],
            "review"            => [
                "@type" => "Review",
                "reviewRating" => [
                    "@type" => "Rating",
                    "ratingValue" =>  $request->ratingValue,
                    "bestRating"  =>  "5"
                ],
                "author" => [
                    "@type"     => "Person",
                    "author"    =>  $request->author
                ]
            ],
            "geo"                => [
                "@type" =>  "GeoCoordinates",
                "latitude" => $request->latitude,
                "longitude" => $request->longitude,
            ],
            "url"               => $request->url_address,
            "telephone"         => $request->telephone,
            "priceRange"        => $request->priceRange,
            "openingHoursSpecification" => [
                [
                    "@type" => "OpeningHoursSpecification",
                    "dayOfWeek" => $request->day,
                    "opens" => $request->time_open,
                    "closes" => $request->time_close
                ]
            ]
        ];

        $data = [
            'title'             => 'Schema Doanh Nghiệp',
            'contents'          => serialize($content),
            'data_schema'       => serialize($data_schema),
            'shows'             => serialize($request->shows),
            'type'              => 'business',
            'status'            => (int) $request->status,
        ];

        try{

            $schema_article = Schema::where("type", 'business')->first();

            if($schema_article){
                Schema::where("type", 'business')->update($data);
            }else{
                Schema::create( $data );
            }
            return redirect()->route('schema_business')->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_business')->with('error', $error);

        }
    }

    //breadcrum
    public function schemaBreadcrumb()
    {
        $data = new Collection();
        $data->title   = 'Schema Breadcrumb';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'breadcrumb';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;

        $schema_breadcrumb = Schema::where("type", 'breadcrumb')->first();

        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if($schema_breadcrumb){
            $data['schema_breadcrumb'] = $schema_breadcrumb;
        }
        return View($data->view,compact('data'));
    }
    public function postschemaBreadcrumb(Request $request)
    {
        $message        = 'Đã cập nhật schema thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';
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
            'title'             => 'Schema Breadcrumb',
            'contents'          => serialize($content),
            'data_schema'       => serialize($data_schema),
            'shows'             => serialize($request->shows),
            'type'              => 'breadcrumb',
            'status'            => (int) $request->status,
        ];

        try{

            $schema_breadcrumb = Schema::where("type", 'breadcrumb')->first();

            if($schema_breadcrumb){
                Schema::where("type", 'breadcrumb')->update($data);
            }else{
                Schema::create( $data );
            }
            return redirect()->route('schema_breadcrumb')->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_breadcrumb')->with('error', $error);

        }
    }

    //khoá học
    public function schemaCourse()
    {
        $data = new Collection();
        $data->title   = 'Schema Khoá Học';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'course';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;

        $schema_course = Schema::where("type", 'course')->first();

        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if($schema_course){
            $data['schema_course'] = $schema_course;
        }
        return View($data->view,compact('data'));
    }
    public function postschemaCourse(Request $request)
    {
        $message        = 'Đã cập nhật schema thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';
        $data_schema = [
            "name_cource"           => $request->name_cource,
            "description_cource"    => $request->description_cource,
            "name_organization"     => $request->name_organization,
            "url_organization"      => $request->url_organization,
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
            "@type"             => "Course",
            "name"              => $request->name_cource,
            "description"       => $request->description_cource,
            "provider"          => [
                "@type"     => "Organization",
                "name"      => $request->name_organization,
                "sameAs"    => $request->url_organization,
            ],
            "itemListElement"   => $itemListElement
        ];

        $data = [
            'title'             => 'Schema Khoá Học',
            'contents'          => serialize($content),
            'data_schema'       => serialize($data_schema),
            'shows'             => serialize($request->shows),
            'type'              => 'course',
            'status'            => (int) $request->status,
        ];

        try{

            $schema = Schema::where("type", 'course')->first();

            if($schema){
                Schema::where("type", 'course')->update($data);
            }else{
                Schema::create( $data );
            }
            return redirect()->route('schema_course')->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_course')->with('error', $error);

        }
    }

    //logo
    public function schemaLogo()
    {
        $data = new Collection();
        $data->title   = 'Schema Logo';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'logo';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;

        $schema_logo = Schema::where("type", 'logo')->first();

        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if($schema_logo){
            $data['schema_logo'] = $schema_logo;
        }
        return View($data->view,compact('data'));
    }
    public function postschemaLogo(Request $request)
    {
        $message        = 'Đã cập nhật schema thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';
        $data_schema = [
            "url"               => $request->url,
            "logo"              => $request->logo
        ];

        $content = [
            "@context"  => "https://schema.org",
            "@type"     => "Organization",
            "url"       => $request->url,
            "logo"      => $request->logo
        ];

        $data = [
            'title'             => 'Schema Logo',
            'contents'          => serialize($content),
            'data_schema'       => serialize($data_schema),
            'shows'             => serialize($request->shows),
            'type'              => 'logo',
            'status'            => (int) $request->status,
        ];

        try{

            $schema = Schema::where("type", 'logo')->first();

            if($schema){
                Schema::where("type", 'logo')->update($data);
            }else{
                Schema::create( $data );
            }
            return redirect()->route('schema_logo')->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_logo')->with('error', $error);
        }
    }

    //sản phẩm
    public function schemaProduct()
    {
        $data = new Collection();
        $data->title   = 'Schema Sản Phẩm';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'product';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;

        $schema = Schema::where("type", 'product')->first();
        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if($schema){
            $data['schema_product'] = $schema;
        }
        return View($data->view,compact('data'));
    }
    public function postschemaProduct(Request $request)
    {
        $message        = 'Đã cập nhật schema thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';
        $data_schema = [
            "name"                  => $request->name,
            "description"           => $request->description,
            "brand"                 => $request->brand,
            "personReviewName"      => $request->personReviewName,
            "ratingValue"           => $request->ratingValue,
            "ratingValueTotal"      => $request->ratingValueTotal,
            "reviewCount"           => $request->reviewCount,
            "priceCurrency"         => $request->priceCurrency,
            "price"                 => $request->price,
            "product_url"           => $request->product_url,
            "datePrice"             => $request->datePrice,
            "name_organization"     => $request->name_organization,
            "images"                => $request->images,
        ];

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
            'title'             => 'Schema Sản Phẩm',
            'contents'          => serialize($content),
            'data_schema'       => serialize($data_schema),
            'shows'             => serialize($request->shows),
            'type'              => 'product',
            'status'            => (int) $request->status,
        ];

        try{

            $schema = Schema::where("type", 'product')->first();

            if($schema){
                Schema::where("type", 'product')->update($data);
            }else{
                Schema::create( $data );
            }
            return redirect()->route('schema_product')->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_product')->with('error', $error);
        }
    }

    //sự kiện
    public function schemaEvent()
    {
        $data = new Collection();
        $data->title   = 'Schema Sự Kiện';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'event';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;

        $schema = Schema::where("type", 'event')->first();
        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if($schema){
            $data['schema_event'] = $schema;
        }
        return View($data->view,compact('data'));
    }
    public function  postschemaEvent(Request $request)
    {
        $message        = 'Đã cập nhật schema thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';
        $data_schema = [
            "name"                  => $request->name,
            "description"           => $request->description,
            "brand"                 => $request->brand,
            "startDate"             => $request->startDate,
            "endDate"               => $request->endDate,
            "nameAddress"           => $request->nameAddress,
            "streetAddress"         => $request->streetAddress,
            "addressRegion"         => $request->addressRegion,
            "addressLocality"       => $request->addressLocality,
            "addressCountry"        => $request->addressCountry,
            "postalCode"            => $request->postalCode,
            "price"                 => $request->price,
            "offer_url"             => $request->offer_url,
            "priceCurrency"         => $request->priceCurrency,
            "validFrom"             => $request->validFrom,
            "performer_name"        => $request->performer_name,
            "organization_name"     => $request->organization_name,
            "organization_url"      => $request->organization_url,
            "images"                => $request->images,
        ];

        $content = [
            "@context"                  => "https://schema.org",
            "@type"                     => "Event",
            "name"                      => $request->name,
            "startDate"                 => $request->startDate,
            "endDate"                   => $request->endDate,
            "eventAttendanceMode"       => "https://schema.org/OfflineEventAttendanceMode",
            "eventStatus"               => "https://schema.org/EventScheduled",
            "location"             => [
                "@type"             => "Place",
                "name"             => $request->nameAddress,
                "address"      => [
                    "@type"  =>  "PostalAddress",
                    "PostalAddress"  =>  $request->postalCode,
                    "addressLocality"   =>  $request->addressLocality,
                    "postalCode"   =>  $request->postalCode,
                    "addressRegion"   =>  $request->addressRegion,
                    "addressCountry"   =>  $request->addressCountry
                ]
            ],
            "image"             => $request->images,
            "description"       => $request->description,
            "offers"             => [
                "@type"             => "Offer",
                "url"               => $request->offer_url,
                "price"             => $request->price,
                "priceCurrency"   => $request->priceCurrency,
                "availability"      => "https://schema.org/InStock",
                "validFrom"      => $request->validFrom,
            ],
            "performer"             => [
                "@type"     => "PerformingGroup",
                "name"      => $request->performer_name,
            ],
            "organizer"             => [
                "@type"     => "Organization",
                "name"      => $request->organization_name,
                "url"      => $request->organization_url,
            ],
        ];

        $data = [
            'title'             => 'Schema Sự Kiện',
            'contents'          => serialize($content),
            'data_schema'       => serialize($data_schema),
            'shows'             => serialize($request->shows),
            'type'              => 'event',
            'status'            => (int) $request->status,
        ];

        try{

            $schema = Schema::where("type", 'event')->first();

            if($schema){
                Schema::where("type", 'event')->update($data);
            }else{
                Schema::create( $data );
            }
            return redirect()->route('schema_event')->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_event')->with('error', $error);
        }
    }

    //tìm kiếm
    public function schemaSearch()
    {
        $data = new Collection();
        $data->title   = 'Schema Tìm Kiếm';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'search';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;

        $schema = Schema::where("type", 'search')->first();
        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if($schema){
            $data['schema_search'] = $schema;
        }
        return View($data->view,compact('data'));
    }
    public function postschemaSearch(Request $request)
    {
        $message        = 'Đã cập nhật schema thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';
        $data_schema = [
            "url"                  => $request->url
        ];

        $content = [
            "@context"                  => "https://schema.org",
            "@type"                     => "WebSite",
            "url"                       => $request->url,
            "potentialAction"           => [
                "@type"       => "SearchAction",
                "target"      => $request->url."/search?q={search_term_string}",
                "query-input" => "required name=search_term_string"
            ]
        ];

        $data = [
            'title'             => 'Schema Tìm Kiếm',
            'contents'          => serialize($content),
            'data_schema'       => serialize($data_schema),
            'shows'             => serialize($request->shows),
            'type'              => 'search',
            'status'            => (int) $request->status,
        ];

        try{

            $schema = Schema::where("type", 'search')->first();

            if($schema){
                Schema::where("type", 'search')->update($data);
            }else{
                Schema::create( $data );
            }
            return redirect()->route('schema_search')->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_search')->with('error', $error);
        }
    }

    //câu hỏi
    public function schemaQuestion()
    {
        $data = new Collection();
        $data->title   = 'Schema Câu Hỏi';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'question';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;

        $schema = Schema::where("type", 'question')->first();
        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if($schema){
            $data['schema_question'] = $schema;
        }
        return View($data->view,compact('data'));
    }
    public function postschemaQuestion(Request $request)
    {
        $message        = 'Đã cập nhật schema thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';
        $data_schema = [
            "title"                  => $request->title,
            "reply"                  => $request->reply
        ];

        $list_question = [];
        if($data_schema['title'] && count($data_schema['title']) > 0){
            foreach ($data_schema['title'] as $key => $item){
                $item = [
                    "@type"                 => "Question",
                    "name"                  => $item,
                    "acceptedAnswer"        => [
                        "@type"   => "Answer",
                        "text"    => $data_schema['reply'][$key],
                    ],
                ];
                $list_question[] = $item;
            }
        }

        $content = [
            "@context"                  => "https://schema.org",
            "@type"                     => "FAQPage",
            "mainEntity"                => $list_question

        ];

        $data = [
            'title'             => 'Schema Câu Hỏi',
            'contents'          => serialize($content),
            'data_schema'       => serialize($data_schema),
            'shows'             => serialize($request->shows),
            'type'              => 'question',
            'status'            => (int) $request->status,
        ];

        try{

            $schema = Schema::where("type", 'question')->first();

            if($schema){
                Schema::where("type", 'question')->update($data);
            }else{
                Schema::create( $data );
            }
            return redirect()->route('schema_question')->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_question')->with('error', $error);
        }
    }

    //đánh giá
    public function schemaRate()
    {
        $data = new Collection();
        $data->title   = 'Schema Đánh Giá';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'rate';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;
        $data['type'] = $this->type;

        $schema = Schema::where("type", 'rate')->first();
        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if($schema){
            $data['schema_rate'] = $schema;
        }
        return View($data->view,compact('data'));
    }
    public function postschemaRate(Request $request)
    {
        $message        = 'Đã cập nhật schema thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';
        $data_schema = [
            "type"                  => $request->type,
            "name"                  => $request->name,
            "servesCuisine"         => $request->servesCuisine,
            "priceRange"            => $request->priceRange,
            "telephone"             => $request->telephone,
            "streetAddress"         => $request->streetAddress,
            "addressLocality"       => $request->addressLocality,
            "addressRegion"         => $request->addressRegion,
            "postalCode"            => $request->postalCode,
            "addressCountry"        => $request->addressCountry,
            "ratingValue"           => $request->ratingValue,
            "author_name"           => $request->author_name,
            "organization_name"     => $request->organization_name,
            "reviewBody"            => $request->reviewBody,
            "image"                 => $request->image
        ];

        $content = [
            "@context"                  => "https://schema.org",
            "@type"                     => "Review",
            "itemReviewed"              => [
                "@type"             => $request->type,
                "image"             => $request->image,
                "name"              => $request->name,
                "servesCuisine"     => $request->servesCuisine,
                "priceRange"        => $request->priceRange,
                "telephone"         => $request->telephone,
                "address"           => [
                    "@type"             => "PostalAddress",
                    "streetAddress"     => $request->streetAddress,
                    "addressLocality"   => $request->addressLocality,
                    "addressRegion"     => $request->addressRegion,
                    "postalCode"        => $request->postalCode,
                    "addressCountry"    => $request->addressCountry
                ],
            ],
            "reviewRating"          => [
                "@type"                 => "Rating",
                "ratingValue"           => $request->ratingValue,
            ],
            "author"                => [
                "@type"                 => "Person",
                "name"                  => $request->author_name,
            ],
            "reviewBody"            => $request->reviewBody,
            "publisher"             => [
                "@type"                 => "Organization",
                "name"                  => $request->organization_name,
            ]
        ];

        $data = [
            'title'             => 'Schema Đánh Giá',
            'contents'          => serialize($content),
            'data_schema'       => serialize($data_schema),
            'shows'             => serialize($request->shows),
            'type'              => 'rate',
            'status'            => (int) $request->status,
        ];

        try{

            $schema = Schema::where("type", 'rate')->first();

            if($schema){
                Schema::where("type", 'rate')->update($data);
            }else{
                Schema::create( $data );
            }
            return redirect()->route('schema_rate')->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_rate')->with('error', $error);
        }

    }

    //video
    public function schemaVideo()
    {
        $data = new Collection();
        $data->title   = 'Schema Video';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'video';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;

        $schema = Schema::where("type", 'video')->first();
        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if($schema){
            $data['schema_video'] = $schema;
        }
        return View($data->view,compact('data'));
    }
    public function postschemaVideo(Request $request)
    {
        $message        = 'Đã cập nhật schema thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';
        $data_schema = [
            "type"                  => $request->type,
            "name"                  => $request->name,
            "description"           => $request->description,
            "uploadDate"            => $request->uploadDate,
            "contentUrl"            => $request->contentUrl,
            "embedUrl"              => $request->embedUrl,
            "userInteractionCount"  => $request->userInteractionCount,
            "image"                 => $request->images
        ];

        $content = [
            "@context"                 => "https://schema.org",
            "@type"                    => "VideoObject",
            "name"                     => $request->name,
            "description"              => $request->description,
            "thumbnailUrl"             => $request->images,
            "uploadDate"               => $request->uploadDate,
            "contentUrl"               => $request->contentUrl,
            "embedUrl"                 => $request->embedUrl,
            "interactionStatistic"     => [
                "@type"                    => "InteractionCounter",
                "InteractionCounter"       => [
                    "@type"            => "http://schema.org/WatchAction",
                ],
                "userInteractionCount"     => $request->userInteractionCount,
            ]
        ];

        $data = [
            'title'             => 'Schema Video',
            'contents'          => serialize($content),
            'data_schema'       => serialize($data_schema),
            'shows'             => serialize($request->shows),
            'type'              => 'video',
            'status'            => (int) $request->status,
        ];

        try{

            $schema = Schema::where("type", 'video')->first();

            if($schema){
                Schema::where("type", 'video')->update($data);
            }else{
                Schema::create( $data );
            }
            return redirect()->route('schema_video')->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_video')->with('error', $error);
        }

    }

    //Câu hỏi và trả lời
    public function schemaQa()
    {
        $data = new Collection();
        $data->title   = 'Schema Câu hỏi và trả lời';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'qa';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;

        $schema = Schema::where("type", 'qa')->first();
        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if($schema){
            $data['schema_qa'] = $schema;
        }
        return View($data->view,compact('data'));
    }
    public function postschemaQa(Request $request)
    {
        $message        = 'Đã cập nhật schema thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        $data_schema = [
            "name"                          => $request->name,
            "description"                   => $request->description,
            "answerCount"                   => $request->answerCount,
            "upvoteCount"                   => $request->upvoteCount,
            "dateCreated"                   => $request->dateCreated,
            "author_name"                   => $request->author_name,
            "descriptionAnswer"             => $request->descriptionAnswer,
            "dateCreatedAnswer"             => $request->dateCreatedAnswer,
            "upvoteCountAnswer"             => $request->upvoteCountAnswer,
            "urlAnswer"                     => $request->urlAnswer,
            "author_name_answer"            => $request->author_name_answer,
            "descriptionSuggested"          => $request->descriptionSuggested,
            "dateCreatedSuggested"          => $request->dateCreatedSuggested,
            "upvoteCountSuggested"          => $request->upvoteCountSuggested,
            "urlSuggested"                  => $request->urlSuggested,
            "author_name_suggested"         => $request->author_name_suggested,
        ];

        $suggestedAnswer = [];
        if( !empty($data_schema['descriptionSuggested']) && count($data_schema['descriptionSuggested']) > 0) {
            foreach ($data_schema['descriptionSuggested'] as $key => $item){
                $suggested = [
                    "@type"         => "Answer",
                    "text"          => $item,
                    "dateCreated"          => $data_schema['dateCreatedSuggested'][$key],
                    "upvoteCount"          => $data_schema['upvoteCountSuggested'][$key],
                    "url"          => $data_schema['urlSuggested'][$key],
                    "url"          => [
                        "@type"         => "Person",
                        "name"         => $data_schema['author_name_suggested'][$key],
                    ]
                ];
                $suggestedAnswer[] = $suggested;
            }
        }

        $content = [
            "@context"                 => "https://schema.org",
            "@type"                    => "QAPage",
            "mainEntity"               => [
                "@type"                    => "Question",
                "name"                     => $request->name,
                "text"                     => $request->description,
                "answerCount"              => $request->answerCount,
                "upvoteCount"              => $request->upvoteCount,
                "dateCreated"              => $request->dateCreated,
                "author"                   => [
                    "@type"                     => "Person",
                    "name"                      => $request->author_name,
                ],
                "acceptedAnswer"               => [
                    "@type"                    => "Answer",
                    "text"                     => $request->descriptionAnswer,
                    "dateCreated"              => $request->dateCreatedAnswer,
                    "upvoteCount"              => $request->upvoteCountAnswer,
                    "url"                      => $request->urlAnswer,
                    "author"                   => [
                        "@type"                     => "Person",
                        "name"                      => $request->author_name_answer,
                    ]
                ]
            ],

            "suggestedAnswer"              => $suggestedAnswer
        ];

        $data = [
            'title'             => 'Schema Câu hỏi và Trả lời',
            'contents'          => serialize($content),
            'data_schema'       => serialize($data_schema),
            'shows'             => serialize($request->shows),
            'type'              => 'qa',
            'status'            => (int) $request->status,
        ];

        try{

            $schema = Schema::where("type", 'qa')->first();

            if($schema){
                Schema::where("type", 'qa')->update($data);
            }else{
                Schema::create( $data );
            }
            return redirect()->route('schema_qa')->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_qa')->with('error', $error);
        }

    }

    //Hướng dẫn
    public function schemaTutorial()
    {
        $data = new Collection();
        $data->title   = 'Schema Hướng Dẫn';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'tutorial';
        $data->content = $this->content;
        $data['show_where'] = $this->show_where;

        $schema = Schema::where("type", 'tutorial')->first();
        $error = 'Không tìm thấy dữ liệu về schema này. Vui lòng thử lại.';

        if($schema){
            $data['schema_tutorial'] = $schema;
        }
        return View($data->view,compact('data'));
    }

    public function postschemaTutorial(Request $request)
    {

        $message        = 'Đã cập nhật schema thành công';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        $data_schema = [
            "name"                          => $request->name,
            "description"                   => $request->description,
            "image"                         => $request->image,
            "width_image"                   => $request->width_image,
            "height_image"                  => $request->height_image,
            "name_step"                     => $request->name_step,
            "url_step"                      => $request->url_step,
            "step_one"                      => $request->step_one,
            "step_two"                      => $request->step_two,
            "image_step"                    => $request->image_step,
            "width_image_step"              => $request->width_image_step,
            "height_image_step"             => $request->height_image_step
        ];

        $step = [];
        foreach ($data_schema['name_step'] as $key => $item){
            $item_step = [
                "@type"         => "HowToStep",
                "url"           => $data_schema['url_step'][$key],
                "name"          => $item,
                "itemListElement"       => [
                    [
                        "@type" => "HowToDirection",
                        "text"  => $data_schema['step_one'][$key]
                    ],
                    [
                        "@type" => "HowToDirection",
                        "text"  => $data_schema['step_two'][$key]
                    ]
                ],
                "image"         => [
                    "@type"     => "ImageObject",
                    "url"       => $data_schema['image_step'][$key],
                    "height"    => $data_schema['width_image_step'][$key],
                    "width"     => $data_schema['width_image_step'][$key]
                ]
            ];

            $step[] = $item_step;
        }

        $content = [
            "@context"                 => "https://schema.org",
            "@type"                    => "HowTo",
            "name"                     => $data_schema['name'],
            "description"              => $data_schema['description'],
            "image"                    => [
                "@type"         => "ImageObject",
                "url"           => $data_schema['image'],
                "height"        => $data_schema['height_image'],
                "width"         => $data_schema['width_image'],
            ],
            "step"                     => $step
        ];

        $data = [
            'title'             => 'Schema Hướng Dẫn',
            'contents'          => serialize($content),
            'data_schema'       => serialize($data_schema),
            'shows'             => serialize($request->shows),
            'type'              => 'tutorial',
            'status'            => (int) $request->status,
        ];

        try{

            $schema = Schema::where("type", 'tutorial')->first();

            if($schema){
                Schema::where("type", 'tutorial')->update($data);
            }else{
                Schema::create( $data );
            }
            return redirect()->route('schema_tutorial')->with('message', $message);

        } catch(\Exception $e) {
            $error = $e->getMessage();
            return redirect()->route('schema_tutorial')->with('error', $error);
        }

    }
}
