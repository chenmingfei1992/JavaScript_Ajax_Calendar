<?php

// connect to the database

$mysqli = new mysqli('localhost', 'chenmingfei', 'chenmingfei', 'module5');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>