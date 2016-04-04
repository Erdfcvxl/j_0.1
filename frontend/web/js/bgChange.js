$("#change_color0").change(function () {
    var end = this.value;
    var Val = $('#change_color0').val();

    if(Val == 'vm' || Val == 'mv')
    	Val = 'pazintys_lietuviams'
    
    $(".first_flat#original").backstretch("/css/img/"+Val+".jpg?t="+Date.now, {speed: 400});

    
});

