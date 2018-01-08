@extends('webed-theme::front._master')
@section('move')
 <!--<div class="background_c contact">
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
</div>-->
@endsection
@section('content')
    <div class="info_form  inner_continer">
    	<h2 class="contact_title tl_center">Contact</h2>
    	<h4 class="contact_title2 tl_center">Enquires&nbsp;& &nbsp;Feedback</h4>
    	<form id="info">
    		<ul>
    			<li><input type="text" placeholder="First Name" name="fname" class="fl tinput"/><input type="text" placeholder="Last Name" name="lname" class="fr tinput"><div class="clear"></div></li>
    			<li><input type="email" placeholder="Email" name="email" class="fl tinput"/><input type="number" placeholder="Phone" name="phone" class="fr tinput"/><div class="clear"></div></li>
    			<li>
    				<textarea></textarea>
    			</li>
    			<li><input type="submit" class="fr sub"  value="send"/></li>
    		</ul>
    	</form>
    </div>
    <!--<div class="info_list inner_continer">
    	<h2 class="contact_title tl_center">More</h2>
    	<ul>
    		<li class="fl item">
    			<div class="info_logo"></div>
    			<h4 class="contact_title2"></h4>
    			<p></p>
    		</li>
    		<li class="fl item">
    			<div class="info_logo"></div>
    			<h4 class="contact_title2"></h4>
    			<p></p>
    		</li>
    		<li class="fl item">
    			<div class="info_logo"></div>
    			<h4 class="contact_title2"></h4>
    			<p></p>
    		</li>
    		<li class="fl item">
    			<div class="info_logo"></div>
    			<h4 class="contact_title2"></h4>
    			<p></p>
    		</li>
    		<li class="fl item">
    			<div class="info_logo"></div>
    			<h4 class="contact_title2"></h4>
    			<p></p>
    		</li>
    		<li class="clear"></li>
    	</ul>
    </div>
    <div class="map">
    	<h2 class="contact_title tl_center">ADDRESS</h2>
    	<div class="top_mask map_mask"></div>
    	<div class="left_mask map_mask"></div>
    	<div class="right_mask map_mask"></div>
    	<div class="bottom_mask map_mask"></div>
    	<div class="location">D2/2A Westall Road, Springvale, VIC, 3171</div>
    	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3147.0010944963196!2d145.14102531478983!3d-37.93040487973131!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad614d60795cda1%3A0xf1674aca7fb3ded8!2sd2%2F2A+Westall+Rd%2C+Springvale+VIC+3171!5e0!3m2!1sen!2sau!4v1515379729430" width="800" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>-->
@endsection
