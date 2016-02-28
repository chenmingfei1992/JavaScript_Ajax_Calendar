<?php
//Session cookie is HTTP-Only
ini_set("session.cookie_httponly", 1);
require 'databaseModule5.php';

    // get information of sharing events
	$username = $mysqli->real_escape_string($_POST['username']);
	$share_title = $mysqli->real_escape_string($_POST['share_title']);
	$share_user = $mysqli->real_escape_string($_POST['share_user']);

    // check it is texts
	if((!preg_match('/^[\w_\-]+$/',$share_title))||(!preg_match('/^[\w_\-]+$/',$share_user))){
		echo json_encode(array(
			"blank" => true
			));
		exit;
	}
	// get the event information from database
	$stmt = $mysqli->prepare("SELECT  `event_title`, `event_month`, `event_day`, `event_hour`, `event_minute`,`event_category` FROM events WHERE username=? and event_title=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('ss', $username, $share_title);
	$stmt->execute();
	$stmt->bind_result($event_title, $event_month, $event_day, $event_hour, $event_minute,$event_category);
	$stmt->fetch();
	$stmt->close();
    
    //insert data into the database of share_user
	$new_stmt = $mysqli->prepare("insert into events(username, event_title,event_month,event_day,event_hour,event_minute,event_category) values('$share_user', '$event_title','$event_month','$event_day','$event_hour','$event_minute','$event_category')");
    if(!$new_stmt){
			printf("Query Failed: %s\n", $mysqli->error);
			exit;
		}
	
	$new_stmt->execute();

		echo json_encode(array(
			"success" => true
			));
		exit;	
	
	 $new_stmt->close();

?>