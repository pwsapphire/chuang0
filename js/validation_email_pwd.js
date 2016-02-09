//lancement de JQUERY
$(document).ready(function(){

$('#email_val').blur(function() {
 var reg = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
 if (!reg.test($('#email_val').val())){
	 $('#email_msg').text("Email not valid !");
	 $('#email_val').css("background-color", "red");
 }
 else $('#email_msg').text("");
}); 

$('#pwd_val').blur(function() {
var illegalChars = /[\W_]/; // it allows only letters and numbers 
 if ($('#pwd_val').val().length < 8) {
	   $('#pwd_msg').text("At least 8 characters.");
	   $('#pwd_val').css("background-color", "red");
    } else if (illegalChars.test($('#pwd_val').val())) {
       $('#pwd_msg').text("The password must contain only letters and numbers.");
       $('#pwd_val').css("background-color", "red");
    } 
    else $('#pwd_msg').text("");
}); 

//bouton de switch
	$('.switchBtn').click(function(){
		$('#formLogin').toggle('slow');
		$('#formLost').toggle('slow');
	});

});//(JQUERY)
