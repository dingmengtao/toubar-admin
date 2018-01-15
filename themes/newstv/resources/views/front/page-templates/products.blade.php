@extends('webed-theme::front._master_free')
@section('move')
 <div class="background_c product">
	<div class="box box1 transition">
		<div class="target ball3 fr move"></div>
		<div class="target ball1 fr move"></div>
		<!--<div class="target ball2 fr move"></div>-->
		<div class="clear"></div>
	</div>
	<div class="box  box2 transition ">
		<div class="target capsule1 fl move"></div>
		<div class="target capsule2 fr move"></div>
		<div class="clear"></div>
	</div>
</div>
<div class="before_c product">
	<div class="box box1 transition">
		<div class="target ball2 fr move"></div>
	</div>
</div>
@endsection
@section('content')
<div class="product_intro">
	<div class="intro_pic"><div class="pic"></div></div>
	<div class="intro_content ">
		<div class="content_left content_word">
			<h3>Trim Fat Remover</h3>
			<p>Lorem ipsum dolor sit amet, consectetur 
adipiscing elit. Aenean euismod bibendum
laoreet. Proin gravida dolor sit amet lacus 
accumsan et viverra justo commodo.</p>
		</div>
		<div class="pic_temp">
			
		</div>
		<div class="content_bottom">
			<h4 >RRP&nbsp;$100</h4>
			<h2 >Trim 1+1</h2>
		</div>
		<div class="content_right  content_word">
			<h3>Trim Carb Eraser</h3>
			<p>Lorem ipsum dolor sit amet, consectetur 
adipiscing elit. Aenean euismod bibendum
laoreet. Proin gravida dolor sit amet lacus 
accumsan et viverra justo commodo.</p>
		</div>
	</div>	
	<div class="intro_component outer_continer">
		<div class="compoment_c">
			<ul class="c">
					<li class="com_1 pic_box fl com"><img src="{{ asset('themes/news-tv/dist/img/comp1.png') }}"/><h4 class="transitionf">name1</h4></li>
					<li class="com_2 pic_box fl com"><img src="{{ asset('themes/news-tv/dist/img/comp2.png') }}"/><h4 class="transitionf">name2</h4></li>
					<li class="com_3 pic_box fl com"><img src="{{ asset('themes/news-tv/dist/img/comp3.png') }}"/><h4 class="transitionf">name3</h4></li>
					<li class="clear"></li>
			</ul>
			<ul class="c">
					<li class="com_4 pic_box fl com"><img src="{{ asset('themes/news-tv/dist/img/comp4.png') }}"/><h4 class="transitionf">name4</h4></li>
					<li class="pic_box fl"></li>
					<li class="com_5 pic_box fl com"><img src="{{ asset('themes/news-tv/dist/img/comp5.png') }}"/><h4 class="transitionf">name5</h4></li>
					<li class="clear"></li>
			</ul>
			<ul class="c">
					<li class="com_6 pic_box fl com"><img src="{{ asset('themes/news-tv/dist/img/comp6.png') }}"/><h4 class="transitionf">name6</h4></li>
					<li class="com_7 pic_box fl com"><img src="{{ asset('themes/news-tv/dist/img/comp7.png') }}"/><h4 class="transitionf">name7</h4></li>
					<li class="com_8 pic_box fl com"><img src="{{ asset('themes/news-tv/dist/img/comp8.png') }}"/><h4 class="transitionf">name8</h4></li>
					<li class="clear"></li>
			</ul>
		</div>
	</div>
	<div class="component_detail outer_continer">
		<div class="box ">
			<div class="close"></div>
			<div class="title">
				<div class="pic_box fl" style="background:url('{{ asset('themes/news-tv/dist/img/comp1.png') }}') no-repeat center;background-size:contain;"></div>
				<h3 class="fl">Curabitur mi1</h3>
				<div class="clear"></div>
			</div>
			<p>
			Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.		
			</p>
			<p>Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.</p>
		</div>
		<div class="box ">
			<div class="close"></div>
			<div class="title">
				<div class="pic_box fl" style="background:url('{{ asset('themes/news-tv/dist/img/comp2.png') }}') no-repeat center;background-size:contain;"></div>
				<h3 class="fl">Curabitur mi2</h3>
				<div class="clear"></div>
			</div>
			<p>
			Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.		
			</p>
			<p>Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.</p>
		</div>	
		<div class="box ">
			<div class="close"></div>
			<div class="title">
				<div class="pic_box fl" style="background:url('{{ asset('themes/news-tv/dist/img/comp3.png') }}') no-repeat center;background-size:contain;"></div>
				<h3 class="fl">Curabitur mi3</h3>
				<div class="clear"></div>
			</div>
			<p>
			Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.		
			</p>
			<p>Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.</p>
		</div>	
		<div class="box ">
			<div class="close"></div>
			<div class="title">
				<div class="pic_box fl" style="background:url('{{ asset('themes/news-tv/dist/img/comp4.png') }}') no-repeat center;background-size:contain;"></div>
				<h3 class="fl">Curabitur mi4</h3>
				<div class="clear"></div>
			</div>
			<p>
			Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.		
			</p>
			<p>Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.</p>
		</div>	
		<div class="box ">
			<div class="close"></div>
			<div class="title">
				<div class="pic_box fl" style="background:url('{{ asset('themes/news-tv/dist/img/comp5.png') }}') no-repeat center;background-size:contain;"></div>
				<h3 class="fl">Curabitur mi5</h3>
				<div class="clear"></div>
			</div>
			<p>
			Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.		
			</p>
			<p>Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.</p>
		</div>	
		<div class="box ">
			<div class="close"></div>
			<div class="title">
				<div class="pic_box fl" style="background:url('{{ asset('themes/news-tv/dist/img/comp6.png') }}') no-repeat center;background-size:contain;"></div>
				<h3 class="fl">Curabitur mi6</h3>
				<div class="clear"></div>
			</div>
			<p>
			Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.		
			</p>
			<p>Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.</p>
		</div>	
		<div class="box ">
			<div class="close"></div>
			<div class="title">
				<div class="pic_box fl" style="background:url('{{ asset('themes/news-tv/dist/img/comp7.png') }}') no-repeat center;background-size:contain;"></div>
				<h3 class="fl">Curabitur mi7</h3>
				<div class="clear"></div>
			</div>
			<p>
			Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.		
			</p>
			<p>Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.</p>
		</div>	
		<div class="box ">
			<div class="close"></div>
			<div class="title">
				<div class="pic_box fl" style="background:url('{{ asset('themes/news-tv/dist/img/comp8.png') }}') no-repeat center;background-size:contain;"></div>
				<h3 class="fl">Curabitur mi8</h3>
				<div class="clear"></div>
			</div>
			<p>
			Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.		
			</p>
			<p>Lorem ipsum dolor sit amet, consectetur laoreet. Proin gravida dolor sit amet
adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sitdgd
laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.</p>
		</div>		
	</div>
</div>
<div class="product_video">
	<img src="{{ asset('themes/news-tv/dist/img/movie_temp.png') }}"/>
</div>
<a class="product_search" href="#">
	<div class="left fl"></div>
	<div class="right fr">
		<div class="c fl">
			<div class="pic_box"></div>
			<h4>australian laboratories tested</h4>
			<h3>more--></h3>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</a>

<article class="product_feedback inner_continer">
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
	</ul>
</article>
<div class="product_bmi ">
	<div class="inner_continer">
		<h3 class="title">BMI<span>Calculator</span></h3>
		<p class="bmi_intro">Body Mass Index is... vestibulum ex dui, dignissim ac rhoncus non, rhoncus sed mi. In hac habitasse platea dictumst. Praesent eu ante mollis, malesuada tortor ac, porttitor velit. Phasellus iaculis pretium magna, et rutrum mauris convallis pellentesque. Suspendisse convallis ut eros ut scelerisque. Pellentesque dictum turpis dolor, eu laoreet eros mollis non. Sed non est et mi pretium feugiat vitae id massa.</p>
		<form method="post" onsubmit="return false;" name="bmi">
			<div class="fl left">
			  <div class="c c_male fl ">
				<input type="radio" name="sex" value="1"/>
				<div class="radio_temp temp_male">
					<div class="pic_box"></div>
					<h4>MALE</h4>
				</div>
			  </div>
			  <div class="c c_female fr">
				<input type="radio" name="sex" value="0"/>
				<div class="radio_temp temp_female">
					<div class="pic_box"></div>
					<h4>FEMALE</h4>
				</div>
		      </div>
		      <div class="clear"></div>		
			</div>
			<div class="fl right">
				<ul>
					<li class="unknow">
						<div class="c fl choose"><input type="radio" name="unknow" value="1" checked/><div>miperial</div></div>
						<div class="c fr"><input type="radio" name="unknow" value="0"//><div>metric</div></div>
						<div class="clear"></div>
					</li>
					<li class="height range">
						<h4>Height</h4>
						<div class="c">
							<input type="range" name="height" class="fl rangein" max="250"  min="50"/>
							<p class="fl"><span class="number"></span><span class="unit">CM</span></p>
							<div class="clear"></div>
						</div>
					</li>
					<li class="width range">
						<h4>Weight</h4>
						<div class="c">
							<input type="range" name="width" class="fl rangein" max="150" min="0"/>
							<p class="fl"><span class="number"></span><span class="unit">KG</span></p>
							<div class="clear"></div>
						</div>
						
					</li>
					<li class="sub">
						<input type="submit" name="sub" value="CAICULATE MY BMI"/>
					</li>
				</ul>
			</div>
			<div class="clear"></div>
		</form>	
 	</div>
	
</div>
<div class="bmi_result">
	<div class="inner_continer">
		<h3>28.5</h3>
		<h4>You are slightly overweight.</h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio
		</p>
	</div>
</div>
<div class="product_list inner_continer">
	<ul class="pl_lead">
		<li class="fl lead_item current">Ingredients</li>
		<li class="fl lead_item">Directions</li>
		<li class="fl lead_item">FAQ</li>
		<li class="clear"></li>
	</ul>
	<ul class="pl_detail">
		<li class="fl detail_item current">
			<h3>Each Tablet Contains</h3>
			<ul class="comp_list">
				<li><span class="fl">Poliglusam (chitosan) derived from Aspergillus niger</span><span class="fr">425mg</span><div class="clear"></div></li>
				<li><span class="fl">Camellia Sinesis (green tea)</span><span class="fr">225mg</span><div class="clear"></div></li>
				<li><span class="fl">Equiv. green tea dry leaf</span><span class="fr">225mg</span><div class="clear"></div></li>
				<li><span class="fl">Equiv. to caffine</span><span class="fr">225mg</span><div class="clear"></div></li>
				<li><span class="fl">Chromium picolinate</span><span class="fr">225mg</span><div class="clear"></div></li>
				<li><span class="fl">Equiv. Chromium</span><span class="fr">225mg</span><div class="clear"></div></li>
				<li><span class="fl">Magnolia Offinalis</span><span class="fr">225mg</span><div class="clear"></div></li>
				<li><span class="fl">Equiv. Magnolia officinalis dry bark</span><span class="fr">225mg</span><div class="clear"></div></li>
			</ul>
		</li>
		<li class="fl detail_item">test2</li>
		<li class="fl detail_item">test3</li>
		<li class="clear"></li>
	</ul>
</div>
@endsection