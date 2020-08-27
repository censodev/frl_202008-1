<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\ConfigPolicy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreConfigPolicyRequest;
use Auth;
use File;
use App\Services\ImageService;

class ConfigPolicyController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $image_service;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.configPolicy.';
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
        $data->title   = 'Danh Sách Chính Sách';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['configPolicies'] = ConfigPolicy::searchConfigPolicy($data->keyword,$this->limit);
        }else {
            $data['configPolicies'] = ConfigPolicy::listConfigPolicy(Null, true, $this->limit);
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
        $data->title   = 'Thêm Mới Chính Sách';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'add';
        $data->content = $this->content;

        return View($data->view,compact('data'));
		
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigPolicyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConfigPolicyRequest $request)
    {
        $message = 'Đã thêm mới thành công chính sách.';

        $user_id = $this->getUserData()->id ?? 1;
		
		$policy_title  = !empty( $request->policy_title ) ? Genratejsonarray( $request->policy_title ) : '';
		$policy_icon  	 = !empty( $request->policy_icon ) ? Genratejsonarray( $request->policy_icon ) : '';
        $policy_description = !empty( $request->policy_description ) ? Genratejsonarray( $request->policy_description ) : '';

        $data = [
            'title'                 =>  $request->title,
			'policy_sales'          =>  $request->policy_sales,
			'policy_delivery'       =>  $request->policy_delivery,
            'policy_title'          =>  $policy_title,
            'policy_icon'     		=>  $policy_icon,
            'policy_description'    =>  $policy_description,
            'created_by'            =>  $user_id,
            'status'                =>  1,
        ];

        try{
            ConfigPolicy::create( $data );

            return redirect()->route('configPolicy.index')->with('message', $message);

        } catch(\Exception $e){
            $error = $e->getMessage();

            return redirect()->route('configPolicy.index')->with('error', $error);
        }
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\ConfigPolicy  $configPolicy
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigPolicy $configPolicy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\backend\ConfigPolicy  $configPolicy
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigPolicy $configPolicy)
    {
        $data = new Collection();
        $data->title   = 'Cập Nhật Chính Sách';
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'update';
        $data->content = $this->content;

        $error = 'Không tìm thấy dữ liệu về chính sách này. Vui lòng thử lại.';

        if( Configpolicy::checkExists( $configPolicy->id ) ) {
            $data['configPolicy']       = $configPolicy;

            return View($data->view,compact('data'));
        }else {
            return redirect()->route('configPolicy.index')->with('error', $error);

        }
		
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreConfigPolicyRequest  $request
     * @param  \App\Models\backend\ConfigPolicy  $configPolicy
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConfigPolicyRequest $request, ConfigPolicy $configPolicy)
    {
        $message        = 'Đã cập nhật chính sách thành công.';
        $error_update   = 'Đã có lỗi xảy ra trong quá trình cập nhật. Vui lòng thử lại.';

        if( $configPolicy ) {

            $user_id = $this->getUserData()->id ?? $configPolicy->created_by;
			
			$policy_title  = !empty( $request->policy_title ) ? Genratejsonarray( $request->policy_title ) : '';
			$policy_icon  	 = !empty( $request->policy_icon ) ? Genratejsonarray( $request->policy_icon ) : '';
			$policy_description = !empty( $request->policy_description ) ? Genratejsonarray( $request->policy_description ) : '';

            $data = [
                'title'                 =>  $request->title,
				'policy_sales'          =>  $request->policy_sales,
				'policy_delivery'       =>  $request->policy_delivery,
				'policy_title'          =>  $policy_title,
				'policy_icon'     		=>  $policy_icon,
				'policy_description'    =>  $policy_description,
                'updated_by'        	=>  $user_id,
            ];

            try{
                $configPolicy->update( $data );

                return redirect('admin/configPolicy/'. $configPolicy->id .'/edit')->with('message', $message);

            } catch(\Exception $e){
                $error = $e->getMessage();

                return redirect('admin/configPolicy/'. $configPolicy->id .'/edit')->with('error', $error);
            }

        }else {
            return back()->with('error', $error_update);

        }
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\backend\ConfigPolicy  $configPolicy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $configPolicy = ConfigPolicy::find($id);

        $data = [
            'status'    =>  -2
        ];

        $configPolicy->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }
}
