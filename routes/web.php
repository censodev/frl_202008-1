<?php
use App\Models\backend\Url;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Artisan::call('storage:link');
/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* LaravelFilemanager */
Route::group(['middleware' => 'auth'], function () {
    Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
});

/* Site Map */
Route::get('/sitemap', 'SitemapController@index');

/**
 * Backend
 */

Route::group(['prefix'=>'admin', 'middleware' => 'auth'], function(){
    /* Dashboard */
    Route::get("/" , array(
        'as' 	=> 'dashboard',
        'uses' 	=> 'backend\DashboardController@index',
    ));

    /* HomepageManager */
    Route::resource('homepageManager', 'backend\HomepageManagerController');

    /* LandingPage */
    Route::resource('landingPage', 'backend\LandingPageController');

    /* User */
    Route::resource('user', 'backend\UserController');
    Route::get("user_employee" , array(
        'as' 	=> 'user_employee',
        'uses' 	=> 'backend\UserController@indexEmployee',
    ));

    /* Schema */
    Route::resource('schema', 'backend\SchemaController');

    /* schema article */
//    Route::get("/schema_article" , array(
//        'as' 	=> 'schema_article',
//        'uses' 	=> 'backend\SchemaController@schemaArticle',
//    ));
//    Route::post("/schema_article" , array(
//        'as' 	=> 'post_schema_article',
//        'uses' 	=> 'backend\SchemaController@postschemaArticle',
//    ));

    /* schema business */
    Route::get("/schema_business" , array(
        'as' 	=> 'schema_business',
        'uses' 	=> 'backend\SchemaController@schemaBusiness',
    ));
    Route::post("/schema_business" , array(
        'as' 	=> 'post_schema_business',
        'uses' 	=> 'backend\SchemaController@postschemaBusiness',
    ));

    /* schema breadcrumb */
//    Route::get("/schema_breadcrumb" , array(
//        'as' 	=> 'schema_breadcrumb',
//        'uses' 	=> 'backend\SchemaController@schemaBreadcrumb',
//    ));
//    Route::post("/schema_breadcrumb" , array(
//        'as' 	=> 'post_schema_breadcrumb',
//        'uses' 	=> 'backend\SchemaController@postschemaBreadcrumb',
//    ));

    /* schema course */
//    Route::get("/schema_course" , array(
//        'as' 	=> 'schema_course',
//        'uses' 	=> 'backend\SchemaController@schemaCourse',
//    ));
//    Route::post("/schema_course" , array(
//        'as' 	=> 'post_schema_course',
//        'uses' 	=> 'backend\SchemaController@postschemaCourse',
//    ));

    /* schema logo */
    Route::get("/schema_logo" , array(
        'as' 	=> 'schema_logo',
        'uses' 	=> 'backend\SchemaController@schemaLogo',
    ));
    Route::post("/schema_logo" , array(
        'as' 	=> 'post_schema_logo',
        'uses' 	=> 'backend\SchemaController@postschemaLogo',
    ));

//    /* schema product */
//    Route::get("/schema_product" , array(
//        'as' 	=> 'schema_product',
//        'uses' 	=> 'backend\SchemaController@schemaProduct',
//    ));
//    Route::post("/schema_product" , array(
//        'as' 	=> 'post_schema_product',
//        'uses' 	=> 'backend\SchemaController@postschemaProduct',
//    ));

    /* schema event */
//    Route::get("/schema_event" , array(
//        'as' 	=> 'schema_event',
//        'uses' 	=> 'backend\SchemaController@schemaEvent',
//    ));
//    Route::post("/schema_event" , array(
//        'as' 	=> 'post_schema_event',
//        'uses' 	=> 'backend\SchemaController@postschemaEvent',
//    ));

    /* schema input search */
    Route::get("/schema_search" , array(
        'as' 	=> 'schema_search',
        'uses' 	=> 'backend\SchemaController@schemaSearch',
    ));
    Route::post("/schema_search" , array(
        'as' 	=> 'post_schema_search',
        'uses' 	=> 'backend\SchemaController@postschemaSearch',
    ));

    /* schema câu hỏi*/
//    Route::get("/schema_question" , array(
//        'as' 	=> 'schema_question',
//        'uses' 	=> 'backend\SchemaController@schemaQuestion',
//    ));
//    Route::post("/schema_question" , array(
//        'as' 	=> 'post_schema_question',
//        'uses' 	=> 'backend\SchemaController@postschemaQuestion',
//    ));

    /* schema đánh giá*/
//    Route::get("/schema_rate" , array(
//        'as' 	=> 'schema_rate',
//        'uses' 	=> 'backend\SchemaController@schemaRate',
//    ));
//    Route::post("/schema_rate" , array(
//        'as' 	=> 'post_schema_rate',
//        'uses' 	=> 'backend\SchemaController@postschemaRate',
//    ));

    /* schema video*/
//    Route::get("/schema_video" , array(
//        'as' 	=> 'schema_video',
//        'uses' 	=> 'backend\SchemaController@schemaVideo',
//    ));
//    Route::post("/schema_video" , array(
//        'as' 	=> 'post_schema_video',
//        'uses' 	=> 'backend\SchemaController@postschemaVideo',
//    ));

    /* schema qa*/
//    Route::get("/schema_qa" , array(
//        'as' 	=> 'schema_qa',
//        'uses' 	=> 'backend\SchemaController@schemaQa',
//    ));
//    Route::post("/schema_qa" , array(
//        'as' 	=> 'post_schema_qa',
//        'uses' 	=> 'backend\SchemaController@postschemaQa',
//    ));

    /* schema hướng dẫn*/
//    Route::get("/schema_tutorial" , array(
//        'as' 	=> 'schema_tutorial',
//        'uses' 	=> 'backend\SchemaController@schemaTutorial',
//    ));
//    Route::post("/schema_tutorial" , array(
//        'as' 	=> 'post_schema_tutorial',
//        'uses' 	=> 'backend\SchemaController@postschemaTutorial',
//    ));

    //    Schema Bài Viết
    Route::resource('schema_post', 'backend\SchemaPostController');

    //    Schema Sản Phẩm
    Route::resource('schema_product', 'backend\SchemaProductController');

    //    Schema Breadcrum
    Route::resource('schema_breadcrumb', 'backend\SchemaBreadcrumbController');


    /* Category */
    Route::resource('category', 'backend\CategoryController');
    Route::get("/Category/delete/{id}" , array(
        'as' 	=> 'category_delete',
        'uses' 	=> 'backend\CategoryController@delete',
    ));
    Route::post("/category/is_feature/{id}" , array(
        'as' 	=> 'category_is_feature',
        'uses' 	=> 'backend\CategoryController@isFeature',
    ));
    Route::post("/category/is_show_menu_main/{id}" , array(
        'as' 	=> 'category_is_show_menu_main',
        'uses' 	=> 'backend\CategoryController@isShowMenuMain',
    ));

    /* Post */
    Route::resource('post', 'backend\PostController');
    Route::get("/Post/delete/{id}" , array(
        'as' 	=> 'post_delete',
        'uses' 	=> 'backend\PostController@delete',
    ));
    Route::any("/Post/searchRelative" , array(
        'as' 	=> 'post_search_related',
        'uses' 	=> 'backend\PostController@searchRelative',
    ));
    Route::any("/Post/searchRelativeService" , array(
        'as' 	=> 'post_service_search_related',
        'uses' 	=> 'backend\PostController@searchRelativeService',
    ));
    Route::any("/Post/searchRelativeHot" , array(
        'as' 	=> 'post_search_related_hot',
        'uses' 	=> 'backend\PostController@searchRelativeHot',
    ));
    Route::post("/post/is_cat_feature/{id}" , array(
        'as' 	=> 'post_is_cat_feature',
        'uses' 	=> 'backend\PostController@isCatFeature',
    ));
    Route::post("/post/is_post_feature/{id}" , array(
        'as' 	=> 'post_is_post_feature',
        'uses' 	=> 'backend\PostController@isPostFeature',
    ));

    //Agency
    Route::resource('agency', 'backend\AgencyController');
    Route::get("/Agency/delete/{id}" , array(
        'as' 	=> 'agency_delete',
        'uses' 	=> 'backend\AgencyController@delete',
    ));

    /* Gallery */
    Route::resource('gallery', 'backend\GalleryController');
    Route::get("/Gallery/delete/{id}" , array(
        'as' 	=> 'gallery_delete',
        'uses' 	=> 'backend\GalleryController@delete',
    ));
    Route::any("/Gallery/searchRelative" , array(
        'as' 	=> 'gallery_search_related',
        'uses' 	=> 'backend\GalleryController@searchRelative',
    ));

    /* Slider */
    Route::resource('slider', 'backend\SliderController');
    Route::get("/Slider/delete/{id}" , array(
        'as' 	=> 'slider_delete',
        'uses' 	=> 'backend\SliderController@delete',
    ));
    Route::any("/Slider/searchRelative" , array(
        'as' 	=> 'slider_search_related',
        'uses' 	=> 'backend\SliderController@searchRelative',
    ));

    /* Team */
    Route::resource('team', 'backend\TeamController');
    Route::any("/Team/searchRelative" , array(
        'as' 	=> 'team_search_related',
        'uses' 	=> 'backend\TeamController@searchRelative',
    ));

    /* Partner */
    Route::resource('partner', 'backend\PartnerController');
    Route::any("/Partner/searchRelative" , array(
        'as' 	=> 'partner_search_related',
        'uses' 	=> 'backend\PartnerController@searchRelative',
    ));

    /* Certify */
    Route::resource('certify', 'backend\CertifyController');
    Route::any("/Certify/searchRelative" , array(
        'as' 	=> 'certify_search_related',
        'uses' 	=> 'backend\CertifyController@searchRelative',
    ));

    /* newspaper */
    Route::resource('newspaper', 'backend\NewspaperController');
    Route::any("/Newspaper/searchRelative" , array(
        'as' 	=> 'newspaper_search_related',
        'uses' 	=> 'backend\NewspaperController@searchRelative',
    ));

    /* newspaper */
    Route::resource('tv', 'backend\TvController');
    Route::any("/Tv/searchRelative" , array(
        'as' 	=> 'tv_search_related',
        'uses' 	=> 'backend\TvController@searchRelative',
    ));

    /* Endow */
    Route::resource('endow', 'backend\EndowController');
    Route::any("/Endow/searchRelative" , array(
        'as' 	=> 'endow_search_related',
        'uses' 	=> 'backend\EndowController@searchRelative',
    ));

    /* Banner */
    Route::resource('hot', 'backend\HotController');
    Route::any("/Hot/searchRelative" , array(
        'as' 	=> 'hot_search_related',
        'uses' 	=> 'backend\HotController@searchRelative',
    ));
    Route::any("/Hot/searchRelative2" , array(
        'as' 	=> 'hot_search_related_2',
        'uses' 	=> 'backend\HotController@searchRelative2',
    ));

    /* Banner */
    Route::resource('banner', 'backend\BannerController');
    Route::any("/Banner/searchRelative" , array(
        'as' 	=> 'banner_search_related',
        'uses' 	=> 'backend\BannerController@searchRelative',
    ));

    /* Color */
    Route::resource('color', 'backend\ColorController');

    /* Color */
    Route::resource('material', 'backend\MaterialController');

    /* Seeding */
    Route::resource('seeding', 'backend\SeedingController');
    Route::resource('seeding-fb-comments', 'backend\SeedingFbCommentsController');

    //Popup
    Route::resource('popup', 'backend\PopupController');

    /* Feedback */
    Route::resource('feedback', 'backend\FeedbackController');

    /* Contact */
    Route::resource('contact', 'backend\ContactController');

    /* Signup Offer */
    Route::resource('configProduct', 'backend\ProductConfigController');

    /* Signup Offer */
    Route::resource('signupOffer', 'backend\SignupOfferController');

    /* Config Logo */
    Route::resource('configLogo', 'backend\ConfigLogoController');

    /* Config Seo */
    Route::resource('configSeo', 'backend\ConfigSeoController');

    /* Config Script */
    Route::resource('configScript', 'backend\ConfigScriptController');

    /* Config Footer */
    Route::resource('configFooter', 'backend\ConfigFooterController');

    /* Config Contact */
    Route::resource('configContact', 'backend\ConfigContactController');

    /* Config Email */
    Route::resource('configEmail', 'backend\ConfigEmailController');

    /* Config Social TopBar */
    Route::resource('configSocialTopbar', 'backend\ConfigSocialTopbarController');
    Route::post("/social_topbar/hide_social/{id}" , array(
        'as' 	=> 'social_topbar_hide_social',
        'uses' 	=> 'backend\ConfigSocialTopbarController@hideSocial',
    ));

    /* Config Social */
    Route::resource('configSocial', 'backend\ConfigSocialController');
    Route::get("/social/view_click/{id}" , array(
        'as' 	=> 'social_view_click',
        'uses' 	=> 'backend\ConfigSocialController@viewSocialClick',
    ));
    Route::post("/social/hide_social/{id}" , array(
        'as' 	=> 'social_hide_social',
        'uses' 	=> 'backend\ConfigSocialController@hideSocial',
    ));

    /* Config Policy */
    Route::resource('configPolicy', 'backend\ConfigPolicyController');

    /* Product */
    Route::resource('product', 'backend\ProductController');
    Route::resource('productConfig', 'backend\ProductConfigController');

    Route::any("/Product/searchRelative" , array(
        'as' 	=> 'product_search_related',
        'uses' 	=> 'backend\ProductController@searchRelative',
    ));
    Route::any("/Product/searchRelativeNew" , array(
        'as' 	=> 'product_search_related_new',
        'uses' 	=> 'backend\ProductController@searchRelativeNew',
    ));
    Route::any("/Product/searchRelativeHot" , array(
        'as' 	=> 'product_search_related_hot',
        'uses' 	=> 'backend\ProductController@searchRelativeHot',
    ));
    Route::any("/Product/searchRelativeSale" , array(
        'as' 	=> 'product_search_related_sale',
        'uses' 	=> 'backend\ProductController@searchRelativeSale',
    ));
    Route::any("/Product/searchRelativeSelling" , array(
        'as' 	=> 'product_search_related_selling',
        'uses' 	=> 'backend\ProductController@searchRelativeSelling',
    ));
    Route::post("/product/is_cat_feature/{id}" , array(
        'as' 	=> 'product_is_cat_feature',
        'uses' 	=> 'backend\ProductController@isCatFeature',
    ));
    Route::post("/product/is_product_new/{id}" , array(
        'as' 	=> 'product_is_product_new',
        'uses' 	=> 'backend\ProductController@isProductNew',
    ));
    Route::post("/product/is_product_feature/{id}" , array(
        'as' 	=> 'product_is_product_feature',
        'uses' 	=> 'backend\ProductController@isProductFeature',
    ));
    Route::post("/product/is_product_sale/{id}" , array(
        'as' 	=> 'product_is_product_sale',
        'uses' 	=> 'backend\ProductController@isProductSale',
    ));
    Route::post("/product/is_product_selling/{id}" , array(
        'as' 	=> 'product_is_product_selling',
        'uses' 	=> 'backend\ProductController@isProductSelling',
    ));

    /* Order */
    Route::resource('order', 'backend\OrderController');
    Route::get("/order/delete/{id}" , array(
        'as' 	=> 'order_delete',
        'uses' 	=> 'backend\OrderController@delete',
    ));
    Route::post("/order/change_agency" , array(
        'as' 	=> 'order_change_agency',
        'uses' 	=> 'backend\OrderController@changeAgency',
    ));
    Route::post("/order/change_order_status" , array(
        'as' 	=> 'change_order_status',
        'uses' 	=> 'backend\OrderController@changeStatus',
    ));

});

