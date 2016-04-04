var interval;

function reg_ex(){
	

	//$('#change_color0').css({'background-color' : '#94c500'});
	//$('#change_color1').css({'background-color' : '#94c500'});
	//$('#change_color2').css({'background-color' : '#94c500'});

	//

	$('#off1').velocity("fadeOut", { duration: 400 });//.css({{"display" : "none"}});
	$('#off2').velocity("fadeOut", { duration: 400 });
	$('#off3').velocity("fadeOut", { duration: 400 });
	$('#off4').velocity("fadeOut", { duration: 400 });

	setTimeout(function(){
		$('#keeper').css({'display' : 'block'});
	},400);
	
	
	//$('#offR').velocity("fadeOut", { duration: 400 });

	setTimeout(function() {
		///$('.login_box').velocity({"height" : "200px"}, 300);

		$('#first').velocity({"top" : "-15px"}, 300);

		$('.th').velocity({"padding-right" : "5px", "padding-top" : "0px", "padding-bottom" : "5px"}, 300);

		$('.td').velocity({"padding-top" : "0px", "padding-bottom" : "5px"}, 300);

		$('#expand_end_btn').velocity({ opacity: 1 }, { display: "block" });
		$('#expand_complete').velocity({ opacity: 1 }, { display: "block" });
		$('#second td').css({"width" : "95px"});

	},500);

	interval = setInterval(function(){
	    $(window).trigger('resize');
	},10);

	setTimeout(function(){
		clearInterval(interval);

	},1000);
	
}

$('#hor').click(function (){
	$('.hor_off').css({"display" : "block"});
	$('.hor_on').css({"display" : "none"});
	$('.bottom_line').css({"background-color" : "rgba(220, 219, 219, 1)"});
});

$('#login_btn').click(function (){
	$('#expand_login').css({"display" : "inline-block"});
});

$( "#exp" ).click(function(){
	reg_ex();
});

if(er_yra == 1){
	reg_ex();
}

