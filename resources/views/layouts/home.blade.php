@extends('layouts.app')

@section('nav')
	@include('nav.home')
@endsection

@section('content')

<div class="nav-bottom-padding">
	<div class="hidden-xs" style="position: relative;">
		<div id="main-nav-home" style="z-index: 10000 !important; position: absolute;">
		  @include('nav.main-content')
		</div>
		<script>
			var targetOffset = $("#main-nav-home").offset().top;
			var $window = $(window).scroll(function(){
			    if ( $window.scrollTop() > targetOffset ) {   
			      $("#main-nav-home").css({"position":"fixed", 'background-color':'#141414'});
			    } else {
			      $("#main-nav-home").css({"position":"absolute", 'background-color':'transparent'});
			    }
			});
		</script>

		<div style="position: relative;">
			<img style="width: 100%; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0.3)));" src="https://vdownload.hembed.com/image/icon/card_doujin_background.jpg?secure=sJRJ4-aVOQw4IVZasq7YZw==,4853041705" alt="{{ $random->title }}">
			<img style="width: 100%; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0.3))); position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-position: center 0px; object-fit: cover;" src="{{ $random->thumbH()}}" alt="{{ $random->title }}">
	    </div>
		<div id="home-banner-wrapper" style="position: absolute; left: 4%; color: white">
			<h3 style="font-weight: bold"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
			<h1 style="margin: 0; font-weight: bold;">{{ $random->title }}</h1>
			<h4 class="hidden-xs">{{ str_replace(' [中文字幕]', '', $random->translations['JP']) }} • 中文字幕 • {{ $random->caption }}</h4>
			<a href="{{ route('video.watch') }}?v={{ $random->id }}" style="display: inline-block; padding: 10px 30px 6px 20px; margin-top: -8px; margin-bottom: -10px" class="hover-opacity-all home-banner-btn home-banner-play-btn play-btn home-card-popunder"><span style="vertical-align: middle; font-size: 2em; margin-top: -4px; padding-right: 5px" class="material-icons">play_arrow</span>播放</a>
			&nbsp;
			<a href="{{ route('video.watch') }}?v={{ $random->id }}" class="hover-opacity-all home-banner-btn home-banner-info-btn home-card-popunder"><span style="vertical-align: middle; font-size: 1.7em; margin-top: -2px; padding-right: 7px" class="material-icons">info</span>更多資訊</a>
		</div>
	</div>

	<div class="hidden-sm hidden-md hidden-lg" style="position: relative;">
		<div style="position: relative;">
			<img style="/* width: 116%; */ width: 110%;" src="https://vdownload.hembed.com/image/icon/home_poster_background.jpg?secure=V9I3grqYWBcEVFVq8VMswA==,4853041877">
			<img style="position: absolute; top: 0; left: 0; width: 10000%; height: 100%; object-position: center 0px; object-fit: cover; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0))); -webkit-filter: brightness(50%); filter: brightness(50%); user-drag: none; -webkit-user-drag: none; user-select: none; -moz-user-select: none; -webkit-user-select: none; -ms-user-select: none;" src="{{ $random->cover }}">

			<div style="position: absolute; top: 110px; left: 50%; -webkit-transform: translateX(-50%); transform: translateX(-50%); width: 88%; height: 70%;">
				<div style="border: 1px solid rgba(255,255,255,.1); border-radius: 10px; height: 100%; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
					<img style="width: 100%; height: 100%; object-fit: cover; object-position: center 0px; border-radius: 10px; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));" src="{{ $random->cover }}">
				</div>
				<div style="position: absolute; left: 50%; -webkit-transform: translateX(-50%); transform: translateX(-50%); width: 96%; bottom: 3.5%; text-align: center; color: white">
					<h3 style="font-weight: bold; font-size: 16px;"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
					<h1 style="font-size: 24px; font-weight: bold; margin: 0; line-height: 35px; margin-top: -2px; margin-bottom: -2px">{{ $random->title }}</h1>
					<h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 16px; font-size: 11px; width: 92%; margin-left: 4%;">{{ str_replace(' [中文字幕]', '', $random->translations['JP']) }} • 中文字幕 • {{ $random->caption }}</h4>
					<div style="margin-top: 15px; width: 100%">
						<a href="{{ route('video.watch') }}?v={{ $random->id }}" class="hover-opacity-all home-banner-btn home-banner-play-btn play-btn home-card-popunder" style="cursor: pointer; font-size: 14px; text-decoration: none; color: black;">
							<div style="display: inline-block; margin-top: 5px; width: 45%; margin-right: 5px; background-color: white; padding-top: 7px; padding-bottom: 5px; border-radius: 5px;">
								<span style="vertical-align: middle; font-size: 2em; margin-top: -3px; padding-right: 3px" class="material-icons">play_arrow</span>播放
							</div>
						</a>
						<a href="{{ route('video.watch') }}?v={{ $random->id }}" class="hover-opacity-all home-banner-btn home-banner-info-btn home-card-popunder" style="cursor: pointer; font-size: 14px; text-decoration: none; color: #e2e2e2;">
							<div style="display: inline-block; margin-top: 5px; width: 45%; background-color: rgba(46, 46, 46, 0.75); margin-left: 5px; padding-top: 8px; padding-bottom: 7px; border-radius: 5px;">
								<span style="vertical-align: middle; font-size: 1.66em; margin-top: -2px; padding-right: 5px" class="material-icons">info</span>更多資訊
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- <div class="hidden-sm hidden-md hidden-lg" style="position: relative;">
		<div style="position: relative;">
			<img style="width: 100%;" src="https://vdownload.hembed.com/image/icon/home_poster_background.jpg?secure=V9I3grqYWBcEVFVq8VMswA==,4853041877">
			<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-position: center 0px; object-fit: cover; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));" src="{{ $random->cover }}">
	    </div>
		<div style="position: absolute; left: 50%; -webkit-transform: translateX(-50%); transform: translateX(-50%); width: 96%; bottom: 14%; text-align: center; color: white">
			<h3 style="font-weight: bold; font-size: 20px;"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
			<h1 style="font-size: 28px; font-weight: bold; margin: 0; line-height: 35px; margin-top: -2px; margin-bottom: -2px">{{ $random->title }}</h1>
			<h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 16px; font-size: 12px; width: 92%; margin-left: 4%;">{{ str_replace(' [中文字幕]', '', $random->translations['JP']) }} • 中文字幕 • {{ $random->caption }}</h4>
			<div style="margin-top: 15px; width: 100%">
				<div style="display: inline-block; margin-top: 5px;">
					<a href="{{ route('video.watch') }}?v={{ $random->id }}" class="hover-opacity-all home-banner-btn home-banner-play-btn play-btn" target="_blank" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: white; padding: 8px 22px 8px 12px; color: black;"><span style="vertical-align: middle; font-size: 2em; margin-top: -3px; padding-right: 3px" class="material-icons">play_arrow</span>播放</a>
				</div>
				<div style="display: inline-block; margin-top: 5px; padding-left: 2px;">
					<a href="{{ route('video.watch') }}?v={{ $random->id }}" class="hover-opacity-all home-banner-btn home-banner-info-btn" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: rgba(109, 109, 110, 0.7); padding: 8px 21px 8px 17px; color: white;"><span style="vertical-align: middle; font-size: 1.66em; margin-top: -3px; padding-right: 4px" class="material-icons">info</span>更多資訊</a>
				</div>
			</div>
		</div>
	</div> -->

	<div id="home-rows-wrapper" style="position: relative;">
		@include('layouts.card-wrapper', ['title' => '最新裏番', 'videos' => $最新裏番, 'link' => route('home.search').'?genre=裏番'])
		@include('layouts.card-wrapper-doujin', ['title' => '最新上市', 'videos' => $最新上市, 'link' => route('home.search').'?sort=最新上市'])
		@include('layouts.card-wrapper-doujin', ['title' => '最新上傳', 'videos' => $最新上傳, 'link' => route('home.search').'?sort=最新上傳'])
		@include('layouts.card-wrapper-doujin', ['title' => '中文字幕', 'videos' => $中文字幕, 'link' => route('home.search').'?tags%5B%5D=中文字幕&sort=最新上傳'])
		@include('layouts.card-wrapper-doujin', ['title' => '他們在看', 'videos' => $他們在看, 'link' => route('home.search').'?sort=他們在看'])

		<div>
			@include('ads.home-banner-exoclick', ['desktop_home_1' => '5058640', 'tablet_home_1' => '5058646', 'mobile_home_1' => '5058646'])
		</div>

		@include('layouts.card-wrapper', ['title' => '泡麵番', 'videos' => $泡麵番, 'link' => route('home.search').'?genre=泡麵番'])
		@include('layouts.card-wrapper-doujin', ['title' => 'Motion Anime', 'videos' => $Motion_Anime, 'link' => route('home.search').'?genre=Motion+Anime'])
		@include('layouts.card-wrapper-doujin', ['title' => '3D動畫', 'videos' => $SD動畫, 'link' => route('home.search').'?genre=3D動畫'])
		@include('layouts.card-wrapper-doujin', ['title' => '同人作品', 'videos' => $同人作品, 'link' => route('home.search').'?genre=同人作品'])
		@include('layouts.card-wrapper-doujin', ['title' => 'Cosplay', 'videos' => $Cosplay, 'link' => route('home.search').'?genre=Cosplay'])

		<div>
			@include('ads.home-banner-juicyads', ['tablet_home_2' => '5058646'])
		</div>

		@include('layouts.card-wrapper', ['title' => '新番預告', 'videos' => $新番預告, 'link' => '/previews/'.Carbon\Carbon::now()->format('Ym')])
		<div class="artist-row-desktop-margin">
			@include('layouts.card-wrapper-artist', ['title' => '新加入作者', 'artists' => $新加入作者, 'link' => route('home.search').'?type=artist&sort=加入日期'])
		</div>
		@include('layouts.card-wrapper-doujin', ['title' => '本日排行', 'videos' => $本日排行, 'link' => route('home.search').'?sort=本日排行'])
		@include('layouts.card-wrapper-doujin', ['title' => '本月排行', 'videos' => $本月排行, 'link' => route('home.search').'?sort=本月排行'])
		@include('layouts.card-wrapper-tag', ['title' => '影片標籤', 'videos' => $影片標籤, 'link' => route('home.search')])
		
	</div>

	<div>
		@include('ads.home-banner-square', ['desktop_home_3' => '5058640', 'tablet_home_3' => '5058646', 'mobile_home_3' => '5058646'])
	</div>
