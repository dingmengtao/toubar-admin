$(function() {
//	头部导航动效
			$("header .lead .lead_btn_open").mouseenter(function() {
				$(this).find("p").eq(0).animate({
					width: "0.29rem"
				}, 600);
			});
			$("header .lead .lead_btn_open").mouseleave(function() {
				$("header .lead_btn_open p").eq(0).animate({
					width: "0.21rem"
				}, 600);
			});
			$("header .lead .lead_btn_open").click(function() {
				// 	    $("header .lead_content .lead_btn_close").find("p").each(function(){
				// 	    	$(this).animate({display:"none"});
				// 	    });
				// 	    $("header .lead_content .lead_btn_close").css("background","url('../img/close.png') no-repeat top");
				// 	     $("header .lead_content .lead_btn_close").css("background-size","contain");
				$("header").find(".lead_content").css("display", "block");
				$("header").find(".lead_content").animate({
					width: "100%"
				}, 1200, function() {

					$("header .lead_content").find("li").animate({
						height: "0.928rem"
					}, 1200);
				});
			});
			$("header .lead .lead_btn_close").click(function() {
				$("header .lead_content").find("li").animate({
					height: "0rem"
				}, 1200, function() {
					$("header").find(".lead_content").animate({
						width: "0rem"
					}, 1200, function() {
						$("header").find(".lead_content").css("display", "none");
					})
				})
			});
//faq页面动态效果
			$(".faq_tabs .lead").delegate(".item","click",function(){
				$(this).parent().find(".current").removeClass("current");
				$(this).addClass("current");
				var index=$(this).index();
				$(".faq_tabs .content").find(".current").removeClass("current");
				$(".faq_tabs .content .item").eq(index).addClass("current");
			});
//404页面
		$(".bug_continer").css("height",$(window).height());
		var temp_value=($(window).height()-$(".bug_continer .content").height())/2;
		$(".bug_continer .content").css("position","relative");
		$(".bug_continer .content").css("top",temp_value);
//新闻详情页
        var pic_height=$(".news_detail .detail_content").height()-$(".news_detail .detail_content .bottom").height()-79;
		$(".news_detail .detail_bg .pic").css("height",pic_height);
		$(".news_detail .detail_bg .pic").css("width",$(window).width());
		$(".news_detail .detail_bg .pic").css("position","absolute");
		var temp_left=($(window).width()-$(".news_detail .detail_content").width())/2;
		console.log(temp_left);
		$(".news_detail .detail_bg .pic").css("left",-temp_left);
//关于我们
	 var us_pic_height=$(".us_detail .us_content").height();
		$(".us_detail .us_bg .pic").css("height",us_pic_height);
		$(".us_detail .us_bg .pic").css("width",$(window).width());
		$(".us_detail .us_bg .pic").css("position","absolute");
		var us_temp_left=($(window).width()-$(".us_detail .us_content").width())/2;
		$(".us_detail .us_bg .pic").css("left",-us_temp_left);
});