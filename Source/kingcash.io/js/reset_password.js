$(document).ready(function() {  
    $('form').on('submit', function(e) {
    	var token = $("#token").val();
	  	if(grecaptcha.getResponse() === "") {
	    	e.preventDefault();
	    	window.location.href='reset_password?res=recaptcha&token=' + token;
	  	} 
	});
});
