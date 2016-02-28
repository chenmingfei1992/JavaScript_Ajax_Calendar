<?php

 //Session cookie is HTTP-Only
ini_set("session.cookie_httponly", 1);
require 'databaseModule5.php';


	$username = $mysqli->real_escape_string($_POST['username']);
	//select posted events
	$stmt = $mysqli->prepare("SELECT  `event_title`, `event_month`, `event_day`, `event_hour`, `event_minute`, `event_category` FROM events WHERE username=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$result = $stmt->get_result();
	$result_array= array();
	

	//Safe from XSS attacks; that is, all content is escaped on output 
	$result_array = array_map('htmlentities', $result_array);
	while($row = $result->fetch_assoc()){
		$result_array[] =$row;
	}
	echo json_encode($result_array);
	exit;
	$stmt->close();

?>