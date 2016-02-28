<?php
//Session cookie is HTTP-Only
ini_set("session.cookie_httponly", 1);
require 'databaseModule5.php';
   
    //get information of group events
	$group_member_1 = $mysqli->real_escape_string($_POST['group_member_1']);
	$group_member_2 = $mysqli->real_escape_string($_POST['group_member_2']);
	$group_member_3 = $mysqli->real_escape_string($_POST['group_member_3']);
	$group_member_4 = $mysqli->real_escape_string($_POST['group_member_4']);
	$group_member_5 = $mysqli->real_escape_string($_POST['group_member_5']);
	$event_title = $mysqli->real_escape_string($_POST['event_title']);
	$event_month = $mysqli->real_escape_string($_POST['event_month']);
	$event_day = $mysqli->real_escape_string($_POST['event_day']);
	$event_hour = $mysqli->real_escape_string($_POST['event_hour']);
	$event_minute = $mysqli->real_escape_string($_POST['event_minute']);
	$event_category = $mysqli->real_escape_string($_POST['event_category']);
    

    // check it is events
	if((!preg_match('/^[\w_\-]+$/',$event_title))|| (!preg_match('/^[\w_\-]+$/',$event_month))||(!preg_match('/^[\w_\-]+$/',$event_day))){
		echo json_encode(array(
			"blank" => true
			));
		exit;
	}
    

    //insert into database along with the usernames--group members
	$stmt_1 = $mysqli->prepare("insert into events(username, event_title,event_month,event_day,event_hour,event_minute,event_category) values('$group_member_1', '$event_title','$event_month','$event_day','$event_hour','$event_minute','$event_category')");
    if(!$stmt_1){
			printf("Query Failed: %s\n", $mysqli->error);
			exit;
		}
	$stmt_1->execute();
    $stmt_1->close();

    $stmt_2 = $mysqli->prepare("insert into events(username, event_title,event_month,event_day,event_hour,event_minute,event_category) values('$group_member_2', '$event_title','$event_month','$event_day','$event_hour','$event_minute','$event_category')");
    if(!$stmt_2){
			printf("Query Failed: %s\n", $mysqli->error);
			exit;
		}
	$stmt_2->execute();
    $stmt_2->close();

    $stmt_3 = $mysqli->prepare("insert into events(username, event_title,event_month,event_day,event_hour,event_minute,event_category) values('$group_member_3', '$event_title','$event_month','$event_day','$event_hour','$event_minute','$event_category')");
    if(!$stmt_3){
			printf("Query Failed: %s\n", $mysqli->error);
			exit;
		}
	$stmt_3->execute();
    $stmt_3->close();

    $stmt_4 = $mysqli->prepare("insert into events(username, event_title,event_month,event_day,event_hour,event_minute,event_category) values('$group_member_4', '$event_title','$event_month','$event_day','$event_hour','$event_minute','$event_category')");
    if(!$stmt_4){
			printf("Query Failed: %s\n", $mysqli->error);
			exit;
		}
	$stmt_4->execute();
    $stmt_4->close();

    $stmt_5 = $mysqli->prepare("insert into events(username, event_title,event_month,event_day,event_hour,event_minute,event_category) values('$group_member_5', '$event_title','$event_month','$event_day','$event_hour','$event_minute','$event_category')");
    if(!$stmt_5){
			printf("Query Failed: %s\n", $mysqli->error);
			exit;
		}
	$stmt_5->execute();
    $stmt_5->close();


	echo json_encode(array(
			"success" => true
			));
	exit;	
	
	 

?>