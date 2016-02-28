<?php
 //Session cookie is HTTP-Only
ini_set("session.cookie_httponly", 1);
require 'databaseModule5.php';
    
    //CSRF tokens are passed when removing events
   	if($_SESSION['token'] == substr(md5(rand()), 0, 10))
	{
 	echo "error";
	die("Request forgery detected");
	}

	$username = $mysqli->real_escape_string($_POST['username']);
	$delete_title = $mysqli->real_escape_string($_POST['delete_title']);

    // check it is text
	if(!preg_match('/^[\w_\-]+$/',$delete_title)){
		echo json_encode(array(
			"blank" => true
			));
		exit;
	}
	//delete from the table
	$stmt = $mysqli->prepare("delete from events where username=? and event_title=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('ss', $username,$delete_title);
	$stmt->execute();
		echo json_encode(array(
			"success" => true,	
			)
		);		
		exit;	
	$stmt->close();

?>