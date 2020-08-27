<?php

namespace App\Providers;

use Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Services\ImageService;
use Illuminate\Support\Facades\View;
use App\Models\backend\Category;
use App\Models\backend\ConfigFooter;
use App\Models\backend\ConfigLogo;
use App\Models\backend\ConfigSocial;
use App\Models\backend\ConfigSocialTopbar;
use App\Models\backend\ConfigScript;
use App\Models\backend\ConfigContact;
use App\Models\backend\ConfigPolicy;
use App\Models\backend\Popup;
use App\Models\backend\Seeding;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\ImageService', function($app) {
            return new ImageService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer(["frontend.includes.head"], function($view){

            $logo = ConfigLogo::where("status",1)->get();
            $favicon = $logo->where("type",3)->first();

            $view->with( array("favicon"=>$favicon) );
        });

		View::composer(["frontend.includes.head","frontend.layouts.index","frontend.layouts.page","frontend.includes.footer"], function($view){

            $scripts = ConfigScript::where([
                    ["status",1]
                ])->first();

            $view->with( array("scripts"=>$scripts) );
        });

        View::composer(["frontend.includes.header", "frontend.includes.header_landing", "frontend.pages.home.partial.slider"], function($view){

            $socials_topbar = ConfigSocialTopbar::where([
                    ["status",1]
                ])->get();

			$footers = ConfigFooter::where([
                    ["status",1]
                ])->first();

            $footer_contact_info    = !empty( $footers->footer_contact_info ) ? json_decode( $footers->footer_contact_info ) : [];

            $categories = Category::where([
                ["status",1],
                ["is_show_menu_main",1]
            ])->get();
            create_array_category_menu($categories);

            $categories = $categories->where('parent_id', -1)->sortBy('ordering');

            $logo = ConfigLogo::where("status",1)->get();
            $logo->top = $logo->where("type",1)->first();

            $total=0;
            if(Session::has('cart')){
                $cart =session('cart');

                $total = count($cart);
            }

            $view->with( array("socials_topbar"=>$socials_topbar,"footer_contact_info"=>$footer_contact_info,"categories"=>$categories,"logo"=>$logo) );
        });

        View::composer(["frontend.includes.menu"], function($view){

            $total=0;
            if(Session::has('cart')){
                $cart =session('cart');

                $total = count($cart);
            }

            $view->with( array("total"=>$total) );
        });

        View::composer(["frontend.pages.home.partial.sidebar-menu"], function($view){
            $category_products = Category::where([
                ["status",1],
                ["is_show_menu_main",1]
            ])->get();
            create_array_category_menu($category_products);

            $category_products = $category_products->where('parent_id', -1)->where('type', 5)->sortBy('ordering');

            $view->with( array("category_products"=>$category_products) );
        });

        View::composer(["frontend.includes.footer", "frontend.pages.contact.index"], function($view){
            $seeding = Seeding::where([
                ["status",1]
            ])->get();

            $array_seeding = [];
            foreach ($seeding as $key => $item_seeding){
                $item_array = '<div class="notifi display" id="noti">
                                    <div class="item">
                                        <div class="img-noti"><img src="'. $item_seeding->images .'" alt="'. $item_seeding->images .'"  title="'. $item_seeding->title_image .'" alt="'. $item_seeding->alt_image .'" width="50px"></div>
                                        <div class="content">
                                            <p class="name">'.$item_seeding->name .'</p>
                                            <span style="font-style: italic;">'.$item_seeding->content .'</span>
                                            <p class="time">'.$item_seeding->time .'</p>
                                        </div>
                                    </div>
                                </div>';
                $array_seeding[] = $item_array;
            }


            $footers = ConfigFooter::where([
                    ["status",1]
                ])->first();

            $logo = ConfigLogo::where("status",1)->get();
            $logo->footer = $logo->where("type",2)->first();

            $socials_topbar = ConfigSocialTopbar::where([
                    ["status",1]
                ])->get();

            $view->with( array("footers"=>$footers, "logo"=>$logo, "socials_topbar"=>$socials_topbar, 'array_seeding' => $array_seeding, 'seeding' => $seeding) );
        });

        View::composer(["frontend.pages.product.detail"], function($view){
            $footers = ConfigFooter::where([
                ["status",1]
            ])->first();
            $view->with( array("footers"=>$footers) );
        });

        View::composer(["frontend.includes.popup"], function($view){
            $popup = Popup::where([
                ["status",1],
                ["id",1]
            ])->first();

            $view->with( array("popup"=>$popup) );
        });

        View::composer(["frontend.includes.social"], function($view){

            $socials = ConfigSocial::where([
                    ["status",1]
                ])->get();

            $view->with( array("socials"=>$socials) );
        });

        View::composer(["frontend.pages.cart.index"], function($view){

            $cart = array();
            if(Session::has('cart')){
                 $cart = session("cart");
            }

            $view->with( array("cart"=>$cart) );
        });

        View::composer(["frontend.pages.home.index","frontend.pages.product.index","frontend.pages.product.detail","frontend.includes.contact-text","frontend.pages.search.index"], function($view){

            $contact = ConfigContact::where([
                ["status",1]
            ])->first();

			$policies = ConfigPolicy::where([
                    ["status",1]
                ])->first();

            $view->with( array("contact"=>$contact, "policies"=>$policies) );
        });
    }
}
