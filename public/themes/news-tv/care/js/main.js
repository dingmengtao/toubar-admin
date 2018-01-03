$(function(){
	$(".fakerloader").css("height",$(window).height()).fadeOut(2000);
	$(".banner").css("margin-top",$(window).height());
	$(".banner").animate({marginTop:"0px"},1200);
	$(".banner").animate({marginTop:"90px"},400);
	var video = document.getElementById('my_video');
	$('.play').on('click', function() {
		console.log("1234");
	   if(video.paused) {
	      video.play();
	      $(this).css("display","none");
	   	}
	   else {
	      video.pause();
	   }
	   return false;
	});
	video.onended = function() {
    	$(".play").css("display","inline-block");
	};
	$(".fakeloader").fakeLoader({
                    timeToHide:1200,
                    bgColor:"#fff",
                    imagePath:"images/banner.png"
    });
}
)