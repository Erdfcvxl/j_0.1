function myFunction() {
	var height = $(window).height() - 70;
   	$('.wrap').css({"min-height" : height + "px"}, function() {
                $('body').css({"height" : height + "px", "overflow" : "auto"});
            });
}
onload = myFunction;