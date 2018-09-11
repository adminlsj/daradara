<?php

namespace App\Http\Controllers;

use App\Resume;
use App\ResumeImg;
use Illuminate\Http\Request;
use Storage;
use File;
use Image;

class ResumeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Resume $resume)
    {
        $haveResumeImg = false;
        if ($resume->resumeImg != null) {
            $haveResumeImg = true;
        }

        return view('resume.edit', compact('resume', 'haveResumeImg'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resume $resume)
    {
        $resume->name = request('name');
        $resume->title = request('title');
        $resume->email = request('email');
        $resume->phone = request('phone');
        $resume->location = request('location');
        $resume->wechat = request('wechat');
        $resume->qq = request('qq');
        $resume->edu_title = request('edu_title');
        $resume->edu_gpa = request('edu_gpa');
        $resume->edu_university = request('edu_university');
        $resume->edu_start = request('edu_start');
        $resume->edu_end = request('edu_end');
        $resume->work_title = request('work_title');
        $resume->work_company = request('work_company');
        $resume->work_start = request('work_start');
        $resume->work_end = request('work_end');
        $resume->work_description = request('work_description');
        $resume->language_one = request('language_one');
        $resume->language_one_level = request('language_one_level');
        $resume->language_two = request('language_two');
        $resume->language_two_level = request('language_two_level');
        $resume->language_three = request('language_three');
        $resume->language_three_level = request('language_three_level');
        $resume->other_description = request('other_description');

        $resume->save();

        $file = request('resumeImgs')[0];

        if ($file) {
            if ($resume->resumeImg != null) {
                Storage::disk('s3')->delete('resumes/'.$resume->id.'/'.$resume->resumeImg->filename.'.pdf');
                $resume->resumeImg->delete();
            }

            Storage::disk('s3')->put('resumes/'.$resume->id.'/'.$file->getFilename().'.pdf', File::get($file));

            ResumeImg::create([
                'resume_id' => $resume->id,
                'filename' => $file->getFilename(),
                'mime' => $file->getClientMimeType(),
                'original_filename' => $file->getClientOriginalName(),
            ]);
        }
        
        return redirect()->action('ResumeController@edit', ['resume' => $resume]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
