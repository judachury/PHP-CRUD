<?php

	$params['id'] = trim($_GET['id']);

	if ($params['id'] > 0) {
		$sql = 'DELETE FROM people WHERE id = ' . $params['id'];
	}

	if ($conn->query($sql)) {
		array_push($alerts, 'Record Deleted successfully');
	} else {
		array_push($alerts, $conn->error);
	}

?>