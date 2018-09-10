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
use Stripe\{Stripe, Charge, Customer};
use Illuminate\Support\Facades\DB;
use App\Mail\JobNew;
use App\Mail\JobCancelled;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('index', 'create', 'store', 'checkout', 'save');
        $this->middleware('notPayed')->only('edit', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $relatedJobs = Job::where('is_payed', true)->inRandomJob()->limit(10)->get();
        return view('job.create', compact('relatedJobs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $job = Job::create([
            'user_id' => auth()->user()->id,
            'name' => request('name'),
            'price' => request('price'),
            'category' => request('category'),
            'country' => request('country'),
            'description' => request('description'),
            'link' => request('link'),
            'end_date' => request('endDate'),
            'quantity' => request('quantity'),
        ]);

        if (request('copyJobId')) {
            $copyJob = Job::find(request('copyJobId'));
            foreach ($copyJob->jobImgs as $image) {
                $original = Storage::get('jobImgs/originals/'.$copyJob->id.'/'.$image->filename.'.jpg');
                $thumbnail = Storage::get('jobImgs/thumbnails/'.$copyJob->id.'/'.$image->filename.'.jpg');

                Storage::disk('s3')->put('jobImgs/originals/'.$job->id.'/'.$image->filename.'.jpg', $original);
                Storage::disk('s3')->put('jobImgs/thumbnails/'.$job->id.'/'.$image->filename.'.jpg', $thumbnail);

                JobImg::create([
                    'job_id' => $job->id,
                    'filename' => $image->filename,
                    'mime' => $image->mime,
                    'original_filename' => $image->original_filename,
                ]);
            }
        }

        if (request('jobImgs')) {
            foreach (request('jobImgs') as $image) {

                $image_thumb = Image::make($image);
                if ($image_thumb->height() <= $image_thumb->width()) {
                    $image_thumb = $image_thumb->crop($image_thumb->height(), $image_thumb->height())->resize(500, 500);
                } else {
                    $image_thumb = $image_thumb->crop($image_thumb->width(), $image_thumb->width())->resize(500, 500);
                }
                $image_thumb = $image_thumb->stream();

                Storage::disk('s3')->put('jobImgs/originals/'.$job->id.'/'.$image->getFilename().'.jpg', File::get($image));
                Storage::disk('s3')->put('jobImgs/thumbnails/'.$job->id.'/'.$image->getFilename().'.jpg', $image_thumb->__toString());

                JobImg::create([
                    'job_id' => $job->id,
                    'filename' => $image->getFilename(),
                    'mime' => $image->getClientMimeType(),
                    'original_filename' => $image->getClientOriginalName(),
                ]);
            }
        }

        return view('job.store', compact('job'));
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job  $Job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        $relatedJobs = Job::where('is_payed', true)->inRandomJob()->limit(15)->get();
        return view('job.edit', compact('job', 'relatedJobs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job  $Job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $job->update([
            'name' => request('name'),
            'price' => request('price'),
            'category' => request('category'),
            'country' => request('country'),
            'description' => request('description'),
            'link' => request('link'),
            'end_date' => request('endDate'),
        ]);

        return view('job.store', compact('job'));
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

    public function checkout(Job $job)
    {
        auth()->user()->phone = request('phone');
        auth()->user()->save();

        $job->delivery = request('delivery');
        $job->is_payed = true;
        $job->save();

        \Mail::to(auth()->user())->send(new JobNew($job->user, $job));

        return redirect()->action('JobController@index');
    }

    public function search()
    {      
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
            $jobs = $jobs->where('category', $sCategory);
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
                case 'No Experience':
                    $jobs = $jobs->where('experience', '=', 0);
                    break;
                case 'Less than 1 year':
                    $jobs = $jobs->whereBetween('experience', [0, 1]);
                    break;
                case '1 to 3 years':
                    $jobs = $jobs->whereBetween('experience', [1, 3]);
                    break;
                case '3 to 5 years':
                    $jobs = $jobs->whereBetween('experience', [3, 5]);
                    break;
                case '5 years or above':
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
            $btn_text = 'Apply';
            $disabled = '';
            if (auth()->check() && App::where('user_id', auth()->user()->id)->where('job_id', $currentJob->id)->count() != 0) {
                $btn_text = 'Applied';
                $disabled = 'disabled';
            }
        }

        return view('job.search', compact('jobs', 'currentJob', 'btn_text', 'disabled', 'slideOutSearch'));
    }

    public function select(Job $job, Request $request)
    {
        $btn_text = 'Apply';
        $disabled = false;
        if (auth()->check() && App::where('user_id', auth()->user()->id)->where('job_id', $job->id)->count() != 0) {
            $btn_text = 'Applied';
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

    public function cancel(Job $job, Request $request)
    {
        $job->is_cancelled = true;
        $job->save();

        \Mail::to($job->user)->send(new JobCancelled($job->user, $job));

        return redirect()->action('JobController@index');
    }
}
