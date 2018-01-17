<footer class="lazyc">
	<div class="footer_logo"></div>
	<ul class="footer_lead tl_center">
		<li class="fl_item fl tl_center">
			<a href="#">Product</a>
		</li>
		<li class="fl_item fl tl_center">
			<a href="#">News</a>
		</li>
		<li class="fl_item fl tl_center">
			<a href="#">About&nbsp;us</a>
		</li>
		<li class="fl_item fl tl_center">
			<a href="#">Contact</a>
		</li>
		<li class="fl_item fl tl_center">
			<a href="#">Term</a>
		</li>
		<li class="clear"></li>
	</ul>
	<ul class="share-buttons">
		@foreach($shares as $share)
			<li class="fl share_item">
				<a class="pic_box" href="{{$share->link_url }}" title="Share on {{ $share->title }}" target="_blank"><img alt="Share on {{ $share->title }}"  src="{{ get_image($share->thumbnail) }}"/></a>
			</li>
		@endforeach
		<li class="clear"></li>
	</ul>
	<p class="info">@2008-2016&nbsp;LINGOES&nbsp; PROJECT&nbsp;,ALL&nbsp;RIGHT&nbsp;RESEVRED </p>
</footer>
