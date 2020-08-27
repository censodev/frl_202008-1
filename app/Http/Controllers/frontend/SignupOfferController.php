<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Models\backend\SignupOffer;
use App\Models\backend\ConfigContact;
use App\Models\backend\ConfigEmail;
use App\Models\backend\ConfigLogo;
use App\Models\backend\ConfigSeo;
use PHPMailer\PHPMailer;

class SignupOfferController extends Controller
{
    public function signupOfferSubmit(Request $request) {

		$message ="Gửi yêu cầu thành công";
		$signupOffer = new SignupOffer();
		try{

			$signupOffer->fullname 	= $request->fullname;
			$signupOffer->phone 	= $request->phone;
			$signupOffer->email 	= $request->email;
			$signupOffer->message 	= $request->message;
			$signupOffer->alias_contact = $request->alias_contact;

			$body_note = 'Khách hàng: ' . $request->fullname . ' đã đăng ký nhận ưu đãi ';

			if( !empty( $request->email ) ) {
				$body_note .= ', có email : ' . $request->email;
			}
			if( !empty( $request->phone ) ) {
				$body_note .= ', số điện thoại : ' . $request->phone;
			}
			if( !empty( $request->message ) ) {
				$body_note .= ', với nội dung : ' . $request->message;
			}
			if( !empty( $request->alias_contact ) ) {
				$body_note .= '.  Tại : <a href="' . $request->alias_contact . '">' . $request->alias_contact . '</a>';
			}
			$this->sendMail($request->name, $request->email, false, "", $request->phone);
			$this->sendMail($request->name, $request->email, true, $body_note, $request->phone);

			$signupOffer->save();
		}
		catch(\Exeption $e){
			$error = "Gửi yêu cầu thất bại";
			return back()->with("error",$error);
		}

		return back()->with("message",$message);

	}

	private function sendMail($name , $emailRep, $admin = false, $note = "", $phone = nulls){

		$email = ConfigEmail::find(1);
	    $mail = new PHPMailer\PHPMailer(true); // notice the \  you have to use root namespace here

			try {
			    $mail->SMTPOptions = array(
                            'ssl' => array(
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            )
                        );
	   			$mail->isSMTP(); // tell to use smtp
				$mail->CharSet = "utf-8"; // set charset to utf8
				$mail->SMTPAuth = true;  // use smpt auth
				$mail->SMTPSecure = "tls"; // or ssl
				$mail->Host = $email->smtp_host;
				$mail->Port = $email->smtp_port; // most likely something different for you. This is the mailtrap.io port i use for testing.
				$mail->Username = $email->smtp_email;
				$mail->Password = $email->smtp_pass;
				$mail->setFrom($email->smtp_email, $email->smtp_title);
				$mail->Subject = "Đăng Ký Nhận Ưu Đãi";

				if( !empty( $phone ) ) {
					$mail->Subject = "Đăng Ký Nhận Ưu Đãi - " . $phone;
				}
				$tmp = $email->smtp_content;
				$body="";
				for($i =0; $i<strlen($tmp) ; ++$i){
					if($tmp[$i]=="["){
						$body = $body." ".$name;
						while($tmp[$i] !="]"){
							++$i;
						}
						continue;
					}
					$body = $body.$tmp[$i];
				}

				if( $admin ) {
					$emailRep = $email->smtp_email;
					$body = !empty( $note ) ? $note : "";
				}else {
					$body .= $note;
				}

				$mail->MsgHTML($body);
				$mail->addAddress($emailRep);
				$mail->send();
			} catch (phpmailerException $e) {

			} catch (Exception $e) {

		}
	}

}
