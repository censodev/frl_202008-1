<?php

namespace App\Http\Controllers\frontend;

use App\Models\backend\Agency;
use App\Models\backend\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class AgencyController extends Controller
{
    protected $limit = 12;
    private $layout  = 'frontend.layouts.';
    private $view    = 'frontend.pages.agency.';
    private $content = 'content';

    public function login(Request $request){
        $username = $request->username;
        $password = md5($request->password);

        $agency = Agency::where([['status',1],['name',$username],['password',$password]])->first();

        if($agency != null){
            $data_agency = [
                'id'            => $agency->id,
                'title'         => $agency->title,
                'username'      => $agency->username,
            ];
            Session::put('data_agency',$data_agency);
            return redirect()->route('list-order-agency');

        }else{
            return redirect()->route('home');
        }
    }

    public function listOrder(Request $request){
        $data = new Collection();
        $data->title   = 'Danh sách Order';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'index';
        $data->content = $this->content;

        $page = $request->page && $request->page > 0 ? $request->page : 1;
        $agency = session('data_agency');
        if($agency){
            $data['listOrder'] = Order::where('status', 1)->where('agency_id', $agency['id'])->paginate($this->limit, ['*'], 'page',$page);
        }
        return View($data->view,compact('data'));
    }

    public function detailOrder($id){
        $data = new Collection();
        $data->title   = 'Chi tiết Order';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'detail';
        $data->content = $this->content;

        $agency = session('data_agency');
        if($agency){
            $data['detailOrder'] = Order::where('status', 1)->where('id', $id)->first();
        }
        return View($data->view,compact('data'));
    }

    public function logout(Request $request){
        Session::forget('data_agency');
        return redirect()->route('home');
    }
}
