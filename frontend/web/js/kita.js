function kitas(e, b)
{
	if(e.choice.text == 'Kita'){
		kitas_on(b);
	}
};

function tautybe(e){
	if(e.choice.text == 'Lietuva'){
		$('#tautybes').css({"display" : "block"});
		$('#tautybes2').css({"display" : "none"});
	}else{
		$('#tautybes').css({"display" : "none"});
		$('#tautybes2').css({"display" : "block"});
		$('#info-tautybe2').val("");
	}
}

function kitas_on(b)
{
	$('#'+b).css({"display" : "none"});
	$('#'+b+'2').css({"display" : "block"});
	$('#'+b+'2 input').focus();
};

$(".row").on('click', '.xas', function(e) {
	var freimas = $(this).attr("parent");


	$("#xas").unbind().click(function() {});

	$("#info-"+freimas+"2").val('');
	$('#'+freimas).css({"display" : "block"});
	$('#'+freimas+'2').css({"display" : "none"});
});

$(function(){
	if(tauta == '01keisti'){
		$('#tautybes2').css({"display" : "none"});
		$('#tautybes').css({"display" : "block"});
	}else if(tauta != null){
		$("#info-tautybe2").val(tauta);
	}
	if((pareiga !== null && pareiga !== "")){
		$('#pareigoss').css({"display" : "none"});
		$('#pareigoss2').css({"display" : "block"});
		$("#info-pareigos2").val(pareiga);
	}
	if((religija !== null && religija !== "")){
		$('#religijos').css({"display" : "none"});
		$('#religijos2').css({"display" : "block"});
		$("#info-religija2").val(religija);
	}
	if((akys !== null && akys !== "")){
		$('#aspalva').css({"display" : "none"});
		$('#aspalva2').css({"display" : "block"});
		$("#info-akys2").val(akys);
	}
	if((plaukai !== null && plaukai !== "")){
		$('#pspalva').css({"display" : "none"});
		$('#pspalva2').css({"display" : "block"});
		$("#info-plaukai2").val(plaukai);
	}
	if((stilius !== null && stilius !== "")){
		$('#stilius').css({"display" : "none"});
		$('#stilius2').css({"display" : "block"});
		$("#info-stilius2").val(stilius);
	}
});

/////////////////////////////////////////////////
// gimtoji salis, jei lt tai miestai, jei ne tai viskas
//////////////////////

/*
function kitas_on(b, fromDb)
{
	if(fromDb == null){ fromDb = ""; }
	console.log(b);
	$('#'+b+'2').css({"display" : "block"});
	$('#'+b+'2').focus();
	$('#'+b).css({"display" : "none"});
};

$(function(){
	

	if(tauta !== null && tauta !== ""){
		console.log('*'+tauta+'*');
		$('#tautybes').css({"display" : "none"});
		$('#tautybes2').html('<input type="text" id="info-tautybe2" class="form-control" name="Info[tautybe2]" value="'+tauta+'"><div class="xas" id="tautoff" parent="tautybes" style="right: 20px;"></div>');
	}
	
});

function on_x(turnon)
{
	$('#'+turnon).css({"display" : "block"});
	$('#'+turnon+'2').css({"display" : "none"});
}


$("div").on('click', '#tautoff', function(e) {
	$("div").off().on('click', function() {});
	var kazkas= $(this).attr("parent");
	console.log(kazkas);
   	on_x(kazkas);
});*/

/*
setTimeout(function() {
	$('#tautybes').css({"display" : "none"});
	$('#tautybes2').css({"display" : "block"});
}, 1000);
*//*
setTimeout(function() {
	$('#tautybes').css({"display" : "block"});
	$('#tautybes2').css({"display" : "none"});
}, 5000);*/