<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Collection;

class VideoController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $cat 	 = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.video.';
    private $content = 'content';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new Collection();
        $data->title   = 'Danh Sách Video';
        $data->keyword = $this->keyword;
        $data->cat 	   = $this->cat;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        $data->videos  = \App\Models\backend\Video::list($this->limit);

        return view($data->view, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = new Collection();
        $data->title   = 'Thêm Mới Video';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return view($data->view, compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = 'Đã thêm mới thành công 1 video';

        try {
            $image = \App\Models\backend\Video::create([
                'title'         => $request->title,
                'image'         => $request->image,
                'alt_image'     => $request->alt_image,
                'video_url'     => $request->video_url,
                'status'        => 1,
            ]);

            if ($request->save_and_exits == 1) {
                return redirect()->route('video.index')->with('message', $message);
            }
    
            return redirect()->route('video.edit', $image->id)->with('message', $message);
        } catch (\Throwable $th) {
            $error = $th->getMessage();
            
            return redirect()->route('video.index')->with('error', $error);
        }
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
        $data = new Collection();
        $data->title   = 'Cập Nhật Video';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $data->video = \App\Models\backend\Video::find($id);

        return view($data->view, compact('data'));
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
        $message        = 'Cập nhật thành công.';
        $error          = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';
    
        try {
            $video = \App\Models\backend\Video::where('id', $id)->update([
                'title'         => $request->title,
                'image'         => $request->image,
                'video_url'     => $request->video_url,
                'alt_image'     => $request->alt_image,
            ]);

            if ($request->save_and_exits == 1) {
                return redirect()->route('video.index')->with('message', $message);
            }
    
            return back()->with('message', $message);
        } catch (\Throwable $th) {
            $error = $th->getMessage();
            
            return back()->with('error', $error);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = \App\Models\backend\Video::find($id);
        $video->status = -2;
        $video->save();
        return response()->json(['result' => 'Đã xóa thành công.'], 200);
    }

    public function searchRelative(Request $rq)
    {
        $data = new Collection();
        $data->view     = $this->view.'search';

        $videos         = \App\Models\backend\Video::search($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "video";
        $html           = View($data->view, compact("videos",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }
}
