<?php
use App\Models\backend\Category;
use App\Models\backend\Post;
use App\Models\backend\Gallery;
use App\Models\backend\ProductItem;
use App\Models\backend\Url;

    function utf8convert($str) {
        if(!$str) return false;
        $utf8 = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd'=>'đ|Đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach($utf8 as $ascii=>$uni) $str = preg_replace("/($uni)/i",$ascii,$str);
            return $str;
    }

    function utf8tourl($text) {
        $text = strtolower(utf8convert($text));
        $text = str_replace( "ß", "ss", $text);
        $text = str_replace( "%", "", $text);
        $text = preg_replace("/[^_a-zA-Z0-9 -] /", "",$text);
        $text = str_replace(array('%20', ' '), '-', $text);
        $text = str_replace("----","-",$text);
        $text = str_replace("---","-",$text);
        $text = str_replace("--","-",$text);
        return $text;
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;

    }

    function Genratejsonarray($array) {
        if(count($array) == 0 ) {
            return json_encode(array());
        }elseif( isset( $array[0] ) && ( $array[0] == null || $array[0] == "" ) ) {
            return json_encode( array() );
        }else {
            return json_encode( $array );
        }

    }

    function showListCategory($category, $level, $category_choose = null) {
        if( !empty( $category ) ) {
            foreach( $category as $cat ) {
                if( in_array($cat['id'], $category_choose ) ){
                    echo '<option value="'. $cat["id"] .'" selected>'. str_repeat ("-", $level) . ' ' .$cat['title'] .'</option>';
                }else {
                    echo '<option value="'. $cat["id"] .'">'. str_repeat ("-", $level) . ' ' .$cat['title'] .'</option>';
                }
            }
        }
    }

    function showListCategoryPost($category, $level, $select_id = null) {
        if( !empty( $category ) ) {
            foreach( $category as $cat ) {
                if( $cat['id'] == $select_id ){
                    echo '<option value="'. $cat["id"] .'" selected>'. str_repeat ("-", $level) . ' ' .$cat['title'] .'</option>';
                }else {
                    echo '<option value="'. $cat["id"] .'">'. str_repeat ("-", $level) . ' ' .$cat['title'] .'</option>';
                }

                if( !empty( $cat['category_with_child'] ) && count( $cat['category_with_child'] ) > 0 ) {
                    showListCategoryPost($cat['category_with_child'], ++$level, $select_id );
                }
            }
        }
    }

    function process_json_field(&$sets) {
        foreach ($sets as &$set) {
            $set['images']      = json_decode($set['images']);
            $set['title_image'] = json_decode($set['title_image']);
            $set['alt_image']   = json_decode($set['alt_image']);
            $set['videos']      = json_decode($set['videos']);
        }
    }

    function process_json_field_single(&$set) {

        if( !empty($set['images']) ) {
            $set['images']= json_decode($set['images']);
        }
        if( !empty($set['title_image']) ) {
            $set['title_image']= json_decode($set['title_image']);
        }
        if( !empty($set['alt_image']) ) {
            $set['alt_image']= json_decode($set['alt_image']);
        }
        if( !empty($set['image_video']) ) {
            $set['image_video']= json_decode($set['image_video']);
        }
        if( !empty($set['videos']) ) {
            $set['videos']= json_decode($set['videos']);
        }

    }

    function getAllCatIdChild ($id, &$catID) {
        $category_children = Category::where([
            ["parent_id", $id],
            ["status", 1]
        ])->get();

        foreach($category_children as $value) {
            $catID[] = $value->id;
            getAllCatIdChild($value->id, $catID);
        }

        return $catID;

    }

    function getAllCatIdHotChild ($id, &$catIDHotChild) {
        $category_children = Category::where([
                ["parent_id", $id],
                ["status", 1],
                ['is_feature', 1]
            ])->get();

        foreach($category_children as $value) {
            $catIDHotChild[] = $value->id;
            getAllCatIdHotChild($value->id, $catIDHotChild);
        }

        return $catIDHotChild;
    }

    function getAllCatIdChildLevel1 ($id, &$catLevel1ID, $is_feature = false) {
        $where = [
            ["parent_id", $id],
            ["status", 1]
        ];

        if( $is_feature ) {
            $where[] = ["is_feature", 1];
        }

        $category_children = Category::where( $where )->get();

        foreach($category_children as $value) {
            $catLevel1ID[] = $value->id;
        }

        return $catLevel1ID;

    }

    function getNameCategoryById( $catId ) {
        if( !empty( $catId ) ) {
            $findCat = Category::select('title')->where('id',$catId)->first();
            if( $findCat['title'] ) {
                return $findCat['title'];
            }
        }
    }

    function getAliasCategoryById( $catId ) {
        if( !empty( $catId ) ) {
            $findCat = Category::select('alias')->where('id',$catId)->first();
            if( $findCat['alias'] ) {
                return $findCat['alias'];
            }
        }
    }

    function AllGalleryChild( $catId, $curentCatID = null ) {
        if( !empty( $catId ) ) {
            $all_child_cat_id = [];
            if( $curentCatID ) {
                $all_child_cat_id[] = $curentCatID;
            }else {
                $all_child_cat_id = getAllCatIdChild($catId, $all_child_cat_id);
                $all_child_cat_id[] = $catId;
            }
            $galleries = Gallery::where('status', 1)->whereIn('category_id', $all_child_cat_id)->orderBy('id', 'desc')->get();

            return $galleries;
        }
    }

    function render_posts($data) {

        $html = '';

        if(!empty($data) && count($data) > 0){
            foreach($data as $key => $item){

                if( !empty( $item->created_at ) ) {
                    $created_at = date_create($item->created_at);
                    $post_date  = date_format($created_at,"d/m/Y");
                }else {
                    $post_date = '';
                }

                $html .= '<li class="col-md-4">
                                <div class="ereaders-blog-grid-wrap">
                                    <figure><a href="'.url( $item->alias ) .'"><img src="'. $item->images .'" alt="'.$item->alt_image .'" title="'.$item->title_image .'" ></a></figure>
                                    <div class="ereaders-blog-grid-text">
                                        <h3><a href="'.url( $item->alias ) .'">'.$item->title .'</a></h3>
                                        '. $item->sapo .'   
                                        <ul class="ereaders-blog-option">
                                            <li><i class="fa fa-clock-o" aria-hidden="true"></i> '. $post_date .'</li>
                                            <li><i class="fa fa-eye" aria-hidden="true"></i> '. $item->view .'</li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i> '.  $item->rating .'</li>
                                        </ul>
                                        <a href="'. url( $item->alias ) .' class="ereaders-readmore-btn">Chi Tiết <i class="fa fa-angle-double-right"></i></a>
                                    </div>
                                </div>
                            </li>';
            }
        }

        return $html;

    }

    function render_list($data, $type) {

    $html = '';

    switch ($type) {
        default:
            $i = 1;
            foreach($data as $post) {

                $title  = $post['title'] ?? '';
                $images = $post['images'] ?? asset('assets/admin/dist/img/no_image.png');
                $title_image = $post['title_image'] ?? $title;
                $alt_image   = $post['alt_image'] ?? $title;
                $alias  = $post['alias'] ?? '';
                $seo_desciption  = $post['seo_desciption'] ?? '';

                if( !empty( $post['created_at'] ) ) {
                    $created_at = date_create($post['created_at']);
                    $post_date  = date_format($created_at,"d/m/Y");
                }else {
                    $post_date = '';
                }

                $html .= '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 col-mb-12">
                                <div class="news-box-layout2 bg-body item-mb">
                                    <div class="item-img">
                                        <img src="'. $images .'" title="'. $title .'" alt="'. $title .'" class="img-responsive width-100">
                                    </div>
                                    <div class="item-content">
                                        <h3 class="title-medium-dark"><a href="'. $alias .'">'. $title .'</a></h3>
                                        <div class="news-date"><i class="fa fa-calendar-o" aria-hidden="true"></i> '. $post_date .' </div>
                                        <div class="post-description mb-20">
                                            '. $seo_desciption .'
                                        </div>
                                        <a class="btn-ghost" href="'. $alias .'">Xem Thêm</a>
                                    </div>
                                </div>
                            </div>';

                if( ( $i ) != 2 && ( $i ) % 3 == 0 ) {
                    $html .= '<div class="clearfix visible-md-block visible-lg-block"></div>';
                }elseif ( ( $i ) % 2 == 0 ) {
                    $html .= '<div class="clearfix visible-sm-block visible-xs-block"></div>';
                }
                $i++;
            }
            break;
    }

    return $html;

}

    function render_galleries($data, $type) {

        $html = '';

        switch ($type) {
            default:
                foreach($data as $gallery) {

                    $gallery_images = json_decode( $gallery->images );
                    $images = $gallery_images[0] ?? asset('assets/admin/dist/img/no_image.png');
                    $alias  = url( $gallery->alias );
                    $title  = $gallery->title;
                    $seo_desciption  = $gallery->seo_desciption;

                    if( !empty( $gallery->created_at ) ) {
                        $created_at = date_create($gallery->created_at);
                        $gallery_date  = date_format($created_at,"d/m/Y");
                    }else {
                        $gallery_date = '';
                    }

                    $html .= '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-mb-12">
                                <div class="team-box-layout1 mb-30">
                                    <div class="item-img-wrapper">
                                        <a href="'. $alias .'">
                                            <img src="'. $images .'" title="'. $title .'" alt="'. $title .'" class="img-responsive">
                                        </a>
                                    </div>
                                    <div class="item-content-wrapper">
                                        <div class="item-content bg-box">
                                            <h3 class="title-medium-dark size-sm mb-5"><a href="'. $alias .'">'. $title .'</a></h3>
                                            <span>'. $seo_desciption .'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';

                }
                break;
        }

        return $html;

    }

    function render_products($data) {

        $html = '';
        if(!empty($data) && count($data) > 0){
            foreach($data as $key => $item){
                $list_product = ProductItem::where('product_id',$item->id)->get();
                $item_frist = $list_product[0];
                $alias  = url( $item->alias );

                    $images         = json_decode( $item->images );
                    $title_image    = json_decode( $item->title_image );
                    $alt_image      = json_decode( $item->alt_image );

                $html .= '<li class="col-md-3">
                                <figure>
                                    <span>sale</span>
                                    <a href="'.$alias .'" title="'.$item['title'].'"><img src="'.$images[0].'" alt="'.$title_image[0].' title="'.$alt_image[0].'"></a>
                                </figure>
                                <div class="ereaders-shop-grid-text">
                                    <h3><a href="'.$alias.'" title="'.$item['title'].'">'.$item['title'].'</a></h3>
                                    <span>'.number_format($item_frist->price_promotion, 0, ".", ".") . ' đ' .'<del>'.number_format($item_frist->price_buy, 0, ".", ".") . ' đ' .'</del></span>
                                    <div class="star-rating">
                                        '.rating_star($item['rating']).'
                                    </div>
                                </div>
                                <div class="product-action product-add-to-card">
                                    <input class="cart-plus-minus-box" type="number" name="quantity" value="1" min="1" data-id="'.$item_frist->id.'">
                                    <button type="submit">Thêm vào giỏ hàng</button>
                                </div>
                            </li>';
            }
        }

        return $html;
    }

    function create_array_category_menu(&$categories) {
         foreach ($categories as &$category) {
             if($category->type == 4 ){

                $heo  =  Post::where([
                        ["category_id" , $category->id],
                        ["status" ,1 ]
                    ])->get();
                 if($heo->count() > 0 ){
                    $category->post = Post::where([
                            ["category_id" , $category->id],
                            ["status" ,1 ] ]
                        )->get()->first();
                 }

            }

            $tmp = Category::where([
                    ["status", 1],
                    ["parent_id", $category->id],
                    ["is_show_menu_main", 1]
                ])->get();

            foreach ($tmp as $coc){

                if($coc->type == 3 ){
                    $heo  =  Post::where([["category_id" , $coc->id],["status" ,1 ] ])->get();
                    if($heo->count() >0){
                        $coc->post = Post::where([
                                ["category_id" , $coc->id],
                                ["status" ,1 ]
                            ])->get()->first();
                    }
                }

            }
            if(count($tmp) > 0 ){
                create_array_category_menu($tmp);
                $category->childrens = $tmp;

            }

        }
    }


    function gen_html_dropdown_submenu($childrens , $cs = 1) {

        if($cs == 1){
            $html= '<ul class="sub-menu level-2">';
        }else{
            $html= '<ul class="sub-menu">';
        }
        foreach ($childrens->sortBy('ordering') as $children) {

            $burl = asset( change_cat_url_by_article_url( $children ) );
            if(!empty($children['childrens'])) {
                $html .= '<li><a href="'.$burl.'" title="'.$children['title'].'">'.$children['title'].'</a> <span class="has-subnav"><i class="fa fa-angle-down"></i></span>';
            }else {
                $html .= '<li><a href="'.$burl.'" title="'.$children['title'].'">'.$children['title'].'</a>';
            }

            if(!empty($children['childrens'])) {
                $html.= gen_html_dropdown_submenu($children['childrens'],0);
            }

            $html.='</li>';
        }
        $html.= '</ul>';

        return $html;
    }

    function gen_html_dropdown_submenu_slider($childrens , $cs = 0) {

        $html= '<ul class="mega-menu"><li><ul>';
        foreach ($childrens->sortBy('ordering') as $children) {
            $burl = asset( change_cat_url_by_article_url( $children ) );
            $html .= '<li>
                             <ul>
                                <li><a href="'.$burl.'" class="" title="'.$children['title'].'">'.$children['title'].'</a></li>';

            if(!empty($children['childrens'])) {
                foreach ($children['childrens']->sortBy('ordering') as $item) {
                    $burl_item = asset( change_cat_url_by_article_url( $item ) );
                    $html .= '<li><a href="'.$burl_item.'">'.$item['title'].'</a></li>';
                }
            }

            $html .='</ul>
                      </li>
                ';
        }
        $html.= '</ul></li></ul>';

        return $html;
    }

    function gen_html_dropdown_submenu_sidebar($id_product) {
        $html= '<ul id="faq">';

        $category_one = Category::where([
            ["parent_id", $id_product],
            ["status", 1]
        ])->get();

        foreach ($category_one as $key => $children) {
            $burl = asset( change_cat_url_by_article_url( $children ) );
            $category_two = Category::where([
                ["parent_id", $children->id],
                ["status", 1]
            ])->get();

            if(!empty($category_two) && count($category_two) > 0){
                $html .= '<li> <a data-toggle="collapse" data-parent="#faq" href="'.$burl.'">'.$children['title'].'<i class="ion-ios-arrow-down"></i></a>';
                $html .= '<ul class="panel-collapse collapse show">';
                foreach ($category_two as $key => $item) {
                    $burl = asset( change_cat_url_by_article_url( $item ) );
                    $html .= '<li><a href="'.$burl.'">'.$item['title'].'</a></li>';
                }
                $html .= '</ul>';

            }else{
                $html .= '<li> <a href="'.$burl.'">'.$children['title'].'</a>';
            }
            $html.='</li>';
        }
        $html.= '</ul>';

        return $html;
    }

    function change_cat_url_by_article_url( $category ) {
        if( $category['type'] == 3 ) {
            $tmp = Post::where([
                    ["status", 1],
                    ["category_id", $category['id']]
                ])->first();
            if( !empty( $tmp->alias ) ) {
                return $tmp->alias;
            }
        }

        return $category['alias'];
    }

    function convert_vi_to_en($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(đ)/", "d", $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(Đ)/", "D", $str);
        $str = str_replace(" ","-",$str);
        $str = strtolower($str);
        return $str;
    }

    function rating_star($rating)
    {
        $start_html = "";
        for ($i = 0; $i < 5; ++$i) {
            if ($i < (int)$rating) {
                $start_html .= '<i class="fa fa-star star-active" aria-hidden="true"></i>';
            } else {
                $start_html .= '<i class="fa fa-star" aria-hidden="true"></i>';
            }
        }
        return $start_html;
    }

    function render_landing($data){
        $html = '';
        if(!empty($data) && count($data) > 0){
            foreach($data as $key => $item){
                $alias  = url( $item->alias );

                $images         = $item->image_landing;
                $title_image    = $item->title_image_landing;
                $alt_image      = $item->alt_image_landing;

                $html .= '<li class="col-md-3">
                                <figure>
                                    <a href="'.$alias .'" title="'.$item['title'].'"><img src="'.$images.'" alt="'.$title_image.' title="'.$alt_image.'"></a>
                                </figure>
                                <div class="ereaders-shop-grid-text">
                                    <h3><a href="'.$alias.'" title="'.$item['title'].'">'.$item['title'].'</a></h3>
                                    <p>'.$item['seo_desciption'].'</p>
                                </div>
                            </li>';
            }
        }

        return $html;
    }
?>
