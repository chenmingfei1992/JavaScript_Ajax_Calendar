<?php

ini_set("session.cookie_httponly", 1);
require 'databaseModule5.php';

   //get information of new events
	$username = $mysqli->real_escape_string($_POST['username']);
	$event_title = $mysqli->real_escape_string($_POST['event_title']);
	$event_month = $mysqli->real_escape_string($_POST['event_month']);
	$event_day = $mysqli->real_escape_string($_POST['event_day']);
	$event_hour = $mysqli->real_escape_string($_POST['event_hour']);
	$event_minute = $mysqli->real_escape_string($_POST['event_minute']);
	$event_category = $mysqli->real_escape_string($_POST['event_category']);
    
    //check it is text
	if((!preg_match('/^[\w_\-]+$/',$event_title))|| (!preg_match('/^[\w_\-]+$/',$event_month))||(!preg_match('/^[\w_\-]+$/',$event_day))){
		echo json_encode(array(
			"blank" => true
			));
		exit;
	}
	//insert into table of events
	$stmt = $mysqli->prepare("insert into events(username, event_title,event_month,event_day,event_hour,event_minute,event_category) values('$username', '$event_title','$event_month','$event_day','$event_hour','$event_minute','$event_category')");
    if(!$stmt){
			printf("Query Failed: %s\n", $mysqli->error);
			exit;
		}
	
	$stmt->execute();

		echo json_encode(array(
			"success" => true   // if successful
			));
		exit;	
	
	 $stmt->close();

?>