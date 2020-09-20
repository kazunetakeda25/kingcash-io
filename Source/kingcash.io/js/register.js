$(document).ready(function() {  
    $('form').on('submit', function(e) {
    	var password = $("#password").val();
    	var confirm_password = $("#confirm_password").val();
    	if(password!=confirm_password){
    		window.location.href='register?res=pwd';
    	}
    	/*
	  	if(grecaptcha.getResponse() === "") {
	     	e.preventDefault();
	     	window.location.href='register?res=recaptcha';
	  	}*/ 
	});
});
