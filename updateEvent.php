<?php
//Session cookie is HTTP-Only
ini_set("session.cookie_httponly", 1);
require 'databaseModule5.php';

    //CSRF tokens are passed when editing events
    if($_SESSION['token'] == substr(md5(rand()), 0, 10))
	{
 	echo "error";
	die("Request forgery detected");
	}
    
    //get information of editing events
	$username = $mysqli->real_escape_string($_POST['username']);
	$old_title = $mysqli->real_escape_string($_POST['old_title']);
	$new_title = $mysqli->real_escape_string($_POST['new_title']);
	$new_month = $mysqli->real_escape_string($_POST['new_month']);
	$new_day = $mysqli->real_escape_string($_POST['new_day']);
	$new_hour = $mysqli->real_escape_string($_POST['new_hour']);
	$new_minute = $mysqli->real_escape_string($_POST['new_minute']);
	$new_category = $mysqli->real_escape_string($_POST['new_category']);
    
    //check whether it is text
	if((!preg_match('/^[\w_\-]+$/',$new_title))|| (!preg_match('/^[\w_\-]+$/',$new_month))||(!preg_match('/^[\w_\-]+$/',$new_day))){
		echo json_encode(array(
			"blank" => true
			));
		exit;
	}
	
	$stmt = $mysqli->prepare("UPDATE events set event_title=?,event_month=?, event_day=?, event_hour=?, event_minute=?, event_category=? where username='$username' and event_title='$old_title'");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('ssssss', $new_title, $new_month, $new_day,$new_hour,$new_minute, $new_category);
	$stmt->execute();
		echo json_encode(array(
			"success" => true,
			"Old_Title" => $old_title,
			"New_Title" => $new_title,		
			)
		);		
		exit;	
	$stmt->close();

?>