/**
 * Frontend
 */

/* Home */
Route::get("/" , array(
    'as' 	=> 'home',
    'uses' 	=> 'frontend\HomeController@index',
));
Route::get("/trang-chu" , array(
    'as' 	=> 'home',
    'uses' 	=> 'frontend\HomeController@index',
));
Route::get("/Trang-chu" , array(
    'as' 	=> 'home',
    'uses' 	=> 'frontend\HomeController@index',
));

/* LandingPage */
Route::get("/landing-page" , array(
    'as' 	=> 'landing',
    'uses' 	=> 'frontend\LandingPageController@index',
));

/* Contact */
Route::get("/lien-lac" , array(
    'as' 	=> 'contact',
    'uses' 	=> 'frontend\ContactController@index',
));
Route::post("/contact-submit" , array(
    'as' 	=> 'contact_submit',
    'uses' 	=> 'frontend\ContactController@contactSubmit',
));

/* Signup Offer */
Route::post("/signup-offer" , array(
    'as' 	=> 'signup_offer_submit',
    'uses' 	=> 'frontend\SignupOfferController@signupOfferSubmit',
));

/* Social Click */
Route::post("/is_social_click" , array(
    'as' 	=> 'is_social_click',
    'uses' 	=> 'frontend\SocialClickController@isSocialClick',
));

