function htmlEncode(value){
    if(value.slice(0,8) == "-%necd%%"){
        value = value.replace('-%necd%%','');
        return value;
    }else{
        return $('<div/>').text(value).html();
    }
}


/* Attach a submit handler to the form */
$("#chat").submit(function(e) {
    /* Stop form from submitting normally */
    e.preventDefault();
    e.stopImmediatePropagation();

    /* Get some values from elements on the page: */
    var postData = $(this).serializeArray();

    var completeData = postData[1].value;

    var l = jQuery.trim(completeData).length;

    if(completeData != "" && l > 0){

        /* Send the data using post and put the results in a div */
        $('#chatContainer').prepend('<div class="row" style="margin: 2px 0 0 -15px"><div class="col-xs-2"><img width="100%" src="'+avatar+'"></div><div class="col-xs-10 trans_box myCloud">'+htmlEncode(completeData)+'</div><div style="margin: 0px 0; float: right;"><span style="position: relative; font-size: 10px; top: -5px; color: #9b9b9b;">Kątik </span></div></div>');

        $.ajax({
            url: "",
            type: "post",
            data: {'ajax' : 1,'data' : completeData, 'otherID' : otherId},
            dataType: 'html',
            error:function(ts){
                console.log(ts.responseText);
            },
        });

         /* Clear textarea: */
        $("#msgArea").val('');

    }

});

$("#msgArea").keypress(function (e) {

    if(e.which == 13) {
        if (e.shiftKey !== true)
        {   
            var l = jQuery.trim($(this).val()).length;

            if($(this).val() != "" && l > 0){

                e.preventDefault();

                $('#chatContainer').prepend('<div class="row" style="margin: 2px 0 0 -15px"><div class="col-xs-2"><img width="100%" src="'+avatar+'"></div><div class="col-xs-10 trans_box myCloud">'+htmlEncode($(this).val())+'</div><div style="margin: 0px 0; float: right;"><span style="position: relative; font-size: 10px; top: -5px; color: #9b9b9b;">Kątik </span></div></div>');

                $.ajax({
                    url: "",
                    type: "post",
                    data: {'ajax' : 1,'data' : $(this).val(), 'otherID' : otherId},
                    dataType: 'html',
                });
                $("#msgArea").val('');
            }else{
                e.preventDefault();
            }
        }
    }
});