@component('mail::message')
侵犯版權通知：

<br>

<div><span style="font-weight: 600">問題為何？：</span>{{ $request->copyrightReason }}</div>
<div><span style="font-weight: 600">侵犯版權 - 哪些人會受影響？：</span>{{ $request->copyrightStakeholders }}</div>
<div><span style="font-weight: 600">將移除之疑遭侵權影片的 URL：</span>{{ $request->copyrightURL }}</div>
<div><span style="font-weight: 600">描述您認為遭到侵權的作品：</span>{{ $request->copyrightSelect }}</div>
<div><span style="font-weight: 600">版權擁有者名稱 (公司名稱)：</span>{{ $request->copyrightCompanyName }}</div>
<div><span style="font-weight: 600">您的頭銜或職稱 (您提出此投訴的權限為何)：</span>{{ $request->copyrightUserOccupation }}</div>
<div><span style="font-weight: 600">主要電子郵件地址：</span>{{ $request->copyrightUserEmail }}</div>
<div><span style="font-weight: 600">您的法定全名 (姓名，非公司名稱)：</span>{{ $request->copyrightUserName }}</div>
<div><span style="font-weight: 600">街名：</span>{{ $request->copyrightUserStreet }}</div>
<div><span style="font-weight: 600">城市：</span>{{ $request->copyrightUserCity }}</div>
<div><span style="font-weight: 600">州 / 省：</span>{{ $request->copyrightUserRegion }}</div>
<div><span style="font-weight: 600">郵遞區號：</span>{{ $request->copyrightUserCode }}</div>
<div><span style="font-weight: 600">國家 / 地區：</span>{{ $request->copyrightUserCountry }}</div>
<div><span style="font-weight: 600">行動電話：</span>{{ $request->copyrightUserMobile }}</div>
<div><span style="font-weight: 600">簽署</span>{{ $request->copyrightUserSignature }}</div>

@component('mail::button', ['url' => '{{ route("video.watch") }}?v={{ $video->id }}'])
<span style="font-size: 15px">LaughSeeJapan</span>
@endcomponent

Thanks for using LaughSeeJapan,<br>
{{ config('app.name') }}
@endcomponent