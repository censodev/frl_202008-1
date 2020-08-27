<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\SignupOffer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class SignupOfferController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.signupOffer.';
    private $content = 'content';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new Collection();
        $data->title   = 'Danh Sách Đăng Ký Nhận Ưu Đãi';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['signupOffers'] = SignupOffer::searchSignupOffer($data->keyword, $this->limit);
        }else {
            $data['signupOffers'] = SignupOffer::listSignupOffer(Null, true, $this->limit);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\backend\SignupOffer  $signupOffer
     * @return \Illuminate\Http\Response
     */
    public function show(SignupOffer $signupOffer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $error   = 'Không tìm thấy dữ liệu về khách hàng này.';
        $signupOffer = SignupOffer::find($id);

        if( !empty( $signupOffer ) ) {

            $message = $signupOffer->message ?? 'Khách Hàng Không Nhập Nội Dung.';

            return response()->json(['message' => $message], 200);

        }else {
            return response()->json(['error' => $error], 200);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\backend\SignupOffer  $signupOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SignupOffer $signupOffer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\backend\SignupOffer  $signupOffer
     * @return \Illuminate\Http\Response
     */
    /*
        public function destroy(SignupOffer $signupOffer)
        {
            $message = 'Xóa thành công.';
            $signupOffer->delete();

            return redirect()->route('signupOffer.index')->with('message', $message);

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
        $signupOffer = SignupOffer::find($id);

        $data = [
            'status'    =>  -2
        ];

        $signupOffer->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

}
