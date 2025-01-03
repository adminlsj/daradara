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

        $chinese = new Chinese();

        return view('company.show', compact('animes', 'company', 'chinese'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'max:255',
        ]);

        $results = Company::query();

        if ($text = $request->text) {
            $query = $text;
            $query = mb_strtolower($query, 'UTF-8');
            $query = str_replace(' ', '%', $query);
            $chinese = new Chinese();
            $original = '%'.$query.'%';
            $zh_hant = '%'.$chinese->to(Chinese::ZH_HANT, $query).'%';
            $zh_hans = '%'.$chinese->to(Chinese::ZH_HANS, $query).'%';
            $results = $results->where(function($query) use ($original, $zh_hant, $zh_hans) {
                $query->where('searchtext', 'like', $original)
                      ->orWhere('searchtext', 'like', $zh_hant)
                      ->orWhere('searchtext', 'like', $zh_hans);
            });
        }

        $results = $results->distinct()->paginate(30);

        $results->setPath('');

        $chinese = new Chinese();
        return view('company.search', compact('results', 'text', 'chinese'));
    }
}