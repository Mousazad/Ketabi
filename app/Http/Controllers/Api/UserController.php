<?php
namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
			'email' => ['required', 'email'],
			'password' => ['required'],
		]);

		if (Auth::attempt($credentials)) {   
			$token = $request->user()->createToken("ketabi");
			return ['token' => $token->plainTextToken];
		}else{
			return ['message' => "unauthenticated"];
		}
    }
}