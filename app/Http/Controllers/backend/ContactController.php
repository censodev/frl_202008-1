<?php

namespace App\Http\Controllers\backend;

use App\Models\backend\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class ContactController extends Controller
{
    protected $user  = NULL;
    protected $limit = 15;
    protected $title = '';
    private $keyword = '';
    private $layout  = 'backend.layouts.';
    private $view    = 'backend.pages.contact.';
    private $content = 'content';
    /**
     * Display a listing of the resource.
     *
	 * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = new Collection();
        $data->title   = 'Danh Sách Liên Hệ';
        $data->keyword = $this->keyword;
        $data->layout  = $this->layout.'index';
        $data->view    = $this->view.'list';
        $data->content = $this->content;

        if( !empty( $request->keyword ) ) {
            $data->keyword = $request->keyword;
            $data['contacts'] = Contact::searchContact($data->keyword, $this->limit);
        }else {
            $data['contacts'] = Contact::listContact(Null, true, $this->limit);
        }
		
		$data['keyword'] = $data->keyword;

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
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
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
        $contact = Contact::find($id);

        if( !empty( $contact ) ) {

            $message = $contact->message ?? 'Khách Hàng Không Nhập Nội Dung.';

            return response()->json(['message' => $message], 200);

        }else {
            return response()->json(['error' => $error], 200);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    /*
        public function destroy(Contact $contact)
        {
            $message = 'Xóa thành công.';
            $contact->delete();

            return redirect()->route('contact.index')->with('message', $message);

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
        $contact = Contact::find($id);

        $data = [
            'status'    =>  -2
        ];

        $contact->update( $data );

        return response()->json(['result' => 'Đã xóa thành công.'], 200);

    }

}
