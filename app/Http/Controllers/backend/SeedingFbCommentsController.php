<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Auth;
use File;

use App\Services\ImageService;
use App\Models\backend\SeedingFbComment;

class SeedingFbCommentsController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.seedingFbComment.';
    private $content = 'content';

    public function __construct(ImageService $imageService)
    {
        $this->image_service = $imageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = new Collection();
        $data->title   = 'Danh Sách Seeding Bình luận Facebook';
        $data->keyword = $request->keyword ?? $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['seeding'] = SeedingFbComment::searchSeeding($data->keyword, $this->limit);
        }else {
            $data['seeding'] = SeedingFbComment::listSeeding(Null, true, $this->limit);
        }

        $data['keyword'] = $data->keyword;
        $data['create_new'] = route('seeding-fb-comments.create');

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
        $data->title   = 'Thêm Mới bình luận Facebook';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view, compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = 'Đã thêm mới thành công bình luận FB.';

        $user_id = Auth::user()->id ?? 1;

        $data = [
            'name'              =>  $request->name,
            'content'           =>  $request->content,
            'likes'             =>  $request->likes,
            'time'              =>  $request->time,
            'image'            =>  $request->images,
            'title_image'       =>  $request->title_image,
            'alt_image'         =>  $request->alt_image,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            $create_seeding =  SeedingFbComment::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('seeding-fb-comments.index')->with('message', $message);
            }
            return redirect()->route('seeding-fb-comments.edit',$create_seeding->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('seeding-fb-comments.index')->with('error', $error);
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
        $data->title   = 'Cập Nhật Seeding';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về seeding này. Vui lòng thử lại.';

        if( SeedingFbComment::checkExists( $id ) ) {
            $data['seeding']       = SeedingFbComment::find($id);

            return View($data->view, compact('data'));
        }else {
            return redirect()->route('seeding-fb-comments.index')->with('error', $error);

        }
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
        $message        = 'Đã cập nhật seeding thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if ( $id ) {
            $seeding = SeedingFbComment::find($id);
            $user_id = Auth::user()->id ?? $seeding->created_by;

            $data = [
                'name'              =>  $request->name,
                'content'           =>  $request->content,
                'time'              =>  $request->time,
                'image'             =>  $request->images,
                'title_image'       =>  $request->title_image,
                'alt_image'         =>  $request->alt_image,
                'updated_by'        =>  $user_id,
            ];

            try {
                $seeding->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('seeding-fb-comments.index')->with('message', $message);
                }
                return redirect()->route('seeding-fb-comments.edit',$seeding->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();
                return redirect()->route('seeding-fb-comments.edit',$seeding->id)->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

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
        $seeding = SeedingFbComment::find($id);

        $data = [
            'status'    =>  -2
        ];

        $seeding->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);
    }
}
