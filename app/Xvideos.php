<?php

namespace App;

use Mail;
use App\Video;
use App\Helper;
use Carbon\Carbon;
use App\Mail\UserReport;
use Illuminate\Support\Facades\Log;

class Xvideos
{
    public static function updateXvideos($number = 1, $total = 1)
    {
        Log::info('Xvideos update started...');

        $videos = Video::where('sd', 'like', '%xvideos%')
                    ->select('id', 'title', 'sd', 'outsource', 'tags_array', 'foreign_sd', 'created_at')
                    ->orderBy('id', 'asc')
                    ->get()
                    ->split($total)[$number - 1]
                    ->sortBy(function($video){
                        $expire = 0;
                        if (strpos($video->sd, 'cdn77-vid') !== false) {
                            $expire = Helper::get_string_between($video->sd, '==,', '/');
                        } elseif (strpos($video->sd, '-hw.xvideos') !== false) {
                            $expire = Helper::get_string_between($video->sd, '?e=', '&');
                        } elseif (strpos($video->sd, '-l3.xvideos') !== false) {
                            $sd = str_replace('-l3.xvideos-cdn', '', $video->sd);
                            $expire = Helper::get_string_between($sd, '-', '/');
                        }
                        return (int) $expire;
                    })
                    ->values()
                    ->slice(0, 3);

        foreach ($videos as $video) {
            $key = array_key_exists('xvideos', $video->foreign_sd) ? 'xvideos' : 'error';
            $curl_connection = curl_init($video->foreign_sd[$key]);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_connection, CURLOPT_HTTPHEADER, [
                'User-Agent: '.Helper::$userAgents[array_rand(Helper::$userAgents)],
                'Host: www.xvideos.com',
                'Referer: https://www.xvideos.com/account/uploads',
                'Cookie: _ga=GA1.2.979984912.1619035848; _ym_uid=1619035986805725121; _ym_d=1619035986; session_ath=light; wpn_ad_cookie=2d7f6a1b6557fcc3541c8ebd155a6a5b; cit=269de96f64d643f8trKNZ2h_p6KD2L8rLS3CME_iWTcxNWvJR_pQBO01jq-cWTzY2DtjOOAaD2nvL3sm; static_cdn=st; html5_pref=%7B%22SQ%22%3Afalse%2C%22MUTE%22%3Afalse%2C%22VOLUME%22%3A0.2222222222222222%2C%22FORCENOPICTURE%22%3Afalse%2C%22FORCENOAUTOBUFFER%22%3Afalse%2C%22FORCENATIVEHLS%22%3Afalse%2C%22PLAUTOPLAY%22%3Atrue%2C%22CHROMECAST%22%3Afalse%2C%22EXPANDED%22%3Afalse%2C%22FORCENOLOOP%22%3Afalse%7D; xv_nbview=-1; __atssc=google%3B3; html5_networkspeed=23283; __atuvc=0%7C35%2C0%7C36%2C0%7C37%2C12%7C38%2C14%7C39; XVUPLOADSESSION=r8rhm1j3p8pnvf59plp1lq7ij8; X-Backend=12|YVSpX|YVSST; last_subs_check=1; last_views=%5B%2253036937-1619123059%22%2C%2252987433-1619123110%22%2C%2260530141-1619364342%22%2C%2260541891-1619609287%22%2C%2257081613-1619616167%22%2C%2259053767-1620147541%22%2C%2261076445-1620202020%22%2C%2262164807-1620301637%22%2C%2220041059-1620758693%22%2C%2241445071-1620758717%22%2C%2233033023-1620758722%22%2C%2211413559-1620758725%22%2C%2249865955-1620758828%22%2C%2262860583-1620980751%22%2C%2261138175-1621234385%22%2C%2243248989-1621252866%22%2C%2257718577-1622190023%22%2C%2257550447-1622190034%22%2C%2257608373-1622190044%22%2C%2263169015-1622201727%22%2C%2263169151-1622201782%22%2C%2263169499-1622201783%22%2C%2263169551-1622201948%22%2C%2263170473-1622228354%22%2C%2262628061-1623747917%22%2C%2235826351-1623747919%22%2C%2263593625-1626265676%22%2C%2263969411-1626265753%22%2C%2259686393-1626539796%22%2C%2264397887-1627707826%22%2C%2257349879-1627730261%22%2C%2264563787-1628413019%22%2C%2264608799-1628964435%22%2C%2264910597-1629790218%22%2C%2264958809-1629970793%22%2C%2265266759-1631781112%22%2C%2265286145-1631791698%22%2C%2238763731-1632030996%22%2C%2223800858-1632031061%22%2C%2229761517-1632031077%22%2C%2265379407-1632145156%22%2C%2265379637-1632145302%22%2C%2265378687-1632145718%22%2C%2265379913-1632145787%22%2C%2265401981-1632232376%22%2C%2265403877-1632242072%22%2C%2265405785-1632248395%22%2C%2265408449-1632289614%22%2C%2229297141-1632290460%22%2C%2260169631-1632290469%22%2C%2210984616-1632290512%22%2C%2264561087-1632471435%22%2C%2265436107-1632498742%22%2C%2265436219-1632498752%22%2C%2265437969-1632499410%22%2C%2258553571-1632804041%22%2C%2265554077-1632910817%22%2C%2265554185-1632910895%22%2C%2265554323-1632910998%22%2C%2265554409-1632911054%22%2C%2265554479-1632911091%22%2C%2265556777-1632923951%22%2C%2265556595-1632923953%22%2C%2265556679-1632923952%22%2C%2265557267-1632924813%22%2C%2265557401-1632924817%22%2C%2265557513-1632924824%22%2C%2265558055-1632926151%22%2C%2265558435-1632926159%22%2C%2265555977-1632926734%22%2C%2265562135-1632938470%22%5D; session_token=f724a93c1a442aadPk15NWO3TyccV19C5MmAd3HqP_yMLKsLYxD5JBA7e07_jPTwbHEhZ3tz5sY-dv4IHDqT-T7psbYsaKLcY0Pf_sBuy5pnAogivEatPnlbchcPWfoS_8CsH_gMz55qRriJz_tvuYqxcaUFSflswR3fpkhvN8MDRWeUbvCdFrb1uS8VBUP1-tW49mAiLqvI9Ok7mGXgBCUZ8K2o89xno_zl-b1SQ2RMhCuFzJQZXS5tnlSd1-wMWgkVp11-PsNCQVSb6CIFv3khK1DgnNzjD0o85MvMr-oKUSRS1QJeoRBfcUHKd_5VY_0d7aIvn6qqp1sK3Kde77xA_g9FTWhbQyHHSGye3KdBUK-LLFH8AN7sev3iyfIIjODP609CajpXmZPnEf5N8YhpemLS3dxNSOk08qroPaWNiUPz1I4kRaxCXpV2A65a2PKbuLwkeTGERkG5tq_XYKQYC-csFHwe-AeIfO_FhYPCLg1KAv9K-QqAbIvN1rq56ASq9THnuC2tGzXok1SOcDFVpvHh7-6T3ChM7g%3D%3D'
            ]);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            if (strpos($html, "html5player.setVideoHLS('") !== false) {
                $m3u8 = Helper::get_string_between($html, "html5player.setVideoHLS('", "');");
                $curl_connection = curl_init($m3u8);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $data = curl_exec($curl_connection);
                curl_close($curl_connection);

                $array = explode('#EXT-X-STREAM-INF', $data);
                array_shift($array);

                $qualities = [];
                $m3u8_array = explode('/', $m3u8);
                array_pop($m3u8_array);
                $preset = implode('/', $m3u8_array).'/';
                foreach ($array as $item) {
                    $quality = Helper::get_string_between($item, 'NAME="', '"');
                    $source = $preset.trim(explode('NAME="'.$quality.'"', $item)[1]);
                    $qualities[str_replace('p', '', $quality)] = $source;
                }
                if (array_key_exists(1080, $qualities)) {
                   $video->sd = $qualities[1080];
                } elseif (array_key_exists(720, $qualities)) {
                    $video->sd = $qualities[720];
                } elseif (array_key_exists(480, $qualities)) {
                    $video->sd = $qualities[480];
                } elseif (array_key_exists(360, $qualities)) {
                    $video->sd = $qualities[360];
                } elseif (array_key_exists(250, $qualities)) {
                    $video->sd = $qualities[250];
                }

                if ($key == 'error') {
                    $temp = $video->foreign_sd;
                    $temp['xvideos'] = $video->foreign_sd['error'];
                    unset($temp['error']);
                    $video->foreign_sd = $temp;
                }

                $video->outsource = false;
                $video->save();
                Log::info('Xvideos update ID#'.$video->id.' success...');

            } else {
                if ($key != 'error') {
                    $temp = $video->foreign_sd;
                    $temp['error'] = $video->foreign_sd['xvideos'];
                    unset($temp['xvideos']);
                    $video->foreign_sd = $temp;
                    $video->save();
                }

                Log::info('Xvideos update ID#'.$video->id.' failed...');
            }

            if ($videos->last() != $video) {
                sleep(16);
            }
        }

        Log::info('Xvideos update ended...');
    }
}
