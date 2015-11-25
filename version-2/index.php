<?php

	//Moved the DB to an external file use only for configuration
	require_once(dirname(__FILE__).'/inc/config.php');

	/*
	 * Make Index the controller for all the different views
	 */

	//Check if the page exist
	if (isset($_GET['page'])) {
		$page = trim($_GET['page']);
	}

	switch ($page) {
		case 'create':
			include_once('views/create.php');
		break;
		case 'update':
			include_once('views/update.php');
		break;
		case 'delete':
			//Delete the record if any error save it in the alert array
			include_once('views/delete.php');
			//Continue displaying all the records
			include_once('views/read.php');
		break;		
		default:
			include_once('views/read.php');
		break;
	}
	

?>

<!-- The view for the page always at the end -->
<!DOCTYPE html>
<html>
	<head>
		<title>CRUD</title>
		<style type="text/css">
			thead {
				font-weight: bold;
			}

			td {
				padding: 10px;
			}
		</style>
	</head>
	<body>
		<header>
			<h1>CRUD</h1>
		</header>
		
		<?php
		//Content is initialised in config.php  and set in the respective view
		 echo $content;
		?>
	</body>
</html>

<?php $conn->close(); ?>