@extends('webed-theme::front._master')
@section('move')
 <div class="background_c contact">
	<div class="box box1 transition">
		<div class="target ball1 fr move"></div>
		<div class="clear"></div>
	</div>
	<div class="box  box2 transition ">
		<div class="target capsule1 fl move"></div>
		<div class="target capsule2 fr move"></div>
		<div class="target triangle1 fr move"></div>
		<div class="clear"></div>
	</div>
</div>
<div class="before_c contact">
	<div class="box box1 transition">
		<div class="target ball2 fr move"></div>
	</div>
	<div class="box box2 transition">
		<div class="target triangle2 fr move"></div>
	</div>
</div>
@endsection
@section('content')
    <div class="info_form  inner_continer lazyc">
    	<div class="mobile_c">
    		<h2 class="contact_title tl_center lazy_item">Contact</h2>
    		<h4 class="contact_title2 tl_center lazy_item">Enquires&Feedback</h4>
    		<div class="mobile_clear"></div>
    	</div>
    	<form id="info lazy_item" onsubmit="return false;">
    		<ul>
    			<li><input type="text" placeholder="First Name" name="fname" class="fl tinput"/><input type="text" placeholder="Last Name" name="lname" class="fr tinput"><div class="clear"></div></li>
    			<li><input type="email" placeholder="Email" name="email" class="fl tinput"/><input type="number" placeholder="Phone" name="phone" class="fr tinput"/><div class="clear"></div></li>
    			<li>
    				<textarea></textarea>
    			</li>
    			<li>
    				<input type="submit" class="fr sub"  value="send"/>
    				<div class="clear"></div>
    			</li>
    		</ul>
    	</form>
    </div>
    <div class="info_list inner_continer lazyc">
    	<h2 class="contact_title tl_center lazy_item">More</h2>
    	<ul class="lazy_item">
    		<li class="fl item">
    			<div class="info_logo phone"></div>
    			<h4 class="contact_title2  tl_center">Phone</h4>
    			<p class="tl_center">(010)3030333</p>
    		</li>
    		<li class="fl item">
    			<div class="info_logo  fax"></div>
    			<h4 class="contact_title2 tl_center">Fax</h4>
    			<p class="tl_center">(011)222-8888</p>
    		</li>
    		<li class="fl item">
    			<div class="info_logo email"></div>
    			<h4 class="contact_title2 tl_center">Email</h4>
    			<p class="tl_center">jsj@163.com</p>
    		</li>
    		<li class="fl item">
    			<div class="info_logo qq"></div>
    			<h4 class="contact_title2 tl_center">QQ</h4>
    			<p class="tl_center">123698547</p>
    		</li>
    		<li class="fl item">
    			<div class="info_logo wechat"></div>
    			<h4 class="contact_title2 tl_center">Wechat</h4>
    			<p class="tl_center">1564945116</p>
    		</li>
    		<li class="worktime tl_center fl">
    			<span>Our worktime 9:00~12:00 13:00~18:00</span>
    		</li>
    		<li class="clear"></li>
    	</ul>
    	
    </div>
    <div class="map lazyc">
    	<h2 class="contact_title tl_center">ADDRESS</h2>
    	<div class="map_content">
    		<div class="iframe_temp"></div>
    		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3147.0010944963196!2d145.14102531478983!3d-37.93040487973131!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad614d60795cda1%3A0xf1674aca7fb3ded8!2sd2%2F2A+Westall+Rd%2C+Springvale+VIC+3171!5e0!3m2!1sen!2sau!4v1515379729430" height="600" frameborder="0" style="border:0;width:100%;" allowfullscreen></iframe>
    </div>
@endsection