/* Search */
Route::any("/tim-kiem" , array(
    'as' 	=> 'search_all',
    'uses' 	=> 'frontend\SearchController@index',
));

/* Add to Cart */
Route::any("/add-to-cart" , array(
    'as' 	=> 'add-to-cart',
    'uses' 	=> 'frontend\ShoppingController@addToCart',
));

/* Update to Cart */
Route::any("/update-to-cart" , array(
    'as' 	=> 'update-to-cart',
    'uses' 	=> 'frontend\ShoppingController@updateToCart',
));

/* Delete Cart */
Route::any("/del-all-cart" , array(
    'as' 	=> 'del-all-cart',
    'uses' 	=> 'frontend\ShoppingController@deleteCart',
));

/* Delete Product */
Route::any("/del-product" , array(
    'as' 	=> 'del-product',
    'uses' 	=> 'frontend\ShoppingController@deleteProduct',
));


/* View Pay */
Route::any("/cart" , array(
    'as' 	=> 'info-cart',
    'uses' 	=> 'frontend\ShoppingController@index',
));

Route::any("/cart_success" , array(
    'as' 	=> 'cart-success',
    'uses' 	=> 'frontend\ShoppingController@success',
));

/* Change Quantity */
Route::any("/changeQuantity" , array(
    'as' 	=> 'change-quantity',
    'uses' 	=> 'frontend\ShoppingController@changeQuantity',
));

