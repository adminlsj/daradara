<?php

namespace App\Http\Controllers;

use App\Company;
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

class CompanyController extends Controller
{
    public function show(Request $request, Company $company)
    {
        $animes = $company->animes;
        return view('company.show', compact('animes', 'company'));
    }
}