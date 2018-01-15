@extends('webed-theme::front._master')
@section('move')
 <div class="background_c index">
	<div class="box box1 transition">
		<div class="target ball1 fr move"></div>
		<div class="target ball3 fr move"></div>
		<div class="clear"></div>
	</div>
	<div class="box  box2 transition ">
		<div class="target capsule1 fl move"></div>
		<div class="target capsule2 fr move"></div>
		<div class="clear"></div>
	</div>
	<div class="box  box3  transition">
		<div class="target word tl_center">User feedback</div>
	</div>
</div>
<div class="before_c index">
	<div class="box box1 transition">
		<div class="target ball2 fr move"></div>
	</div>
</div>
@endsection
@section('content')
<div class="my_video pic_box">
	<img src="{{ asset('themes/news-tv/dist/img/video_temp.png') }}">
</div>
<!--<article class="user_feedback inner_continer">
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
</article>-->
<article class="user_feedback inner_continer">
	<h5 class="tl_center lazyc">medisum</h5>
	<h6 class="tl_center title lazyc">Efficacy and safrty&nbsp;事半功倍，安心之选</h6>
	<ul class="feedback_list">
		<li class="lazyc">
			<div class="head_pic pic_continer lazy_item"><img  src="{{ asset('themes/news-tv/dist/img/head_temp1.jpg') }}"/></div>
			<h6 class="tl_center lazy_item"><span>品牌故事</span></h6>
			<p class="tl_center lazy_item">
				medisum是由澳洲几位曾活跃在医药界，科技界，消费咨询界的女士联合创办的品牌。 来自不同的国家她们有着共同的特点：都是工作家庭两不误的成功职业女性和自豪全能母亲，她们爱人爱己，回报社会...怀着同样的信念，她们希望以关爱女性为基石，搭建一个安全有效，活力创新，稳步成长的健康品牌。

			</p>
		</li>
		<li class="lazyc">
			<div class="head_pic pic_continer lazy_item"><img src="{{ asset('themes/news-tv/dist/img/head_temp2.jpg') }}"/></div>
			<h6 class="tl_center lazy_item"><span>品牌理念</span></h6>
			<p class="tl_center lazy_item">
				每一个成分都精心挑选<br/>
				每一个过程都严格把关<br/>
				每一个组合都细心雕琢<br/>
				每一个产品都充满温暖<br/>
				medisum，一个懂得关怀的专业品牌
			</p>
		</li>
		<li class="lazyc">
			<div class="head_pic pic_continer lazy_item"><img src="{{ asset('themes/news-tv/dist/img/head_temp_3.jpg') }}"/></div>
			<h6 class="tl_center lazy_item"><span>品牌概述</span></h6>
			<p class="tl_center lazy_item">
				medisum是一个融合智慧与科技结合的澳洲创新品牌，致力于通过有意义 的创新为人们提供有效安全的保健健康方案，未雨绸缪，乐享人生
			</p>
		</li>
	</ul>
</article>
@endsection
