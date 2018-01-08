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
});