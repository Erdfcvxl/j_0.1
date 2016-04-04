function htmlEncode(value){
    if(value.slice(0,8) == "-%necd%%"){
        value = value.replace('-%necd%%','');
        return value;
    }else{
        return $('<div/>').text(value).html();
    }
}

function update () {

    $.ajax({
        type: "post",
        url: url,
        global: false,
        async: true,
        cache: false,
        data: {'otherID' : otherId},
        dataType: 'json',
        success: function(data){

            if(data != ""){

                for(var i = 0; i < data[0]['number']; i++){
                    $('#chatContainer').prepend('<div class="row" style="margin: 2px 0 0 -15px"><div class="col-xs-2"><img width="100%" src="'+data[i]['avatar']+'"></div><div class="col-xs-10 trans_box yourCloud">'+htmlEncode(data[i]["message"])+'</div><div style="margin: 0px 0; float: right;"><span style="position: relative; font-size: 10px; top: -8px; color: #9b9b9b;">Kątik </span></div></div>');
                }
            }
            setTimeout( function(){
                update();
            }, 2000);
        },
        error:function(ts){
            //console.log(ts.responseText);
            setTimeout( function(){
                update();
            }, 2000);
        },

    });
}

setTimeout( function(){
    update();
}, 2000);

