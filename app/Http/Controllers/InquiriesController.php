<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InquiriesController extends Controller
{
    public function send(Request $request){
        Mail::to('noreplytest@admin.ventures')->send(new \App\Mail\Inquiries($request));
        return 'Email Sent';
    }
}
