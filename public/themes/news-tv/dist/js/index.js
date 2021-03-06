$(function() {
	//	头部导航动效
	$("header .lead .lead_btn_open").mouseenter(function() {
		$(this).find("p").eq(0).animate({
			width: "0.29rem"
		});
	});
	$("header .lead .lead_btn_open").mouseleave(function() {
		$("header .lead_btn_open p").eq(0).animate({
			width: "0.21rem"
		});
	});
	$("header .lead .lead_btn_open").click(function() {
		$("header").find(".lead_content").animate({
			width: "100%",
			opacity:"1"
		},function() {
			console.log("test1");
			$("header .lead .lead_btn_open").css("display","none");
			$("header .lead  .lead_content .lead_btn_close").css("display","block");
			$("header .lead  .lead_content .lead_btn_close p").animate({opacity:"0"});
			$("header .lead .lead_content .lead_btn_close .fork").animate({opacity:"1"});
			$("header .lead_content").find("li").animate({
				height: "0.928rem"
			});
		});
	});
	$("header .lead .lead_btn_close").click(function(){
		$("header .lead_content").find("li").animate({
			height: "0rem"
		},function() {
			$("header").find(".lead_content").animate({
				width: "0rem",
				opacity:"0"
			},function() {
				console.log("test2");
				$("header .lead .lead_content .lead_btn_close .fork").animate({opacity:"0"});
				$("header .lead  .lead_content .lead_btn_close p").animate({opacity:"1"});
				$("header .lead  .lead_content .lead_btn_close").css("display","none");
				$("header .lead .lead_btn_open").css("display","block");
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
	    var temp_width=$(".news_detail .detail_bg .pic").width();
	    $(".news_detail .detail_content .pic_temp").css("height",temp_width/2);
		if($(window).width()>768)
		{
			var temp_height=$(".news_detail .detail_content h3").height();
			$(".news_detail .detail_bg .pic").css("position","relative");
			$(".news_detail .detail_bg .pic").css("top",temp_height);
		}
		else
		{
			$(".news_detail .detail_bg .pic").css("left", "0px");
		}
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
		var temp_width=$(".us_detail .us_bg .pic").width();
	    $(".us_detail .us_content .pic_temp").css("height",temp_width/2);
		if($(window).width()>768)
		{
			var temp_height=$(".us_detail .us_content h3").height();
			$(".us_detail .us_bg .pic").css("position","relative");
			$(".us_detail .us_bg .pic").css("top",temp_height);
		}
		else
		{
			$(".us_detail .detail_bg .pic").css("left", "0px");
		}
	}
	aboutus();
	//联系我们
	function contactUs()
	{
		$(".map .map_content  iframe").css("width",$(window).width()+"px");
		$(".map .map_content  iframe").css("position","absolute");
		$(".map .map_content  iframe").css("top","0px");
		var temp_left=($(window).width()-$(".map .map_content").width())/2;
		$(".map .map_content  iframe").css("left","-"+temp_left+"px");
		$(".info_list  .worktime").css("height",$(".info_list .item").height()+"px");
		var temp_margin=($(".info_list .item").height()-$(".info_list  .worktime span").height())/2;
		$(".info_list  .worktime span").css("margin-top",temp_margin);
	}
    contactUs();
	//产品页面
	function productPicShow()
	{
		if($(window).width()>768)
		{
			$(".product_intro .intro_pic .pic").animate({
			width: "5.39rem",
			height:"4rem",
			opacity: "1"
			}, "slow");
		}else
		{
			$(".product_intro .intro_pic .pic").css("width","80%");
			$(".product_intro .intro_pic .pic").css("height",($(window).width()*0.8)/5.39*4+"px");
			$(".product_intro .intro_pic .pic").css("opacity","1");
			
			$(".product_intro .intro_content .pic_temp").css("width",$(".product_intro .intro_pic .pic").width());
			$(".product_intro .intro_content .pic_temp").css("height",$(".product_intro .intro_pic .pic").height());
			
			$(".product_intro .intro_content .content_bottom h2").css("position","relative");
			$(".product_intro .intro_content .content_bottom h2").css("bottom",$(".product_intro .intro_pic .pic").height()+50+"px");
			
			$(".mobile_product_intro  .compoment_c .c .pic_box").css("height",$(".mobile_product_intro  .compoment_c .c .pic_box").width()+44+"px");
			$(".mobile_product_intro  .compoment_c .c .pic_box div").css("height",$(".mobile_product_intro  .compoment_c .c .pic_box").width()+"px");	
		
			$(".product_search .left").css("height",$(".product_search .left").width()/694*548+"px");
		    
		    $(".product_bmi form .left .c .radio_temp .pic_box").css("height",$(".product_bmi form .left .c .radio_temp .pic_box").width()+"px");
			$(".product_bmi form .left .c").css("height",$(".product_bmi form .left .c").width()+"px");
		}
	}
	productPicShow();
	var product_show = false;
	var comp_show = false;
	function productShow() {
		if(!product_show) {
			if($(window).width()>768)
			{
				var content_width=($(window).width()-539)/2;
				$(".product_intro .intro_content .content_word").css("width",content_width);
				$(".product_intro .intro_content .content_word").each(function() {
					$(this).animate({
						minHeight: "5rem",
						height: "auto",
						opacity: "1"
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
			}else{
				$(".product_intro .intro_content .content_bottom h2").animate({
					fontSize: "0.52rem"
				});
				$(".product_intro .intro_content .content_bottom h2").animate({
					fontSize: "0.27rem"
				});
				$(".product_intro .intro_content .content_bottom h2").animate({
					fontSize: "0.52em"
				});
				$(".product_intro .intro_content .content_bottom h4").animate({
					height: "0.50rem",
					opacity: "1"
				});
			}
		}
		product_show = true;
	}
	productShow();
	function productHide() {
		if(product_show) {
			$(".product_intro .intro_content .content_word").each(function() {
				$(this).animate({
					height: "0rem",
					minHieght: "0rem",
					opacity: "0"
				}, "fast");
			});
			$(".product_intro .intro_content .content_bottom h2").animate({
				fontSize: "0rem"
			}, "fast");
			$(".product_intro .intro_content .content_bottom h4").animate({
				height: "0rem",
				opacity: "0"
			}, "fast");
		}
		product_show = false;
	}

	function compmove() {
		if(!comp_show) {
			$(".product_intro .intro_component").css("display", "block");
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
		comp_show = true;
	}
	function comphide() {
		if(comp_show) {
			$(".intro_component .compoment_c .pic_box").css("position", "relative");
			$(".intro_component .compoment_c .com_1").animate({
				left: "0rem",
				top: "0rem",
				opacity: "0"
			}, "fast");
			$(".intro_component .compoment_c .com_2").animate({
				top: "0rem",
				opacity: "0"
			}, "fast");
			$(".intro_component .compoment_c .com_3").animate({
				left: "0rem",
				top: "0rem",
				opacity: "0"
			}, "fast");
			$(".intro_component .compoment_c .com_4").animate({
				left: "0rem",
				opacity: "0"
			}, "fast");
			$(".intro_component .compoment_c .com_5").animate({
				left: "0rem",
				opacity: "0"
			}, "fast");
			$(".intro_component .compoment_c .com_6").animate({
				left: "0rem",
				top: "0rem",
				opacity: "0"
			}, "fast");
			$(".intro_component .compoment_c .com_7").animate({
				top: "0rem",
				opacity: "0"
			}, "fast");
			$(".intro_component .compoment_c .com_8").animate({
				left: "0rem",
				top: "0rem",
				opacity: "0"
			}, "fast");
			$(".product_intro .intro_component").css("display", "none");
		}
		comp_show = false;
	}
	window.addEventListener("scroll", function(evt) {
		var product_t = $(window).scrollTop();
		var product_temp2 = $("header").height();
		if($(window).width()>768)
		{
			if(product_t > product_temp2 && product_t < product_temp2 + $(window).height()) {
				productHide();
				compmove();
			}
			if(product_t > product_temp2 + $(window).height() || product_t < product_temp2) {
				comphide();
				productShow();
			}
		}
		
	}, false);
	$(".product_intro .intro_component .compoment_c").delegate(".pic_box", "click", function() {
		var pro_index = $(".product_intro .intro_component .compoment_c .com").index(this);
		$(".product_intro .component_detail").css("display", "block");
		$(".product_intro .component_detail").animate({
			opacity: "1"
		});
		$(".product_intro .component_detail .box").eq(pro_index).css("display", "block");
		$(".product_intro .component_detail .box").eq(pro_index).find("h3").animate({
			opacity: "1"
		}, "slow");
		$(".product_intro .component_detail .box").eq(pro_index).find("p").animate({
			lineHeight: "0.38rem"
		}, "slow");

	});
	$(".product_intro .component_detail").delegate(".close", "click", function() {
		$(this).parent().find("h3").animate({
			opacity: "0"
		});
		$(this).parent().find("p").animate({
			lineHeight: "0rem"
		});
		$(this).parent().css("display", "none");
		$(".product_intro .component_detail").animate({
			opacity: "0"
		});
		$(".product_intro .component_detail").css("display", "none");
	});
	
	//bmi表单-sex
	$(".product_bmi form .left").delegate(".c", "click", function() {
		if(!$(this).hasClass("choose")) {
			$(".product_bmi form .left .choose").removeClass("choose");
			$(this).addClass("choose");
		}
	});
	//bmi表单-unknow
	$(".product_bmi form .right .unknow ").delegate(".c", "click", function() {
		if(!$(this).hasClass("choose")) {
			$(".product_bmi form .right .unknow .choose").removeClass("choose");
			$(this).addClass("choose");
		}
	});
	//bmi表单-height/weight
	$(".product_bmi form .right .rangein").each(function() {
		var max = parseFloat($(this).attr("max"));
		var min = parseFloat($(this).attr("min"));
		var value = parseFloat($(this).val());
		var temp = (value - min) / (max - min) * 100;
		$(this).css('background', '-webkit-linear-gradient(to right, #000000, #000000,' + temp + '%, #B0B0B0,#B0B0B0)');
		$(this).css('background', '-o-linear-gradient(to right, #000000, #000000,' + temp + '%, #B0B0B0,#B0B0B0)');
		$(this).css('background', '-moz-linear-gradient(to right, #000000,#000000, ' + temp + '%, #B0B0B0,#B0B0B0)');
		$(this).css('background', 'linear-gradient(to right, #000000, #000000,' + temp + '%, #B0B0B0,#B0B0B0)');
		$(this).parent().find(".number").html(value + "");
	});
	$(".product_bmi form .right").delegate(".rangein", "input", function() {
		var max = parseFloat($(this).attr("max"));
		var min = parseFloat($(this).attr("min"));
		var value = parseFloat($(this).val());
		var temp = (value - min) / (max - min) * 100;
		$(this).css('background', '-webkit-linear-gradient(to right, #000000, #000000,' + temp + '%, #B0B0B0,#B0B0B0)');
		$(this).css('background', '-o-linear-gradient(to right, #000000, #000000,' + temp + '%, #B0B0B0,#B0B0B0)');
		$(this).css('background', '-moz-linear-gradient(to right, #000000,#000000, ' + temp + '%, #B0B0B0,#B0B0B0)');
		$(this).css('background', 'linear-gradient(to right, #000000, #000000,' + temp + '%, #B0B0B0,#B0B0B0)');
		$(this).parent().find(".number").html(value + "");
	});
	//产品成分
	$(".product_list .pl_lead").delegate("li", "click", function() {
		$(".product_list .pl_lead .current").removeClass("current");
		$(this).addClass("current");
		var index = $(this).index();
		$(".product_list .pl_detail .current").removeClass("current");
		$(".product_list .pl_detail .detail_item").eq(index).addClass("current");
	})
	//页面改变引发的各页面变化
	$(window).resize(function() {
		//背景元素
		if($(window).width()> 1400) {
			$(".background_c  .box3 .word").css("font-size", "2.11rem");
		} else if($(window).width()> 1000) {
			$(".background_c  .box3 .word").css("font-size", "1.5rem");
		} else if($(window).width()> 800) {
			$(".background_c  .box3 .word").css("font-size", "1.2rem");
		} else if($(window).width()> 600) {
			$(".background_c  .box3 .word").css("font-size", "0.8rem");
		} else {
			$(".background_c  .box3 .word").css("font-size", "0.5rem");
		}
		//新闻详情页
		newsdetail();
		//关于我们
		aboutus();
		//联系我们
		contactUs();
		//产品
		productPicShow();
		productShow();
	});
});