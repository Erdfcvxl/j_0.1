$(function(){
	$('body').append('<div class="avInfo"></div>');

	$('.hoverAv').mouseenter(function (e){
		var name = $(this).attr( "name" )
		var windowH = $('body').height();

		$('.avInfo').html('<br>Loading...');

		if(windowH < e.pageY + 100){
    		$('.avInfo').css({"display" : "block", "top" : e.pageY - $('.avInfo').height() -8 + "px", "left" : e.pageX + 15 + "px"});
    	}else{
    		$('.avInfo').css({"display" : "block", "top" : e.pageY + 8 +"px", "left" : e.pageX + 15 + "px"});
    	}


		$.ajax({
		    type: "post",
		    url: "/member/getusermodel",
		    data: {'name' : name},
		    dataType: 'json',
		    success: function(data){

		    	if(data['arDraugas']){
		    		var draugas = "<span style='color: #97c80d; font-size: 12px;'><span class='glyphicon glyphicon-ok'></span> draugai</span>";
		    	}else{
		    		var draugas = "";
		    	}

				if(data['avatar']){
		    		var avatar = '<img src="/uploads/531B'+data['id']+'Iav.'+data['avatar']+'" width="200px">';
		    	}else{
		    		var avatar = '<img src="/css/img/icons/no_avatar.png" width="200px">';
		    	}
		    	
		    	//cia yra contentas
		    	$('.avInfo').html(avatar+'<br>'+name+data['vip']+'<br>'+data['metai']+','+data['miestas']+'<br>'+draugas);	


		    	var aspectRatio = $('.avInfo img')[0].naturalHeight / $('.avInfo img')[0].naturalWidth;
		    	var newH = 200 * aspectRatio;

		    	if(windowH < e.pageY + $('.avInfo').height()){
		    		$('.avInfo').css({"display" : "block", "top" : e.pageY - $('.avInfo').height() -8 + "px", "left" : e.pageX  + 15 + "px"});
		    	}else{
		    		$('.avInfo').css({"display" : "block", "top" : e.pageY + 8 +"px", "left" : e.pageX  + 15 + "px"});
		    	}

		    	isHover('.hoverAv');

		    },
		    error:function(ts){
		    	console.log();
		    },
		    complete: function (data) {

		    }

		});	
		
	});

	$('.hoverAvMsg').mouseenter(function (e){
		var name = $(this).attr( "name" )
		var windowH = $('body').height();

		$('.avInfo').html('<br>Loading...');

		if(windowH < e.pageY + 100){
    		$('.avInfo').css({"display" : "block", "top" : 190 + "px", "left" : e.pageX + 15 + "px"});
    	}else{
    		$('.avInfo').css({"display" : "block", "top" : 190 +"px", "left" : e.pageX + 15 + "px"});
    	}


		$.ajax({
		    type: "post",
		    url: "/member/getusermodel",
		    data: {'name' : name},
		    dataType: 'json',
		    success: function(data){

		    	if(data['arDraugas']){
		    		var draugas = "<span style='color: #97c80d; font-size: 12px;'><span class='glyphicon glyphicon-ok'></span> draugai</span>";
		    	}else{
		    		var draugas = "";
		    	}


		    	if(data['avatar']){
		    		var avatar = '<img src="/uploads/531B'+data['id']+'Iav.'+data['avatar']+'" width="200px">';
		    	}else{
		    		var avatar = '<img src="/css/img/icons/no_avatar.png" width="200px">';
		    	}

		    	$('.avInfo').html(avatar+'<br>'+name+data['vip']+'<br>'+data['metai']+','+data['miestas']+'<br>'+draugas);
		    	
		    	var aspectRatio = $('.avInfo img')[0].naturalHeight / $('.avInfo img')[0].naturalWidth;
		    	var newH = 200 * aspectRatio;

		    	//console.log($('.hoverAvMsg'));

		    	if(windowH < e.pageY + $('.avInfo').height()){
		    		$('.avInfo').css({"display" : "block", "top" : 190 + "px", "left" : e.pageX  - 50 + "px"});
		    	}else{
		    		$('.avInfo').css({"display" : "block", "top" : 190 +"px", "left" : e.pageX  - 50 + "px"});
		    	}

		    	isHover('.hoverAvMsg');

		    },
		    error:function(ts){
		    	console.log(ts.responseText);
		    },
		    complete: function (data) {

		    }

		});	
		
	});

	$('.hoverAv').mouseout(function (e){
		
		$('.avInfo').css({"display" : "none"}).html('');
	});

	$('.hoverAvMsg').mouseout(function (e){
		
		$('.avInfo').css({"display" : "none"}).html('');
	});


});

var time;

function isHover(target){
	if ($(target+':hover').length == 0) {
		        $('.avInfo').css({"display" : "none"}).html('');
		    }
	

}
