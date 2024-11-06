<?php

namespace App\Http\Controllers;

use App\Staff;
use App\Anime;
use App\Character;
use App\Episodes;
use App\User;
use Illuminate\Http\Request;
use Response;
use Auth;
use Mail;
use App\Mail\UserReport;
use Redirect;
use Storage;
use App\Helper;
use SteelyWing\Chinese\Chinese;
use Illuminate\Database\Eloquent\Builder;

class StaffController extends Controller
{
    public function show(Request $request, Staff $staff)
    {
        $animes_actor = $staff->animes('App\Actor')->get();
        $animes_staff = $staff->animes('App\Staff')->get();
        return view('staff.show', compact('staff', 'animes_actor', 'animes_staff'));
    }
}