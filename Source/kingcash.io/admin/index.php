<?php
	// if(! isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on")
	// {
	// //Tell the browser to redirect to the HTTPS URL.
	// header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
	// //Prevent the rest of the script from executing.
	// exit;
	// }
	header('Location: login');
	exit;
?>