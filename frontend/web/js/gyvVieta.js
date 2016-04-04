$( document ).ready(function() {
    if(pre_open == 1){
    	open();
    }
});

function open(){
	$('#rajonas').css({"display" : "block"});
}

function close(){
	$('#rajonas').fadeOut();
}

function rajonas(e) {

	if(e.added.text == "London"){
		$('#rajonas').fadeIn();
	}else{
		if(typeof(e.removed) != "undefined" && e.removed !== null){
			if(e.removed.text == "London"){
				$('#rajonas').fadeOut();
			}
		}
	}
}
