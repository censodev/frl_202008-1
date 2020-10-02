<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Category;
use App\Models\backend\LandingPage;
use App\Models\backend\LandingPageItem;
use App\Models\backend\Post;
use App\Models\backend\Product;
use App\Models\backend\Gallery;
use App\Models\backend\Slider;
use App\Models\backend\Team;
use App\Models\backend\Partner;
use App\Models\backend\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreLandingPageRequest;
use Auth;
use File;
use App\Services\ImageService;

class LandingPageController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    protected $types = [
        'article'   => 'Bài Viết',
        'product'   => 'Sản Phẩm',
        'slider'    => 'Slider',
        // 'newspaper' => 'Báo Chí',
        // 'tv'        => 'Truyền Hình',
        'endow'     => 'Hậu Mãi',
        'feedback'  => 'Cảm Nhận Khách Hàng',
        'about'     => 'Giới Thiệu',
        'album'     => 'Album',
        'video'     => 'Video',
        'hot'       => 'Danh Mục Nổi Bật',
        'service'   => 'Quy Trình Dịch Vụ',
        'table'     => 'Bảng biểu',
    ];
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.landingPage.';
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new Collection();
        $data->title   = 'Danh Sách LandingPage';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['landingPages'] = LandingPage::searchLandingPage($data->keyword,$this->limit);
        }else {
            $data['landingPages'] = LandingPage::listsearchLandingPage(Null, true, $this->limit);
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
        $data = new Collection();
        $data->title   = 'Thêm Mới LandingPage';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        $data['category_level'] = Category::getCategoryPostLevel();

        $data['types'] = $this->types;

        return View($data->view,compact('data'));

    }

    public function render_items($type, $request)
    {
        if($type === 'slider'){
            $items = !empty( $request->related_slider ) ? Genratejsonarray( $request->related_slider ) : '';
        }
        if($type === 'product'){
            $items = !empty( $request->related_product ) ? Genratejsonarray( $request->related_product ) : '';
        }
        if($type === 'article'){
            $items = !empty( $request->related_post ) ? Genratejsonarray( $request->related_post ) : '';
        }
        if($type === 'newspaper'){
            $items = !empty( $request->related_newspaper ) ? Genratejsonarray( $request->related_newspaper ) : '';
        }
        if($type === 'tv'){
            $items = !empty( $request->related_tv ) ? Genratejsonarray( $request->related_tv ) : '';
        }
        if($type === 'endow'){
            $items = !empty( $request->related_endow ) ? Genratejsonarray( $request->related_endow ) : '';
        }
        if($type === 'feedback'){
            $items = '';
        }
        if($type === 'about'){
            $items = !empty( $request->related_about ) ? Genratejsonarray( $request->related_about ) : '';
        }
        if($type === 'album'){
            $items = !empty( $request->related_album ) ? Genratejsonarray( $request->related_album ) : '';
        }
        if($type === 'video'){
            $items = !empty( $request->related_video ) ? Genratejsonarray( $request->related_video ) : '';
        }
        if($type === 'hot'){
            $items = !empty( $request->related_hot ) ? Genratejsonarray( $request->related_hot ) : '';
        }
        if($type === 'service'){
            $items = json_encode([
                'services_name'         => $request->services_name,
                'services_url'          => $request->services_url,
                'services_description'  => $request->services_description,
            ]);
        }
        if($type == 'table'){
            $items = array_values(array_filter($request->table_editor, function($value) { return !is_null($value) && $value !== '';}))[0];
        }

        return $items;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreLandingPageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLandingPageRequest $request)
    {
        $message = 'Đã thêm mới thành công landingPage.';

        $user_id = $this->getUserData()->id ?? 1;

        if( !empty( $request->alias ) ) {
            $alias = $request->alias;
        }else {
            $alias = $request->title;
        }
        $alias = utf8tourl( $alias );

        $data_section = [
            'name'                      => $request->name,
            'type'                      => $request->type,
            'ordering'                  => $request->ordering,
            'images'                    => $request->images,
            'title_image'               => $request->title_image,
            'alt_image'                 => $request->alt_image,
            'images_mobile'             => $request->images_mobile,
            'title_image_mobile'        => $request->title_image_mobile,
            'alt_image_mobile'          => $request->alt_image_mobile,
            'description'               => $request->description,
            'title_action'              => $request->title_action,
            'icon_action'               => $request->icon_action,
            'id_action'                 => $request->id_action,
        ];

        $data = [
            'title'                         =>  $request->title,
            'category_id'                   =>  $request->category_id,
            'alias'                         =>  $alias,
            'image_landing'                 =>  $request->image_landing,
            'title_image_landing'           =>  $request->title_image_landing,
            'alt_image_landing'             =>  $request->alt_image_landing,
            'seo_title'                     =>  $request->seo_title,
            'seo_desciption'                =>  $request->seo_desciption,
            'seo_keyword'                   =>  $request->seo_keyword,
            'created_by'                    =>  $user_id,
            'status'                        =>  1,
        ];

        try{
            $create_landing = LandingPage::create( $data );

            foreach($data_section['name'] as $key => $item){
                $data_item = [
                    'id_landing'            => $create_landing->id,
                    'name'                  => $item,
                    'type'                  => $data_section['type'][$key],
                    'ordering'              => (int) $data_section['ordering'][$key],
                    'images'                => $data_section['images'][$key],
                    'title_image'           => $data_section['title_image'][$key],
                    'alt_image'             => $data_section['alt_image'][$key],
                    'images_mobile'         => $data_section['images_mobile'][$key],
                    'title_image_mobile'    => $data_section['title_image_mobile'][$key],
                    'alt_image_mobile'      => $data_section['alt_image_mobile'][$key],
                    'description'           => $data_section['description'][$key],
                    'title_action'          => $data_section['title_action'][$key],
                    'icon_action'           => $data_section['icon_action'][$key],
                    'id_action'             => $data_section['id_action'][$key],
                    'created_by'            => $user_id,
                    'status'                => 1,
                ];
                $data_item['items'] = $this->render_items($data_section['type'][$key], $request);
                LandingPageItem::create( $data_item );
            }

            if( $create_landing ) {
                $data_url = [
                    'url'       =>  $alias,
                    'module'    =>  'LandingPage',
                    'action'    =>  'LandingPageDetail',
                    'object_id' =>  $create_landing->id,
                ];
                Url::create( $data_url );
            }

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('landingPage.index')->with('message', $message);
            }

            return redirect()->route('landingPage.edit',$create_landing->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('landingPage.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\HomepageManager  $homepageManager
     * @return \Illuminate\Http\Response
     */
    public function show(LandingPage $landingPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\LandingPage  $landingPage
     * @return \Illuminate\Http\Response
     */
    public function edit(LandingPage $landingPage)
    {
        $data = new Collection();
        $data->title   = 'Cập LandingPage';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;
        $data['types'] = $this->types;

        $error = 'Không tìm thấy dữ liệu về landingPage này. Vui lòng thử lại.';

        if( LandingPage::checkExists( $landingPage->id ) ) {

            $data['landingPage']           = $landingPage;
            $data['category_level'] = Category::getCategoryPostLevel();

            $sections = $landingPage->items()->orderBy("ordering", 'ASC')->get();
            $data['sections'] = $sections;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('landingPage.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreLandingPageRequest  $request
     * @param  \App\Models\backend\LandingPage  $landingPage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LandingPage $landingPage)
    {
        $message        = 'Đã cập nhật landingPage thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $landingPage ) {
            $alias_old   = $landingPage->alias;

            if( !empty( $request->alias ) ) {
                $alias = $request->alias;
            }else {
                $alias = $request->title;
            }
            $alias = utf8tourl( $alias );
            $user_id = $this->getUserData()->id ?? $landingPage->created_by;

            $data_section = [
                'item_id'                   => $request->item_id,
                'name'                      => $request->name,
                'type'                      => $request->type,
                'ordering'                  => $request->ordering,
                'images'                    => $request->images,
                'title_image'               => $request->title_image,
                'alt_image'                 => $request->alt_image,
                'images_mobile'             => $request->images_mobile,
                'title_image_mobile'        => $request->title_image_mobile,
                'alt_image_mobile'          => $request->alt_image_mobile,
                'description'               => $request->description,
                'title_action'              => $request->title_action,
                'icon_action'               => $request->icon_action,
                'id_action'                 => $request->id_action,
            ];

            $data = [
                'title'                         =>  $request->title,
                'category_id'                   =>  $request->category_id,
                'alias'                         =>  $alias,
                'image_landing'                 =>  $request->image_landing,
                'title_image_landing'           =>  $request->title_image_landing,
                'alt_image_landing'             =>  $request->alt_image_landing,
                'seo_title'                     =>  $request->seo_title,
                'seo_desciption'                =>  $request->seo_desciption,
                'seo_keyword'                   =>  $request->seo_keyword,
                'created_by'                    =>  $user_id,
                'status'                        =>  1,
            ];


            try{
                $update_landingPage = $landingPage->update( $data );

                //xoá item
                $list_landing = LandingPageItem::select('id')->where('id_landing',$landingPage->id)->get();
                $array_id = [];

                if(!empty($list_landing) && count($list_landing) > 0){
                    foreach ($list_landing as $key => $item){
                        $array_id[] = $item->id;
                    }
                }

                if(!empty($array_id) && count($array_id) > 0){
                    foreach ($array_id as $key => $item){
                        if(!in_array( (string) $item, $data_section['item_id']) ){
                            LandingPageItem::where('id',$item)->delete();
                        }
                    }
                }

                //update product item
                foreach($data_section['item_id'] as $key => $item){

                    $data_item = [
                        'id_landing'            => $landingPage->id,
                        'name'                  => $data_section['name'][$key],
                        'type'                  => $data_section['type'][$key],
                        'ordering'              => (int) $data_section['ordering'][$key],
                        'images'                => $data_section['images'][$key],
                        'title_image'           => $data_section['title_image'][$key],
                        'alt_image'             => $data_section['alt_image'][$key],
                        'images_mobile'         => $data_section['images_mobile'][$key],
                        'title_image_mobile'    => $data_section['title_image_mobile'][$key],
                        'alt_image_mobile'      => $data_section['alt_image_mobile'][$key],
                        'description'           => $data_section['description'][$key],
                        'title_action'          => $data_section['title_action'][$key],
                        'icon_action'           => $data_section['icon_action'][$key],
                        'id_action'             => $data_section['id_action'][$key],
                        'created_by'            => $user_id,
                        'status'                => 1,
                    ];
                    $data_item['items'] = $this->render_items($data_section['type'][$key], $request);

                    //nếu tồn tại id thì update
                    if($item != null){
                        LandingPageItem::where('id',$item)->update($data_item);
                    }else{
                        //chưa có id thì tạo mới
                        LandingPageItem::create($data_item);
                    }
                }


                if( $update_landingPage ) {
                    $url =  Url::findURLByModule( 'LandingPage', $request->id );

                    if( $url ) {
                        if( $alias != $alias_old ) {
                            $data_url = [
                                'url' => $alias
                            ];
                            $url->update($data_url);
                        }

                    }else {
                        $data_url = [
                            'url'       =>  $alias,
                            'module'    =>  'LandingPage',
                            'action'    =>  'LandingPageDetail',
                            'object_id' =>  $landingPage->id,
                        ];
                        Url::create( $data_url );
                    }

                }

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('landingPage.index')->with('message', $message);
                }
                return redirect()->route('landingPage.edit',$landingPage->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();
                return redirect()->route('landingPage.index')->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\backend\LandingPage $landingPage
     * @return \Illuminate\Http\Response
     */
    /*
        public function destroy(HomepageManager $homepageManager)
        {
            $message = 'Xóa thành công.';
            $homepageManager->delete();

            return redirect()->route('homepageManager.index')->with('message', $message);

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
        $landingPage = LandingPage::find($id);

        $data = [
            'status'    =>  -2
        ];

        $landingPage->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

}
