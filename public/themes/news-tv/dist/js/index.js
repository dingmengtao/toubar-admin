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
	$(".faq_tabs .lead").delegate(".item", "click", function() {
		$(this).parent().find(".current").removeClass("current");
		$(this).addClass("current");
		var index = $(this).index();
		$(".faq_tabs .content").find(".current").removeClass("current");
		$(".faq_tabs .content .item").eq(index).addClass("current");
	});
	//404页面
	$(".bug_continer").css("height", $(window).height());
	var temp_value = ($(window).height() - $(".bug_continer .content").height()) / 2;
	$(".bug_continer .content").css("position", "relative");
	$(".bug_continer .content").css("top", temp_value);
	//新闻详情页
	function newsdetail() {
		var pic_height = $(".news_detail .detail_content").height() - $(".news_detail .detail_content .bottom").height() - 79;
		$(".news_detail .detail_bg .pic").css("height", pic_height);
		$(".news_detail .detail_bg .pic").css("width", $(window).width());
		$(".news_detail .detail_bg .pic").css("position", "absolute");
		var temp_left = ($(window).width() - $(".news_detail .detail_content").width()) / 2;
		$(".news_detail .detail_bg .pic").css("left", -temp_left);
	}
	newsdetail();
	//关于我们
	function aboutus() {
		var us_pic_height = $(".us_detail .us_content").height();
		$(".us_detail .us_bg .pic").css("height", us_pic_height);
		$(".us_detail .us_bg .pic").css("width", $(window).width());
		$(".us_detail .us_bg .pic").css("position", "absolute");
		var us_temp_left = ($(window).width() - $(".us_detail .us_content").width()) / 2;
		$(".us_detail .us_bg .pic").css("left", -us_temp_left);
	}
	aboutus();
	//产品页面
	$(".product_intro .intro_pic .pic").animate({
		width: "40%",
		height: "5.83rem",
		opacity: "1"
	}, "slow");

	function productShow() {
		$(".product_intro .intro_content .content_word").each(function() {
			$(this).animate({
				minHeight: "5rem",
				height: "auto"
			}, "slow");
		});
		$(".product_intro .intro_content .content_bottom h2").animate({
			fontSize: "1.72rem"
		});
		$(".product_intro .intro_content .content_bottom h2").animate({
			fontSize: "1.6rem"
		});
		$(".product_intro .intro_content .content_bottom h2").animate({
			fontSize: "1.72rem"
		});
		$(".product_intro .intro_content .content_bottom h4").animate({
			height: "0.688rem",
			opacity: "1"
		});
	}
	productShow();

	function productHide() {
		$(".product_intro .intro_content .content_word").each(function() {
			$(this).animate({
				height: "0rem"
			}, "slow");
		});
		$(".product_intro .intro_content .content_bottom h2").animate({
			fontSize: "0rem"
		});
		$(".product_intro .intro_content .content_bottom h4").animate({
			height: "0rem",
			opacity: "0"
		});
	}

	function compmove() {
		var movex = $(window).width() / 5;
		var movey = $(window).width() / 15;
		$(".intro_component .compoment_c .pic_box").css("position", "relative");
		$(".intro_component .compoment_c .com_1").animate({
			left: -movex,
			top: -movey,
			opacity: "1"
		}, "slow");
		$(".intro_component .compoment_c .com_2").animate({
			top: -movey,
			opacity: "1"
		}, "slow");
		$(".intro_component .compoment_c .com_3").animate({
			left: movex,
			top: -movey,
			opacity: "1"
		}, "slow");
		$(".intro_component .compoment_c .com_4").animate({
			left: -movex * 1.7,
			opacity: "1"
		}, "slow");
		$(".intro_component .compoment_c .com_5").animate({
			left: movex * 1.7,
			opacity: "1"
		}, "slow");
		$(".intro_component .compoment_c .com_6").animate({
			left: -movex,
			top: movey,
			opacity: "1"
		}, "slow");
		$(".intro_component .compoment_c .com_7").animate({
			top: movey,
			opacity: "1"
		}, "slow");
		$(".intro_component .compoment_c .com_8").animate({
			left: movex,
			top: movey,
			opacity: "1"
		}, "slow");
	}
	window.addEventListener("scroll",function(evt){
		product_t = $(window).scrollTop();
		if(product_t+$(window).height()-100>$("header").height())
		{
			console.log("yes");
		}
		if(product_t+$(window).height()-100>$("header").height()+$(".product_intro").height())
		{
			console.log("yes2");
		}
	},false);
	//页面改变引发的各页面变化
	$(window).resize(function() {
		newsdetail();
		aboutus();
	});
});