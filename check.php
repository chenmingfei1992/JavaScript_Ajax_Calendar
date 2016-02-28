<?php
require 'databaseModule5.php';


if(true){
	$username = $mysqli->real_escape_string($_POST['username']);
	$password = $mysqli->real_escape_string($_POST['password']);

	if((!preg_match('/^[\w_\-]+$/',$username)) || (!preg_match('/^[\w_\-]+$/',$password))){
		echo json_encode(array(
			"blank" => true
			));
		exit;
	}
	$stmt = $mysqli->prepare("SELECT  username, password FROM users WHERE username=?");
// Bind the parameter
	$stmt->bind_param('s', $username);
	
	$stmt->execute();
// Bind the results
	$stmt->bind_result($correctName, $correctPassword);
	$stmt->fetch();


	if( crypt($password, $correctPassword)==$correctPassword){
       //Session cookie is HTTP-Only
		ini_set("session.cookie_httponly", 1);
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['token'] = substr(md5(rand()), 0, 10);
		echo json_encode(array(
			"success" => true
			));
		exit;	
	// Failed
	}else{
		echo json_encode(array(
			"success" => false,
			"message" => "Invalid Login"
			));
		exit;  	
	}
	$stmt->close();
}
?>