</div>

@include('layouts.footer')

@include('layouts.nav-bottom')

<script type="application/javascript">
(function() {

    //version 1.0.0

    var adConfig = {
    "ads_host": "a.pemsrv.com",
    "syndication_host": "s.pemsrv.com",
    "idzone": 5094160,
    "popup_fallback": false,
    "popup_force": false,
    "chrome_enabled": true,
    "new_tab": false,
    "frequency_period": 5,
    "frequency_count": 1,
    "trigger_method": 2,
    "trigger_class": "home-card-popunder",
    "trigger_delay": 0,
    "only_inline": false
};

if(!window.document.querySelectorAll){document.querySelectorAll=document.body.querySelectorAll=Object.querySelectorAll=function querySelectorAllPolyfill(r,c,i,j,a){var d=document,s=d.createStyleSheet();a=d.all;c=[];r=r.replace(/\[for\b/gi,"[htmlFor").split(",");for(i=r.length;i--;){s.addRule(r[i],"k:v");for(j=a.length;j--;){a[j].currentStyle.k&&c.push(a[j])}s.removeRule(0)}return c}}var popMagic={version:1,cookie_name:"",url:"",config:{},open_count:0,top:null,browser:null,venor_loaded:false,venor:false,configTpl:{ads_host:"",syndication_host:"",idzone:"",frequency_period:720,frequency_count:1,trigger_method:1,trigger_class:"",popup_force:false,popup_fallback:false,chrome_enabled:true,new_tab:false,cat:"",tags:"",el:"",sub:"",sub2:"",sub3:"",only_inline:false,trigger_delay:0,cookieconsent:true},init:function(config){if(typeof config.idzone==="undefined"||!config.idzone){return}if(typeof config["customTargeting"]==="undefined"){config["customTargeting"]=[]}window["customTargeting"]=config["customTargeting"]||null;var customTargeting=Object.keys(config["customTargeting"]).filter(function(c){return c.search("ex_")>=0});if(customTargeting.length){customTargeting.forEach(function(ct){return this.configTpl[ct]=null}.bind(this))}for(var key in this.configTpl){if(!Object.prototype.hasOwnProperty.call(this.configTpl,key)){continue}if(typeof config[key]!=="undefined"){this.config[key]=config[key]}else{this.config[key]=this.configTpl[key]}}if(typeof this.config.idzone==="undefined"||this.config.idzone===""){return}if(this.config.only_inline!==true){this.loadHosted()}this.addEventToElement(window,"load",this.preparePop)},getCountFromCookie:function(){if(!this.config.cookieconsent){return 0}var shownCookie=popMagic.getCookie(popMagic.cookie_name);var ctr=typeof shownCookie==="undefined"?0:parseInt(shownCookie);if(isNaN(ctr)){ctr=0}return ctr},getLastOpenedTimeFromCookie:function(){var shownCookie=popMagic.getCookie(popMagic.cookie_name);var delay=null;if(typeof shownCookie!=="undefined"){var value=shownCookie.split(";")[1];delay=value>0?parseInt(value):0}if(isNaN(delay)){delay=null}return delay},shouldShow:function(){if(popMagic.open_count>=popMagic.config.frequency_count){return false}var ctr=popMagic.getCountFromCookie();const last_opened_time=popMagic.getLastOpenedTimeFromCookie();const current_time=Math.floor(Date.now()/1e3);const maximumDelayTime=last_opened_time+popMagic.config.trigger_delay;if(last_opened_time&&maximumDelayTime>current_time){return false}popMagic.open_count=ctr;return!(ctr>=popMagic.config.frequency_count)},venorShouldShow:function(){return popMagic.venor_loaded&&popMagic.venor==="0"},setAsOpened:function(){var new_ctr=1;if(popMagic.open_count!==0){new_ctr=popMagic.open_count+1}else{new_ctr=popMagic.getCountFromCookie()+1}const last_opened_time=Math.floor(Date.now()/1e3);if(popMagic.config.cookieconsent){popMagic.setCookie(popMagic.cookie_name,`${new_ctr};${last_opened_time}`,popMagic.config.frequency_period)}},loadHosted:function(){var hostedScript=document.createElement("script");hostedScript.type="application/javascript";hostedScript.async=true;hostedScript.src="//"+this.config.ads_host+"/popunder1000.js";hostedScript.id="popmagicldr";for(var key in this.config){if(!Object.prototype.hasOwnProperty.call(this.config,key)){continue}if(key==="ads_host"||key==="syndication_host"){continue}hostedScript.setAttribute("data-exo-"+key,this.config[key])}var insertAnchor=document.getElementsByTagName("body").item(0);if(insertAnchor.firstChild){insertAnchor.insertBefore(hostedScript,insertAnchor.firstChild)}else{insertAnchor.appendChild(hostedScript)}},preparePop:function(){if(typeof exoJsPop101==="object"&&Object.prototype.hasOwnProperty.call(exoJsPop101,"add")){return}popMagic.top=self;if(popMagic.top!==self){try{if(top.document.location.toString()){popMagic.top=top}}catch(err){}}popMagic.cookie_name="zone-cap-"+popMagic.config.idzone;if(popMagic.shouldShow()){var xmlhttp=new XMLHttpRequest;xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==XMLHttpRequest.DONE){popMagic.venor_loaded=true;if(xmlhttp.status==200){popMagic.venor=xmlhttp.responseText}}};var protocol=document.location.protocol!=="https:"&&document.location.protocol!=="http:"?"https:":document.location.protocol;xmlhttp.open("GET",protocol+"//"+popMagic.config.syndication_host+"/venor.php",true);try{xmlhttp.send()}catch(error){popMagic.venor_loaded=true}}popMagic.buildUrl();popMagic.browser=popMagic.browserDetector.detectBrowser(navigator.userAgent);if(!popMagic.config.chrome_enabled&&(popMagic.browser.name==="chrome"||popMagic.browser.name==="crios")){return}var popMethod=popMagic.getPopMethod(popMagic.browser);popMagic.addEvent("click",popMethod)},getPopMethod:function(browserInfo){if(popMagic.config.popup_force){return popMagic.methods.popup}if(popMagic.config.popup_fallback&&browserInfo.name==="chrome"&&browserInfo.version>=68&&!browserInfo.isMobile){return popMagic.methods.popup}if(browserInfo.isMobile){return popMagic.methods.default}if(browserInfo.name==="chrome"){return popMagic.methods.chromeTab}return popMagic.methods.default},buildUrl:function(){var protocol=document.location.protocol!=="https:"&&document.location.protocol!=="http:"?"https:":document.location.protocol;var p=top===self?document.URL:document.referrer;var script_info={type:"inline",name:"popMagic",ver:this.version};var encodeScriptInfo=function(script_info){var result=script_info["type"]+"|"+script_info["name"]+"|"+script_info["ver"];return encodeURIComponent(btoa(result))};var customTargetingParams="";if(customTargeting&&Object.keys(customTargeting).length){var customTargetingKeys=typeof customTargeting==="object"?Object.keys(customTargeting):customTargeting;var value;customTargetingKeys.forEach(function(key){if(typeof customTargeting==="object"){value=customTargeting[key]}else if(Array.isArray(customTargeting)){value=scriptEl.getAttribute(key)}var keyWithoutExoPrefix=key.replace("data-exo-","");customTargetingParams+=`&${keyWithoutExoPrefix}=${value}`})}this.url=protocol+"//"+this.config.syndication_host+"/splash.php"+"?cat="+this.config.cat+"&idzone="+this.config.idzone+"&type=8"+"&p="+encodeURIComponent(p)+"&sub="+this.config.sub+(this.config.sub2!==""?"&sub2="+this.config.sub2:"")+(this.config.sub3!==""?"&sub3="+this.config.sub3:"")+"&block=1"+"&el="+this.config.el+"&tags="+this.config.tags+"&cookieconsent="+this.config.cookieconsent+"&scr_info="+encodeScriptInfo(script_info)+customTargetingParams},addEventToElement:function(obj,type,fn){if(obj.addEventListener){obj.addEventListener(type,fn,false)}else if(obj.attachEvent){obj["e"+type+fn]=fn;obj[type+fn]=function(){obj["e"+type+fn](window.event)};obj.attachEvent("on"+type,obj[type+fn])}else{obj["on"+type]=obj["e"+type+fn]}},addEvent:function(type,fn){var targetElements;if(popMagic.config.trigger_method=="3"){targetElements=document.querySelectorAll("a");for(i=0;i<targetElements.length;i++){popMagic.addEventToElement(targetElements[i],type,fn)}return}if(popMagic.config.trigger_method=="2"&&popMagic.config.trigger_method!=""){var trigger_classes;var trigger_classes_final=[];if(popMagic.config.trigger_class.indexOf(",")===-1){trigger_classes=popMagic.config.trigger_class.split(" ")}else{var trimmed_trigger_classes=popMagic.config.trigger_class.replace(/\s/g,"");trigger_classes=trimmed_trigger_classes.split(",")}for(var i=0;i<trigger_classes.length;i++){if(trigger_classes[i]!==""){trigger_classes_final.push("."+trigger_classes[i])}}targetElements=document.querySelectorAll(trigger_classes_final.join(", "));for(i=0;i<targetElements.length;i++){popMagic.addEventToElement(targetElements[i],type,fn)}return}popMagic.addEventToElement(document,type,fn)},setCookie:function(name,value,ttl_minutes){if(!this.config.cookieconsent){return false}ttl_minutes=parseInt(ttl_minutes,10);var now_date=new Date;now_date.setMinutes(now_date.getMinutes()+parseInt(ttl_minutes));var c_value=encodeURIComponent(value)+"; expires="+now_date.toUTCString()+"; path=/";document.cookie=name+"="+c_value},getCookie:function(name){if(!this.config.cookieconsent){return false}var i,x,y,cookiesArray=document.cookie.split(";");for(i=0;i<cookiesArray.length;i++){x=cookiesArray[i].substr(0,cookiesArray[i].indexOf("="));y=cookiesArray[i].substr(cookiesArray[i].indexOf("=")+1);x=x.replace(/^\s+|\s+$/g,"");if(x===name){return decodeURIComponent(y)}}},randStr:function(length,possibleChars){var text="";var possible=possibleChars||"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";for(var i=0;i<length;i++){text+=possible.charAt(Math.floor(Math.random()*possible.length))}return text},isValidUserEvent:function(event){if("isTrusted"in event&&event.isTrusted&&popMagic.browser.name!=="ie"&&popMagic.browser.name!=="safari"){return true}else{return event.screenX!=0&&event.screenY!=0}},isValidHref:function(href){if(typeof href==="undefined"||href==""){return false}var empty_ref=/\s?javascript\s?:/i;return!empty_ref.test(href)},findLinkToOpen:function(clickedElement){var target=clickedElement;var location=false;try{var breakCtr=0;while(breakCtr<20&&!target.getAttribute("href")&&target!==document&&target.nodeName.toLowerCase()!=="html"){target=target.parentNode;breakCtr++}var elementTargetAttr=target.getAttribute("target");if(!elementTargetAttr||elementTargetAttr.indexOf("_blank")===-1){location=target.getAttribute("href")}}catch(err){}if(!popMagic.isValidHref(location)){location=false}return location||window.location.href},getPuId:function(){return"ok_"+Math.floor(89999999*Math.random()+1e7)},browserDetector:{browserDefinitions:[["firefox",/Firefox\/([0-9.]+)(?:\s|$)/],["opera",/Opera\/([0-9.]+)(?:\s|$)/],["opera",/OPR\/([0-9.]+)(:?\s|$)$/],["edge",/Edg(?:e|)\/([0-9._]+)/],["ie",/Trident\/7\.0.*rv:([0-9.]+)\).*Gecko$/],["ie",/MSIE\s([0-9.]+);.*Trident\/[4-7].0/],["ie",/MSIE\s(7\.0)/],["safari",/Version\/([0-9._]+).*Safari/],["chrome",/(?!Chrom.*Edg(?:e|))Chrom(?:e|ium)\/([0-9.]+)(:?\s|$)/],["chrome",/(?!Chrom.*OPR)Chrom(?:e|ium)\/([0-9.]+)(:?\s|$)/],["bb10",/BB10;\sTouch.*Version\/([0-9.]+)/],["android",/Android\s([0-9.]+)/],["ios",/Version\/([0-9._]+).*Mobile.*Safari.*/],["yandexbrowser",/YaBrowser\/([0-9._]+)/],["crios",/CriOS\/([0-9.]+)(:?\s|$)/]],detectBrowser:function(userAgent){var isMobile=userAgent.match(/Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile|WebOS|Windows Phone/i);for(var i in this.browserDefinitions){var definition=this.browserDefinitions[i];if(definition[1].test(userAgent)){var match=definition[1].exec(userAgent);var version=match&&match[1].split(/[._]/).slice(0,3);var versionTails=Array.prototype.slice.call(version,1).join("")||"0";if(version&&version.length<3){Array.prototype.push.apply(version,version.length===1?[0,0]:[0])}return{name:definition[0],version:version.join("."),versionNumber:parseFloat(version[0]+"."+versionTails),isMobile:isMobile}}}return{name:"other",version:"1.0",versionNumber:1,isMobile:isMobile}}},methods:{default:function(triggeredEvent){if(!popMagic.shouldShow()||!popMagic.venorShouldShow()||!popMagic.isValidUserEvent(triggeredEvent))return true;var clickedElement=triggeredEvent.target||triggeredEvent.srcElement;var href=popMagic.findLinkToOpen(clickedElement);window.open(href,"_blank");popMagic.setAsOpened();popMagic.top.document.location=popMagic.url;if(typeof triggeredEvent.preventDefault!=="undefined"){triggeredEvent.preventDefault();triggeredEvent.stopPropagation()}return true},chromeTab:function(event){if(!popMagic.shouldShow()||!popMagic.venorShouldShow()||!popMagic.isValidUserEvent(event))return true;if(typeof event.preventDefault!=="undefined"){event.preventDefault();event.stopPropagation()}else{return true}var a=top.window.document.createElement("a");var target=event.target||event.srcElement;a.href=popMagic.findLinkToOpen(target);document.getElementsByTagName("body")[0].appendChild(a);var e=new MouseEvent("click",{bubbles:true,cancelable:true,view:window,screenX:0,screenY:0,clientX:0,clientY:0,ctrlKey:true,altKey:false,shiftKey:false,metaKey:true,button:0});e.preventDefault=undefined;a.dispatchEvent(e);a.parentNode.removeChild(a);window.open(popMagic.url,"_self");popMagic.setAsOpened()},popup:function(triggeredEvent){if(!popMagic.shouldShow()||!popMagic.venorShouldShow()||!popMagic.isValidUserEvent(triggeredEvent))return true;var winOptions="";if(popMagic.config.popup_fallback&&!popMagic.config.popup_force){var height=Math.max(Math.round(window.innerHeight*.8),300);var width=Math.max(Math.round(window.innerWidth*.7),300);var top=window.screenY+100;var left=window.screenX+100;winOptions="menubar=1,resizable=1,width="+width+",height="+height+",top="+top+",left="+left}var prePopUrl=document.location.href;var popWin=window.open(prePopUrl,popMagic.getPuId(),winOptions);setTimeout(function(){popWin.location.href=popMagic.url},200);popMagic.setAsOpened();if(typeof triggeredEvent.preventDefault!=="undefined"){triggeredEvent.preventDefault();triggeredEvent.stopPropagation()}}}};    popMagic.init(adConfig);
})();


</script>

@endsection