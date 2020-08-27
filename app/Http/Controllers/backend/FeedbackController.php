<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreFeedbackRequest;
use Auth;
use File;
use App\Services\ImageService;

class FeedbackController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.feedback.';
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
        $data->title   = 'Danh Sách Ý Kiến Khách Hàng';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['feedbacks'] = Feedback::searchFeedback($data->keyword,$this->limit);
        }else {
            $data['feedbacks'] = Feedback::listFeedback(Null, true, $this->limit);
        }
		
		$data['keyword'] = $data->keyword;
		$data['create_new'] = route('feedback.create');

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
        $data->title   = 'Thêm Mới Ý Kiến Khách Hàng';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreFeedbackRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFeedbackRequest $request)
    {
        $message = 'Đã thêm mới thành công ý kiến khách hàng.';
        if( !empty( $request->alias ) ) {
            $alias = $request->alias;
        }else {
            $alias = $request->title;
        }

        $alias = utf8tourl( $alias );

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'name_customer'     =>  $request->name_customer,
			'position'     		=>  $request->position,
            'images'            =>  $request->images,
            'title_image'       =>  $request->title_image,
            'alt_image'         =>  $request->alt_image,
            'description'       =>  $request->description,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            Feedback::create( $data );

            return redirect()->route('feedback.index')->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('feedback.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Ý Kiến Khách Hàng';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về bài viết này. Vui lòng thử lại.';

        if( $feedback ) {
            $data['feedback']       = $feedback;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('feedback.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreFeedbackRequest  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFeedbackRequest $request, Feedback $feedback)
    {
        $message        = 'Đã cập nhật ý kiến khách hàng thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $feedback ) {
            $images_old  = $feedback->images;

            if( !empty( $request->images ) ) {
                $images = $request->images;
            }else {
                $images = $images_old;
            }

            $user_id = $this->getUserData()->id ?? $feedback->created_by;

            $data = [
                'name_customer'     =>  $request->name_customer,
				'position'     		=>  $request->position,
                'images'            =>  $images,
                'title_image'       =>  $request->title_image,
                'alt_image'         =>  $request->alt_image,
                'description'       =>  $request->description,
                'updated_by'        =>  $user_id,
            ];

            try{
                $feedback->update( $data );

                return redirect('admin/feedback/'. $feedback->id .'/edit')->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect('admin/feedback/'. $feedback->id .'/edit')->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    /*
        public function destroy(Feedback $feedback)
        {
            $message = 'Xóa thành công.';
            $feedback->delete();

            return redirect()->route('feedback.index')->with('message', $message);

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
        $feedback = Feedback::find($id);

        $data = [
            'status'    =>  -2
        ];

        $feedback->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

}
