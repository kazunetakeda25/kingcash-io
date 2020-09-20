<?php
	require_once('mysql_connect.php');
	$query =  "SELECT * FROM `tb_values` WHERE `f_title`='username'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$f_username = $row['f_value'];
		}
	}
	$query =  "SELECT * FROM `tb_values` WHERE `f_title`='password'";
	$result = $conn->query($query);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$f_password = $row['f_value'];
		}
	}
	$username = $_POST['username'];
	$password = $_POST['password'];
	if(($username!=$f_username)||($password!=$f_password)){
		header('Location: ../login?res=info');
		exit;
	}else{
		session_start();
		$_SESSION['id'] = $userdata['f_id'];
		$_SESSION['username'] = $userdata['username'];
		$_SESSION['logged_in'] = "true";
		header('Location: ../dashboard');
		exit;
	}
	$conn->close();
?>