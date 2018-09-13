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
        $request->validate([
            'name' => 'nullable|max:255',
            'title' => 'nullable|max:255',
            'email' => 'nullable|max:255',
            'phone' => 'nullable|max:255',
            'wechat' => 'nullable|max:255',
            'qq' => 'nullable|max:255',
            'edu_title' => 'nullable|max:255',
            'edu_gpa' => 'nullable|max:255',
            'edu_university' => 'nullable|max:255',
            'edu_start' => 'nullable|max:255',
            'edu_end' => 'nullable|max:255',
            'work_title' => 'nullable|max:255',
            'work_company' => 'nullable|max:255',
            'work_start' => 'nullable|max:255',
            'work_end' => 'nullable|max:255',
        ]);

        $resume->update([
            'name' => request('name'),
            'title' => request('title'),
            'email' => request('email'),
            'phone' => request('phone'),
            'wechat' => request('wechat'),
            'qq' => request('qq'),
            'edu_title' => request('edu_title'),
            'edu_gpa' => request('edu_gpa'),
            'edu_university' => request('edu_university'),
            'edu_start' => request('edu_start'),
            'edu_end' => request('edu_end'),
            'work_title' => request('work_title'),
            'work_company' => request('work_company'),
            'work_start' => request('work_start'),
            'work_end' => request('work_end'),
            'work_description' => request('work_description'),
            'other_description' => request('other_description'),
        ]);

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
