<?php

namespace App\Http\Controllers\frontend;

use App\Models\backend\Certify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CertifyController extends Controller
{
    public function search(Request $request)
    {
        $id = $request->id;
        $certify = Certify::where("status", 1)->where("id", $id)->get()->toArray();
        $certify_images = json_decode($certify[0]['images']);

        $html = '';
        if (!empty($certify_images) && count($certify_images) > 0) {
            foreach ($certify_images as $key => $item) {
                $tmp = $key+1;
                $html .= "<div class='mySlides'>
                                <div class='numbertext'> $tmp </div>
                                <img src='".$item."' style='width:100%'>
                          </div>";
            }
        }

        return response()->json(['status' => 1, 'message' => $html]);
    }
}
