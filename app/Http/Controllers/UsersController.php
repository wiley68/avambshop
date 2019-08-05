<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function saveUser(Request $request){
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required'
		]);

		$user = User::find($request->input('id'));
		$user->name = $request->input('name');
		$user->email = $request->input('email');
		$user->phone = $request->input('phone');
		$user->city = $request->input('city');
		$user->postalcod = substr($request->input('postalcod'), 0, 4);
		$user->address = $request->input('address');
		if ($request->input('isfirma') != NULL){
			$user->isfirma = 'Yes';
			$user->firmname = $request->input('firmname');
			$user->eik = $request->input('eik');
			$user->dds_nomer = $request->input('dds_nomer');
			$user->firmcity = $request->input('firmcity');
			$user->firmaddress = $request->input('firmaddress');
			$user->mol = $request->input('mol');
		}else{
			$user->isfirma = 'No';
		}
		$user->save();
		
		return redirect('/profile?status=Yes');
	}
	
}
