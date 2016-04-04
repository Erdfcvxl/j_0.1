$(function(){
	//if()
	//kitas_on('religijos');
	//$('#usersearchdetail-religijacomplete').val('');
})

function naujas(e, b)
{

	if(e.choice.text == "Kita"){
		$('#usersearchdetail-'+b+'complete').val('');
	}else{
		$('#usersearchdetail-'+b+'complete').val(e.choice.id);
	}
	
}