/*for(var i = 0; i <= step; i++){
	$('#col'+i).css({"color" : "#94b157"});
}

for(var i = 0; i <= step + 1; i++){
	$('#rutuliukas'+i+'b').css({"display" : "none"});
	$('#rutuliukas'+i+'z').css({"display" : "inline-block"});
}*/
for (var i = step.length - 1; i >= 0; i--) {
	$('#skc'+(step[i]+1)).css({"color" : "#94b157"});
	$('#rutuliukas'+(step[i]+1)+'b').css({"display" : "none"});
	$('#rutuliukas'+(step[i]+1)+'z').css({"display" : "inline-block"});
};

$('#rutuliukas'+(cur+1)+'b').css({"display" : "none"});
$('#rutuliukas'+(cur+1)+'z').css({"display" : "inline-block"});