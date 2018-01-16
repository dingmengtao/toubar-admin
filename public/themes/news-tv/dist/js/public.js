$(function() {
	//懒加载内容
	$("html, body").scrollTop(0 + "px");
	var now_position = $(".lazyc").eq(0).offset().top;
	var lazyc_index = 0;
	var lazyc_length = $(".lazyc").length;
	var lazy_speed = 1200;
	var offset_margin = 100;
	var finish_flag = false;
	var ing = false;
	var window_height = $(window).height();

	function refresh() {
		if(finish_flag) {
			return false
		};
		ing = true;
		var t = $(window).scrollTop();
		if(!(t + window_height < now_position)) {
			var lazyc_aim = $(".lazyc").eq(lazyc_index);
			var lazy_index = 0;
			var lazy_length = lazyc_aim.find(".lazy_item").length;
			if(lazy_length == 0) {
				lazy_aim = lazyc_aim;
				if(lazy_aim.css("margin-top") == undefined) {
					var origin_margin = 0;
				} else {
					var origin_margin = parseInt(lazy_aim.css("margin-top"));
				}
				var temp_margin = origin_margin + offset_margin;
				lazy_aim.css("margin-top", temp_margin);
				lazyc_aim.animate({
					opacity: "1"
				}, lazy_speed);
				lazy_aim.animate({
					marginTop: origin_margin,
					opacity: "1"
				}, lazy_speed);
				lazy_index++;
			} else {
				while(lazy_index < lazy_length) {
					lazy_aim = lazyc_aim.find(".lazy_item").eq(lazy_index);
					if(lazy_aim.css("margin-top") == undefined) {
						var origin_margin = 0;
					} else {
						var origin_margin = parseInt(lazy_aim.css("margin-top"));
					}
					var temp_margin = origin_margin + offset_margin;
					lazy_aim.css("margin-top", temp_margin);
					lazyc_aim.animate({
						opacity: "1"
					}, lazy_speed);
					lazy_aim.animate({
						marginTop: origin_margin,
						opacity: "1"
					}, lazy_speed);
					lazy_index++;
				}
			}
			if(lazyc_index < lazyc_length - 1) {
				lazyc_index++;
				now_position = $(".lazyc").eq(lazyc_index).offset().top;
				refresh();
			} else {
				finish_flag = true;
			}
		}
		ing = false;
	}

	//背景元素动态效果  及懒加载使用
	$("html, body").scrollTop(0 + "px");
	var b_c_height = $("body").css("height");
	$(".background_c").css("height", b_c_height);
	var old_t = 0,
	t = 0;
	window.addEventListener("scroll",function(evt){
        		//懒加载开始
		if(!ing) {
			refresh();
		}
		//					懒加载结束
		t = $(window).scrollTop();
//		var temp_str = "translateY(" + (t - old_t) + "px)";
		var temp_str = "translateY(" + (old_t-t) + "px)";
		$(".background_c .move").each(function() {
			$(this).css("transform", temp_str);
			$(this).css("-ms-transform", temp_str);
			$(this).css("-moz-transform", temp_str);
			$(this).css("-webkit-transform", temp_str);
			$(this).css("-o-transform", temp_str);
		});
		$(".before_c .move").each(function() {
			$(this).css("transform", temp_str);
			$(this).css("-ms-transform", temp_str);
			$(this).css("-moz-transform", temp_str);
			$(this).css("-webkit-transform", temp_str);
			$(this).css("-o-transform", temp_str);
		});
		if(t > 1200) {
			$(".background_c  .box3").animate({
				padding: "0rem"
			});
			$(".background_c  .box3 .word").animate({
				opacity: "0.3",
				fontSize: "2.11rem"
			});
		}
		setTimeout(function() {
			old_t = t;
		});
    },false);	
})