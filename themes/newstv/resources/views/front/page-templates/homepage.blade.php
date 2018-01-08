@extends('webed-theme::front._master')
@section('content')
<div class="my_video pic_box">
	<img src="{{ asset('themes/news-tv/dist/img/video_temp.png') }}">
</div>
<article class="user_feedback inner_continer">
	<h5 class="tl_center lazyc">User Feedback</h5>
	<h6 class="tl_center title lazyc">Curabitur mi lacus,laoreet sit amet tortor sit amet,molestie ult ricesenim oreet sit amet toror sie tmet </h6>
	<ul class="feedback_list">
		<li class="lazyc">
			<div class="head_pic pic_continer lazy_item"><img  src="{{ asset('themes/news-tv/dist/img/head_temp1.jpg') }}"/></div>
			<h6 class="tl_center lazy_item"><span class="pointer transition">MARSHA</span>&nbsp;|&nbsp;<span>STRICNGSVILLE</span></h6>
			<p class="tl_center lazy_item">
				Curabitur mi lacus ,laoreet sit amet toror amet,mlerite ultricle enime .Ccurabiter mi lacus ,laoreet sit amet ,mloreet ultrics enime.curabites mi lacus,moleries yltrics enim tolit
			</p>
		</li>
		<li class="lazyc">
			<div class="head_pic pic_continer lazy_item"><img src="{{ asset('themes/news-tv/dist/img/head_temp2.jpg') }}"/></div>
			<h6 class="tl_center lazy_item"><span class="pointer transition">MARSHA</span>&nbsp;|&nbsp;<span>STRICNGSVILLE</span></h6>
			<p class="tl_center lazy_item">
				Curabitur mi lacus ,laoreet sit amet toror amet,mlerite ultricle enime .Ccurabiter mi lacus ,laoreet sit amet ,mloreet ultrics enime.curabites mi lacus,moleries yltrics enim tolit
			</p>
		</li>
		<li class="lazyc">
			<div class="head_pic pic_continer lazy_item"><img src="{{ asset('themes/news-tv/dist/img/head_temp_3.jpg') }}"/></div>
			<h6 class="tl_center lazy_item"><span class="pointer transition">MARSHA</span>&nbsp;|&nbsp;<span>STRICNGSVILLE</span></h6>
			<p class="tl_center lazy_item">
				Curabitur mi lacus ,laoreet sit amet toror amet,mlerite ultricle enime .Ccurabiter mi lacus ,laoreet sit amet ,mloreet ultrics enime.curabites mi lacus,moleries yltrics enim tolit
			</p>
		</li>
	</ul>
</article>
@endsection
