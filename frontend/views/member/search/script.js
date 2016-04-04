$("#dateOff").click(function() {

	  $("#detailsearchp-metai").css({"background-image" : "none", "color" : "#CCCCCC"}).prop("disabled", true);

	  $("#detailsearchp-menuo").css({"background-image" : "none", "color" : "#CCCCCC"}).prop("disabled", true);  

	  $("#detailsearchp-diena").css({"background-image" : "none", "color" : "#CCCCCC"}).prop("disabled", true); 

	  $("#dateOff").css({"display" : "none"});

	  $("#dateOn").css({"display" : "block"});
});

$("#dateOn").click(function() {

	  $("#detailsearchp-metai").css({"background-image" : "url('css/img/arrow.png')", "color" : "#333"}).prop("disabled", false);

	  $("#detailsearchp-menuo").css({"background-image" : "url('css/img/arrow.png')", "color" : "#333"}).prop("disabled", false);  

	  $("#detailsearchp-diena").css({"background-image" : "url('css/img/arrow.png')", "color" : "#333"}).prop("disabled", false); 

	  $("#dateOn").css({"display" : "none"});

	  $("#dateOff").css({"display" : "block"});
});
if(!date){
	$( "#dateOff" ).trigger( "click" );
}

