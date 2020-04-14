<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
    	$user = User::create([
            'name' => 'demo',
            'email' => 'demo@gmail.com',
            'password' => bcrypt('doraemon'),
        ]);
        return $user;
    }
}