/* Select price */
Route::any("/select-price" , array(
    'as' 	=> 'select-price',
    'uses' 	=> 'frontend\ProductController@selectPrice',
));

/* Check Out */
Route::any("/check-out" , array(
    'as' 	=> 'check-out',
    'uses' 	=> 'frontend\ShoppingController@checkOut',
));

/* Check Out */
Route::any("/order" , array(
    'as' 	=> 'order',
    'uses' 	=> 'frontend\ShoppingController@order',
));

/* Lọc tên sản phảm */
Route::any("/filter-name-product" , array(
    'as' 	=> 'filter-name-product',
    'uses' 	=> 'frontend\ProductController@filterName',
));

Route::any("/filter-price-product" , array(
    'as' 	=> 'filter-price-product',
    'uses' 	=> 'frontend\ProductController@filterPrice',
));

Route::any("/filter-type-product" , array(
    'as' 	=> 'filter-type-product',
    'uses' 	=> 'frontend\ProductController@filterType',
));


Route::post("/login-agency" , array(
    'as' 	=> 'login-agency',
    'uses' 	=> 'frontend\AgencyController@login',
));

Route::get("/list-order-agency" , array(
    'as' 	=> 'list-order-agency',
    'uses' 	=> 'frontend\AgencyController@listOrder',
));

