<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

	public function send(Request $request)
	{
		$request->validate([
			'email' => 'required|email'
		]);

		$email = $request->input('email');
		$firstName = $request->input('firstName');
		$lastName = $request->input('lastName');
		$message = $request->input('message');
		$subject = $request->input('subject');

		Mail::to('abdulrahmansaber120@gmail.com')->send(new SendContactMessage($firstName, $lastName, $email, $message, $subject));

		return response()->json([
			'message' => "Message sent successfully",
			"status" => 200
		]);
	}
}
