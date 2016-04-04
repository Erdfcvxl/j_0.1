function htmlEncode(value){
    if(value.slice(0,8) == "-%necd%%"){
        value = value.replace('-%necd%%','');
        return value;
    }else{
        return $('<div/>').text(value).html();
    }
}

function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
} 

function msgTopIndicator()
{

	$.ajax({
	    type: "post",
	    url: "/member/casualcheck",
	    dataType: 'json',
	    success: function(data){

	        var newMsg = data['newMsg'],
	        	newMsgId = data['newMsgId'],
	        	chatterId = getUrlParameter('id'),
	        	usernames = data['usernames'],
	        	newDrg = data['newDrg'],
	        	newMeg = data['newMeg'],
	        	newForum = data['forumNew'],
	        	notification = data['notification'],
	        	messages = data['messages'];
	    
	        if(newMsg > 0){

	        	if(puslapis != "msg"){
	        		$('#msgTopIndicator').text(newMsg);
		    		$('#msgTopIndicator').css({"display" : "block"});
	        	}else{
	        		for(var i = 0; i < newMsgId.length; i++){
		        		if(newMsgId[i] == chatterId){
		        			if(newMsg-1 > 0){
		    					$('#msgTopIndicator').text(newMsg-1);
		    					$('#msgTopIndicator').css({"display" : "block"});
		    				}
		    			}else{
		    				$('#msgTopIndicator').text(newMsg);
		    				$('#msgTopIndicator').css({"display" : "block"});
		    			}
	    			}
	        	}

	        }else{
	        	$('#msgTopIndicator').css({"display" : "none"});
	        }

	        if(newDrg > 0){
	        	$('#drgTopIndicator').text(newDrg);
	        	$('#drgTopIndicator').css({"display" : "block"});
	        }

	        if(newMeg > 0){
	        	$('#megTopIndicator').text(newMeg);
	        	$('#megTopIndicator').css({"display" : "block"});
	        }

	        if(newForum > 0){
	        	$('#forumTopIndicator').text(newForum);
	        	$('#forumTopIndicator').css({"display" : "block"});

	        }

	        if(notification > 0){
	        	$('#pgrTopIndicator').text(notification);
	        	$('#pgrTopIndicator').css({"display" : "block"});
	        }else{
	        	$('#pgrTopIndicator').css({"display" : "none"});
	        }

	        if(puslapis == "msg"){
	        	for(var i = 0; i < newMsgId.length; i++){
	        		if(newMsgId[i] != chatterId){
	        			//console.log($('#chatterid'+newMsgId[i]));

		        		$('#infoPart'+newMsgId[i]).css({"border-top" : "2px solid #94c500", "border-right" : "2px solid #94c500", "border-bottom" : "2px solid #94c500"});
		        		$('#chatterid'+newMsgId[i]).prependTo("#pasnekovai");
		        	}
	        	}

	        	if(newMsg > 0){
	        	for(var i = 0; i < newMsgId.length; i++){
	        		if(newMsgId[i] == chatterId){
	        			if(newMsg-1 > 0){
	    					$('#msgNewIndicator').text(newMsg-1);
	    					$('#msgNewIndicator').css({"display" : "inline-block"});
	    				}
	    			}else{
	    				$('#msgNewIndicator').text(newMsg);
	    				$('#msgNewIndicator').css({"display" : "inline-block"});
	    			}
    			}
		        }else{
		        		$('#msgNewIndicator').css({"display" : "none"});
		        }
	        }else if(puslapis == "index"){
	        	if(newMsg > 0){
	        		$('#msgIndexIndicator').html(newMsg);
		    		$('#msgIndexIndicator').css({"display" : "inline-block"});
		    		$('#laiskoImg').attr('src', '/css/img/icons/laiskasNew.png');
		    		$('#laiskoImg').css({'cursor' : 'pointer'});
		    		$('#laiskoImg').click(function(){
		    			javascript:window.location.href=$('#laiskoImg').attr('link');
		    		});
		    		$('#msgIndexIndicator').click(function(){
		    			javascript:window.location.href=$('#laiskoImg').attr('link');
		    		});

	        	}else{
	        		$('#msgIndexIndicator').css({"display" : "none"});
		    		$('#laiskoImg').attr('src', '/css/img/icons/laiskas.png');
	        	}

	        	if(usernames && messages){
	        		var full = '';

	        		for(var i = 0; i < usernames.length; i++){
	        			full = '<div class="col-xs-10 trans_box" style="padding: 2px 15px; margin: 1px 0;"><a href="'+data['url']+newMsgId[i]+'"">'+usernames[i]+': '+htmlEncode(messages[i])+'</a></div>'+full; 
	        		}

	        		if(full){
	        			$('#quickMsgPreview').html(full);
	        		}
	        	}

	        }

	    },
	    error:function(ts){
	    	console.log(ts.responseText);
	    },
	    complete: function (data) {
	    	//console.log('mane issauke complete funkcija');
	    	setTimeout(function (){
	    		msgTopIndicator();
	    	}, 3000);
	    }

	});	
}

$(function ()
{
	msgTopIndicator();
});
