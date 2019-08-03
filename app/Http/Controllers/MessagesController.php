<?php
	
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class MessagesController extends Controller
{
    public function submit(Request $request){
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required'
		]);
		
		//create new message
		$message = new Message;
		$message->name = $request->input('name');
		$message->email = $request->input('email');
		$message->message = $request->input('message');
		$date_timestamp = time();
		$message->created_at = $date_timestamp;
		$message->updated_at = $date_timestamp;
		//save message
		$message->save();
		
		return redirect('/contact?status=Yes');
	}
}
