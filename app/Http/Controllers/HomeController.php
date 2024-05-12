<?php

namespace App\Http\Controllers;

use App\User;
use App\Video;
use App\Save;
use App\Like;
use App\Subscribe;
use App\Playlist;
use App\Playitem;
use App\Bot;
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
use App\Video_temp;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $is_mobile = Helper::checkIsMobile();

        return view('layouts.home');
    }

    public function about(Request $request)
    {
        return view('layouts.about-us');
    }

    public function contact()
    {
        return view('layouts.contact');
    }

    public function terms()
    {
        return view('layouts.terms');
    }

    public function policies()
    {
        return view('layouts.policies');
    }

    public function copyright(Request $request)
    {
        return view('layouts.copyright-en');
    }

    public function p2257(Request $request)
    {
        return view('layouts.2257');
    }

    public function userReport(Request $request)
    {
        $device = '';
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (Helper::checkIsMobile()) {
            if (strpos($user_agent, "Android") !== FALSE) {
                $device = 'Android';
            } elseif (strpos($user_agent, "iPhone") !== FALSE) {
                $device = 'iPhone';
            } elseif (strpos($user_agent, "webOS") !== FALSE) {
                $device = 'webOS';
            } else {
                $device = 'Mobile';
            }
        } else {
            if (strpos($user_agent, "Win") !== FALSE) {
                $device = 'Windows';
            } elseif (strpos($user_agent, "Mac") !== FALSE) {
                $device = 'Mac';
            } elseif (strpos($user_agent, "iPad") !== FALSE) {
                $device = 'iPad';
            } else {
                $device = 'Desktop';
            }
        }
        $device = ' ('.$device.')';

        $ip_address = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : 'N/A';
        $country_code = isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : 'N/A';
        $banned_ip = ['N/A', '185.220.100.255', '185.100.85.22'];
        if (in_array($ip_address, $banned_ip)) {
            abort(403);
        } else {
            $request->validate([
                'userReportReason' => 'required'
            ]);
            $email = request('report-email') == null ? '' : request('report-email');
            $reason = request('userReportReason');
            if ($reason == '其他原因') {
                $reason = $reason.'：'.request('others-text');
            }
            if (strpos($reason, 'GET FREE iPhone') !== false || strpos($reason, 'Withdrаw') !== false || strpos($reason, 'telegra.ph') !== false || strpos($reason, 'bitсоin') !== false || strpos($reason, 'BТС') !== false || strpos($reason, 'Transaction') !== false || strpos($reason, 'script.google') !== false) {
                abort(403);
            }
            Mail::to('vicky.avionteam@gmail.com')->send(new UserReport($email, $reason, request('video-id'), request('video-title'), request('video-sd'), $ip_address, $country_code.$device));

            if (request('video-title') == 'User Verification') {
                return Redirect::back()->withErrors('我們已收到您的申請，並會在近日內透過您的電郵地址聯繫您。');
            } else {
                return Redirect::back()->withErrors('感謝您向我們提供意見或回報任何錯誤。');
            }
        }
    }
}
