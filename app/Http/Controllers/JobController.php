<?php

namespace App\Http\Controllers;

use App\App;
use App\Company;
use App\Job;
use App\CompanyImg;
use App\SavedJob;
use Illuminate\Http\Request;
use Storage;
use File;
use Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Mail\JobNew;
use App\Mail\JobCancelled;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('save', 'destroy');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        $currentJob = $job;

        $btn_text = 'Apply';
        $disabled = '';
        if (auth()->check() && App::where('user_id', auth()->user()->id)->where('job_id', $job->id)->count() != 0) {
            $btn_text = 'Applied';
            $disabled = 'disabled';
        }

        return view('job.show', compact('currentJob', 'btn_text', 'disabled'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'title' => 'nullable|max:255',
            'salary' => 'nullable|integer',
        ]);

        $jobs = Job::where('created_at', '>=', Carbon::now()->subDays(31));
        $slideOutSearch = false;

        if (request('title') != null) {
            $jobs = $jobs->where(function ($query) {

                $sTitle = strtolower(request('title'));
                $companiesId = Company::where('name', 'ILIKE', '%'.$sTitle.'%')->pluck('id');

                $query->whereIn('company_id', $companiesId)
                      ->orWhere('title', 'ILIKE', '%'.$sTitle.'%');

            });
            $jobs = $jobs->distinct();
        }

        if (request('category') != null) {
            $sCategory = request('category');
            $jobs = $jobs->where('category', 'ILIKE', '%'.$sCategory.'%');
        }

        if (request('location') != null) {
            $sLocation = request('location');
            $jobs = $jobs->where('location', $sLocation);
        }

        if (request('salary') != null) {
            $sSalary = request('salary');
            $jobs = $jobs->where('salary', '>=', $sSalary);
            $slideOutSearch = true;
        }

        if (request('experience') != null) {
            $sExp = request('experience');
            $slideOutSearch = true;
            switch ($sExp) {
                case '不限經驗':
                    $jobs = $jobs->where('experience', '=', 0);
                    break;
                case '少於 1 年':
                    $jobs = $jobs->whereBetween('experience', [0, 1]);
                    break;
                case '1 至 3 年':
                    $jobs = $jobs->whereBetween('experience', [1, 3]);
                    break;
                case '3 至 5 年':
                    $jobs = $jobs->whereBetween('experience', [3, 5]);
                    break;
                case '5 年或以上':
                    $jobs = $jobs->where('experience', '>=', 5);
                    break;
                default:
                    $jobs = $jobs;
                    break;
            }
        }

        if (request('level') != null) {
            $sLevel = request('level');
            $jobs = $jobs->where('level', $sLevel);
        }

        if (request('type') != null) {
            $sType = request('type');
            $jobs = $jobs->where('type', $sType);
            $slideOutSearch = true;
        }

        if (request('education') != null) {
            $sEdu = request('education');
            $jobs = $jobs->where('education', $sEdu);
            $slideOutSearch = true;
        }

        $jobs = $jobs->orderBy('created_at', 'desc')->paginate(20);
        $currentJob = $jobs->first();

        if ($currentJob != null) {
            $btn_text = '投遞簡歷';
            $disabled = '';
            if (auth()->check() && App::where('user_id', auth()->user()->id)->where('job_id', $currentJob->id)->count() != 0) {
                $btn_text = '已應徵';
                $disabled = 'disabled';
            }
        }

        return view('job.search', compact('jobs', 'currentJob', 'btn_text', 'disabled', 'slideOutSearch'));
    }

    public function select(Job $job, Request $request)
    {
        $btn_text = '投遞簡歷';
        $disabled = false;
        if (auth()->check() && App::where('user_id', auth()->user()->id)->where('job_id', $job->id)->count() != 0) {
            $btn_text = '已應徵';
            $disabled = true;
        }

        return response()->json([
            'job_id' => $job->id,
            'current_id' => request('currentId'),
            'company_name' => $job->company->name,
            'company_description' => $job->company->description,
            'job_title' => $job->title,
            'job_responsibility' => $job->responsibility,
            'job_requirement' => $job->requirement,
            'job_location' => $job->location,
            'job_salary' => $job->salary,
            'btn_text' => $btn_text,
            'disabled' => $disabled,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function save(Job $job, Request $request)
    {
        $createSaveJob = true;
        $savedJob = SavedJob::where('user_id', auth()->user()->id)->where('job_id', $job->id);
        if ($savedJob->count() != 0) {
            $savedJob->delete();
            $createSaveJob = false;
        } else {
            SavedJob::create([
                'user_id' => auth()->user()->id,
                'job_id' => $job->id,
            ]);
        }

        return response()->json([
            'job_id' => $job->id,
            'create_save_job' => $createSaveJob,
            'csrf_token' => csrf_token(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $Job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        //
    }
}
