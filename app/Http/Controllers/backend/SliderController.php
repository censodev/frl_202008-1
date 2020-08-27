<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreSliderRequest;
use Auth;
use File;
use App\Services\ImageService;

class SliderController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.slider.';
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
        $data->title   = 'Danh Sách Slider';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword    = $request->keyword;
            $data['sliders'] = Slider::searchSlider($data->keyword,$this->limit);
        }else {
            $data['sliders'] = Slider::listSlider(Null, true, $this->limit);
        }
		
		$data['keyword'] = $data->keyword;
		$data['create_new'] = route('slider.create');

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
        $data->title   = 'Thêm Mới Slider';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreSliderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSliderRequest $request)
    {
        $message = 'Đã thêm mới thành công slider.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'title'             =>  $request->title,
            'images'            =>  Genratejsonarray( $request->images ),
            'title_image'       =>  Genratejsonarray( $request->title_image ),
            'alt_image'         =>  Genratejsonarray( $request->alt_image ),
            'button_title'      =>  Genratejsonarray( $request->button_title ),
            'button_link'       =>  Genratejsonarray( $request->button_link ),
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            $create_slider = Slider::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('slider.index')->with('message', $message);
            }

            return redirect()->route('slider.edit',$create_slider->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('slider.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Slider';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về slider này. Vui lòng thử lại.';

        if( Slider::checkExists( $slider->id ) ) {
            $data['slider']       = $slider;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('slider.index')->with('error', $error);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreSliderRequest  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSliderRequest $request, Slider $slider)
    {
        $message        = 'Đã cập nhật slider thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $slider ) {

            $user_id = $this->getUserData()->id ?? $slider->created_by;

            $data = [
                'title'             =>  $request->title,
                'images'            =>  Genratejsonarray( $request->images ),
                'title_image'       =>  Genratejsonarray( $request->title_image ),
                'alt_image'         =>  Genratejsonarray( $request->alt_image ),
                'button_title'      =>  Genratejsonarray( $request->button_title ),
                'button_link'       =>  Genratejsonarray( $request->button_link ),
                'updated_by'        =>  $user_id,
            ];

            try{
                $slider->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('slider.index')->with('message', $message);
                }

                return redirect()->route('slider.edit',$slider->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect()->route('slider.edit',$slider->id)->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    /*
    public function destroy(Slider $slider)
    {
        $message = 'Xóa thành công.';
        $slider->delete();

        return redirect()->route('slider.index')->with('message', $message);
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
        $slider = Slider::find($id);

        $data = [
            'status'    =>  -2
        ];

        $slider->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

    /**
     * [searchRelative slider]
     * @param  Request $rq
     * @return search html
     */
    public function searchRelative(Request $rq)
    {
        $data = new Collection();
        $data->view    = $this->view.'search';

        $sliders      = Slider::searchSlider($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "slider";
        $html           = View($data->view, compact("sliders",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

}