Route::get("/detail-order-agency/{id}" , array(
    'as' 	=> 'detail-order-agency',
    'uses' 	=> 'frontend\AgencyController@detailOrder',
));

Route::get("/logout-agency" , array(
    'as' 	=> 'logout-agency',
    'uses' 	=> 'frontend\AgencyController@logout',
));

Route::get("/thong-tin-bao-hanh/{order_id}/{product_id}" , array(
    'as' 	=> 'info_guarantee',
    'uses' 	=> 'frontend\GuaranteeController@detail',
));

Route::any("/certify" , array(
    'as' 	=> 'certify',
    'uses' 	=> 'frontend\CertifyController@search',
));


Route::get("{alias}" ,function($alias){

    $dbURL = new Url;
    $url   = $dbURL->findURL($alias);
    $module = ucfirst($url['module']);

    if($module != 'Category') {

        $moduleName = ucfirst($url['module']);

        $controllerName = 'App\Http\Controllers\frontend\\'.$moduleName.'Controller@'. $url['action'];

        return App::call($controllerName,['alias' => $url['url']]);

    } else {

        $action = (int) $url['action'];

        $moduleAction = [

            1 => ['module' => 'Post','action' 	 => 'index'],
            2 => ['module' => 'Contact','action' => 'index'],
            3 => ['module' => 'Post','action' 	 => 'PostDetail'],
            4 => ['module' => 'Gallery','action' => 'index'],
            5 => ['module' => 'Product','action' => 'index'],
            6 => ['module' => 'LandingPage','action' => 'LandingPageDetail'],
            6 => ['module' => 'Guarantee','action' => 'index'],
        ];
        $activeModule   = $moduleAction[$action];
        $controllerName = 'App\Http\Controllers\frontend\\'.$activeModule['module'].'Controller@'. $activeModule['action'];

        return App::call($controllerName,['alias' => $url['url']]);
    }

});

Route::get('{alias}/trang-{page}.html' ,function($alias,$page) {
    $dbURL = new Url;
    $url   = $dbURL->findURL($alias);
    $module = ucfirst($url['module']);
    $action = (int) $url['action'];
    if($module == 'Category') {

        $moduleAction = [

            1 => ['module' => 'Post','action' 	 => 'index'],
            2 => ['module' => 'Contact','action' => 'index'],
            3 => ['module' => 'Post','action' 	 => 'PostDetail'],
            4 => ['module' => 'Gallery','action' => 'index'],
            5 => ['module' => 'Product','action' => 'index']

        ];
        $activeModule   = $moduleAction[$action];
        $controllerName = 'App\Http\Controllers\frontend\\'.$activeModule['module'].'Controller@'. $activeModule['action'];

        return App::call($controllerName,['alias' => $url['url'],'page' => $page]);
    }
});
