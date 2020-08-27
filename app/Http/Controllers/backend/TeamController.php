<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreTeamRequest;
use Auth;
use File;
use App\Services\ImageService;

class TeamController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.team.';
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
        $data->title   = 'Danh Sách Đội Ngũ';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['teams'] = Team::searchTeam($data->keyword, $this->limit);
        }else {
            $data['teams'] = Team::listTeam(Null, true, $this->limit);
        }
		
		$data['keyword'] = $data->keyword;
		$data['create_new'] = route('team.create');

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
        $data->title   = 'Thêm Mới Thành Viên';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreTeamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamRequest $request)
    {
        $message = 'Đã thêm mới thành công thành viên.';

        $user_id = $this->getUserData()->id ?? 1;

        $data = [
            'name'              =>  $request->name,
            'position'          =>  $request->position,
            'images'            =>  $request->images,
            'title_image'       =>  $request->title_image,
            'alt_image'         =>  $request->alt_image,
            'social'            =>  Genratejsonarray( $request->social ),
			'description'		=>  $request->description,
            'created_by'        =>  $user_id,
            'status'            =>  1,
        ];

        try{
            $create_team = Team::create( $data );

            if( $request->save_and_exits == 1 ) {
                return redirect()->route('team.index')->with('message', $message);
            }

            return redirect()->route('team.edit',$create_team->id)->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('team.index')->with('error', $error);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Thành Viên';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về thành viên này. Vui lòng thử lại.';

        if( Team::checkExists( $team->id ) ) {
            $data['team']       = $team;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('team.index')->with('error', $error);

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\backend\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $message        = 'Đã cập nhật thành viên thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $team ) {

            $user_id = $this->getUserData()->id ?? $team->created_by;

            $data = [
                'name'              =>  $request->name,
                'position'          =>  $request->position,
                'images'            =>  $request->images,
                'title_image'       =>  $request->title_image,
                'alt_image'         =>  $request->alt_image,
                'social'            =>  Genratejsonarray( $request->social ),
				'description'		=>  $request->description,
                'updated_by'        =>  $user_id,
            ];

            try{
                $team->update( $data );

                if( $request->save_and_exits == 1 ) {
                    return redirect()->route('team.index')->with('message', $message);
                }

                return redirect()->route('team.edit',$team->id)->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect()->route('team.edit',$team->id)->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\backend\Team  $team
     * @return \Illuminate\Http\Response
     */
    /*
        public function destroy(Team $team)
        {
            $message = 'Xóa thành công.';
            $team->delete();

            return redirect()->route('team.index')->with('message', $message);

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
        $team = Team::find($id);

        $data = [
            'status'    =>  -2
        ];

        $team->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

    /**
     * [searchRelative team]
     * @param  Request $rq
     * @return search html
     */
    public function searchRelative(Request $rq)
    {
        $data = new Collection();
        $data->view    = $this->view.'search';

        $teams          = Team::searchTeam($rq->q);
        $isAppend       = $rq->isAppendModal;
        $type_search    = "team";
        $html           = View($data->view, compact("teams",'isAppend','type_search'))->render();
        return response()->json(['status' => 1, 'message' => $html]);

    }

}
