<?php

namespace App\Http\Controllers\frontend;

use App\Models\backend\Schema;
use App\Models\backend\SchemaBreadcrumb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Models\backend\Contact;
use App\Models\backend\ConfigContact;
use App\Models\backend\ConfigEmail;
use App\Models\backend\ConfigLogo;
use App\Models\backend\ConfigSeo;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ContactController extends Controller
{
    private $layout  = 'frontend.layouts.';
    private $view    = 'frontend.pages.contact.';
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
		$data->title   = 'Liên Hệ';
        $data->layout  = $this->layout.'page';
        $data->view    = $this->view.'index';
        $data->content = $this->content;

        $contact = ConfigContact::where('status', 1)->first();

        $logo = ConfigLogo::where("status",1)->get();
        $logo->top = $logo->where("type",1)->first();

        if( !empty( $category->images ) ) {
            $cat_img = $category->images;
        }elseif( !empty( $logo->top->images ) ) {
            $cat_img = $logo->top->images;
        }else {
            $cat_img = asset('assets/client/dist/images/favicon.png');
        }

        $dataSeo    = ConfigSeo::where('status', 1)->first();
        $seo_title          = $dataSeo->seo_title ?? '';
        $seo_keywords       = $dataSeo->seo_keywords ?? '';
        $seo_description    = $dataSeo->seo_description ?? '';

        //schema doanh nghiệp
        $json_business = Schema::where('type', 'business')
            ->where('status',1)
            ->first();
        if($json_business){
            $data['schema_business'] = json_encode(unserialize($json_business->contents));
        }

        //schema ô tìm kiếm
        $json_search = Schema::where('type', 'search')
            ->where('status',1)
            ->first();
        if($json_search){
            $data['schema_search'] = json_encode(unserialize($json_search->contents));
        }

        //schema breadcrumb
        $json_breadcrumb = SchemaBreadcrumb::where('type', 'lien-he')
            ->where('status',1)
            ->first();
        if($json_breadcrumb){
            $data['schema_breadcrumb'] = json_encode(unserialize($json_breadcrumb->content));
        }


        $data['contact']         = $contact;
        $data['title']           = $data->title;
        $data['og_image']        = $cat_img;
        $data['og_url']          = asset('/lien-lac');
        $data['seo_title']       = $seo_title;
        $data['seo_keywords']    = $seo_keywords;
        $data['seo_description'] = $seo_description;
        $data['page_type']       = 'website';

        return View($data->view,compact('data'));

    }

    public function contactSubmit(Request $request) {

		$message ="Gửi yêu cầu thành công";
		$contact = new Contact();
        $email = ConfigEmail::find(1);

		try{

			$contact->fullname 	= $request->fullname;
			$contact->phone 	= $request->phone;
			$contact->email 	= $request->email;
			$contact->address 	= $request->address;
			$contact->message 	= $request->message;
			$contact->alias_contact = $request->alias_contact;

			$body_note = 'Khách hàng: ' . $request->fullname . ' đã liên hệ ';

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
			if(empty($request->email)){
                $this->sendMail($request->name, $email->smtp_email, true, $body_note);
			}

            if(!empty($request->email)){
                $this->sendMail($request->name, $request->email, false, "");
                $this->sendMail($request->name, $email->smtp_email, true, $body_note);
            }
			$contact->save();
		}
		catch(\Exeption $e){
			$error = "Gửi yêu cầu thất bại";
		}

		if( !empty( $request->alias_contact ) ) {
			$redirect = $request->alias_contact;
		}else {
			$redirect = "/lien-lac";
		}
		if( !empty( $message ) ) {
			return redirect( $redirect )->with("message",$message);
		}elseif( !empty( $error ) ) {
			return redirect( $redirect )->with("error",$error);
		}

	}

	private function sendMail($name , $emailRep, $admin = false, $note = "", $phone = null){

		$email = ConfigEmail::find(1);

	    $mail = new PHPMailer(true); // notice the \  you have to use root namespace here

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
				$mail->Host = $email->smtp_host;
				$mail->Port = $email->smtp_port; // most likely something different for you. This is the mailtrap.io port i use for testing.
				$mail->Username = $email->smtp_email;
				$mail->Password = $email->smtp_pass;
				$mail->setFrom($email->smtp_email, $email->smtp_title);
				$mail->Subject = "Yêu Cầu Liên Hệ";
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

				if( !empty( $phone ) ) {
					$mail->Subject = "Yêu Cầu Liên Hệ - " . $phone;
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

			} catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		    }
	}


}
