$(document).ready(function() {  
    $('form').on('submit', function(e) {
	  	if(grecaptcha.getResponse() === "") {
	    	e.preventDefault();
	    	window.location.href='forget_password?res=recaptcha';
	  	} 
	});
});
