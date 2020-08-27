<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\backend\ConfigSocialClick;
use Carbon\Carbon;

class SocialClickController extends Controller
{
    public function isSocialClick(Request  $rq){
        try {
			$date = Carbon::now()->format('Y-m-d');
			$data = ConfigSocialClick::where([
				['ip', $rq->ip()],
				['social_id', $rq->id],
			])->whereDate('date', $date)->first();

			if (empty($data)) {
				ConfigSocialClick::create([
					'social_id' => $rq->id,
					'ip' => $rq->ip(),
					'date' => $date,
					'number_click' => 1
				]);
			}else {
				$data->where([
					['ip', $rq->ip()],
					['social_id', $rq->id],
				])->whereDate('date',$date)->increment('number_click');
			}
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

}
