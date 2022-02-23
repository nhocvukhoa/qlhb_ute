<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class ContactController extends Controller
{
    public function contactUs() {
        $title = 'Liên hệ - Phản hồi';
        return view('Client.LienHe.index', compact('title'));
    }

    public function send(Request $request) {
        $request->validate(
            [
                'name' => 'required', 
                'message' => 'required',
            ],
            [
                'name.required' => 'Vui lòng nhập họ tên',
                'message.required' => 'Vui lòng nhập nội dung'
            ]);
    
        $data = array(
            'name' => $request->name,
            'message' => $request->message,
        );  

        Mail::to('nvanhkhoa148@gmail.com')->send(new SendEmail($data));
        session()->put('message','Gửi ý kiến thành công');
        return back();
    }
}
