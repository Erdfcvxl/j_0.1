function ratioFixing(){
	var w_height_limit = 750; 

	var images = 3;

	//registracijos psl skaiciuku divas
	var w_cont = $('.rutuliukai').width();

	var remove = 3 * (w_cont / 100 * 20) + 2 * (((w_cont / 100 * 20) / 2) - 8);
	var left = ((w_cont / 100 * 20) / 2) + 8;

	$('#reg_hrcustm').css({"width" : remove + "px", "left" : + left + "px"});


}; 

function ajustToScreen()
{
	var screenH = $(window).height(),
		screenW = $(window).width(),
		firstFlatH = $('.first_flat').outerHeight();


	var padding = ((screenH - 413.2) / 2) -25;

	if(screenH >= 609){
		$(".first_flat").css({
			'padding-top' : padding + 'px',
			'padding-bottom' : padding + 'px'
		});
	}
}




$(document).ready(function(){ratioFixing(); ajustToScreen();});
$('#log_bg1').ready(function(){
	$(".first_flat#copy").backstretch("/css/img/mm.jpg");
	$(".first_flat#original").backstretch("/css/img/pazintys_lietuviams.jpg");
	$(".first_flat#original").on("backstretch.show", function () {$("#log_bg2").css({"display" : "none"});});
	
});
$(window).resize(function(){ratioFixing();});
$('.first_flat_right').resize(ratioFixing);
$('#expand_end_btn').click(ratioFixing);
setTimeout( function(){
	ratioFixing();
},50);


