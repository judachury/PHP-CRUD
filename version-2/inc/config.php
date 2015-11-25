<?php

	$servername = 'xxxxxxxxxxxxx';
	$username = 'xxxxxxxxxxx';
	$password = 'xxxxxxx';

	// Create connection
	$conn = new mysqli($servername, $username, $password);

	// Check connection
	if ($conn->connect_error) {
		die('Connection failed: ' . $conn->connect_error);
	}

	// Select DB from this connection
	if (!$conn->select_db('a3301856_vanilla')) {
		die('Connection failed: ' . $conn->connect_error);
	}

	//set global variables
	define('__ROOT__', dirname(dirname(__FILE__)));
	$alerts = array();
	$content = '';

?>
