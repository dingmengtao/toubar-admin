$(function() {
//				背景元素动态效果    
				$("html, body").scrollTop(0+"px");
				var b_c_height = $("body").css("height");
				$(".background_c").css("height", b_c_height);
				var old_t = 0,t = 0;
				$(window).scroll(function() {
					var position=$(".my_video").offset().top+$(".my_video").height()-300;
					t=$(window).scrollTop();
					var temp_str="translateY(" +(t-old_t)+"px)";
					$(".background_c .move").each(function(){
						$(this).css("transform",temp_str);
						$(this).css("-ms-transform",temp_str);
						$(this).css("-moz-transform",temp_str);
						$(this).css("-webkit-transform",temp_str);
						$(this).css("-o-transform",temp_str);
					});
					$(".before_c .move").each(function(){
						$(this).css("transform",temp_str);
						$(this).css("-ms-transform",temp_str);
						$(this).css("-moz-transform",temp_str);
						$(this).css("-webkit-transform",temp_str);
						$(this).css("-o-transform",temp_str);
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
					setTimeout(function(){
						old_t = t;
					}, 1000);
				});
	
})
