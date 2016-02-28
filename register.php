<?php
require 'databaseModule5.php';

    // get informations of user sign up
	$username = $mysqli->real_escape_string($_POST['username']);
	$password = $mysqli->real_escape_string($_POST['password']);
    $alreadyExist = False;
	if((!preg_match('/^[\w_\-]+$/',$username)) || (!preg_match('/^[\w_\-]+$/',$password))){
		echo json_encode(array(
			"blank" => true
			));
		exit;
	}
    
     //check if username already exists
	$newstmt = $mysqli->prepare("select username from users where username=?");
	if(!$newstmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
	}
	$newstmt->bind_param('s', $username);
	$newstmt->execute();		
	$result = $newstmt->get_result();
	while($row = $result->fetch_assoc()){
		if (sizeof($row["username"])>0){ 
			$alreadyExist= True;
			echo json_encode(array(
				"success" => false,
				"message" => "Username is already existed"
				));
			exit;  				
		}
	}
    
    // insert user information into database
    if(!$alreadyExist)
    {
    $saltedPassword = crypt($password);	
	$stmt = $mysqli->prepare("insert into users(username, password) values('$username', '$saltedPassword')");
    if(!$stmt){
			printf("Query Failed: %s\n", $mysqli->error);
			exit;
		}
	
	$stmt->execute();
       //Session cookie is HTTP-Only
		ini_set("session.cookie_httponly", 1);
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['token'] = substr(md5(rand()), 0, 10);
		echo json_encode(array(
			"success" => true
			));
		exit;	
	
	 $stmt->close();

	}

?>