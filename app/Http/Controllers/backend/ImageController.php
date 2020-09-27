<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Collection;

class ImageController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $cat 	 = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.image.';
    private $content = 'content';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new Collection();
        $data->title   = 'Danh Sách Album';
        $data->keyword = $this->keyword;
        $data->cat 	   = $this->cat;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        $data->images  = \App\Models\backend\Image::list($this->limit);

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
        $data->title   = 'Thêm Mới Album';
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
        $message = 'Đã thêm mới thành công 1 album';

        try {
            $image = \App\Models\backend\Image::create([
                'title'         => $request->title,
                'image'         => $request->image,
                'alt_image'     => $request->alt_image,
                'status'        => 1,
            ]);

            if ($request->save_and_exits == 1) {
                return redirect()->route('album.index')->with('message', $message);
            }
    
            return redirect()->route('album.edit', $image->id)->with('message', $message);
        } catch (\Throwable $th) {
            $error = $th->getMessage();
            
            return redirect()->route('album.index')->with('error', $error);
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
        $data->title   = 'Cập Nhật Album';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $data->image = \App\Models\backend\Image::find($id);

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
            $about = \App\Models\backend\Image::where('id', $id)->update([
                'title'         => $request->title,
                'image'         => $request->image,
                'alt_image'     => $request->alt_image,
            ]);

            if ($request->save_and_exits == 1) {
                return redirect()->route('album.index')->with('message', $message);
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
        $image = \App\Models\backend\Image::find($id);
        $image->status = -2;
        $image->save();
        return response()->json(['result' => 'Đã xóa thành công.'], 200);
    }

    public function searchRelative(Request $rq)
    {
        $data = new Collection();
        $data->view    = $this->view.'search';

        $images       = \App\Models\backend\Image::search($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "album";
        $html           = View($data->view, compact("images",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }
}
