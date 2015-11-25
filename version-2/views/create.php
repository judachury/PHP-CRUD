<?php
	
	$sql = '';
	$params  = array();
	$alerts = array();
	
	if (isset($_POST['action']) && $_POST['action'] === 'create') {

		//For demonstration only. These values need to be sanitized later
		$params['firstname'] = trim($_POST['firstname']);
		$params['lastname'] = trim($_POST['lastname']);

		//this should be handle by the server validation beforehand, but to demonstrate concepts is good
		if (strlen($params['firstname']) > 0 && strlen($params['lastname']) > 0) {
			$sql = 'INSERT INTO people (firstname, lastname) VALUES ("'. $params['firstname'] .'", "'. $params['lastname'] .'")';
		} 

		//Create the new record and add some messages for the end user
		if ($conn->query($sql)) {
			array_push($alerts, 'New record created successfully');
		} else {
			array_push($alerts, $conn->error);
		}
	}

	$content .= '<section>
					<header>
						<h3>
							Create person
						</h3>
					</header>';
		
	if (count($alerts) > 0) {
		$content .= '<ul>';

		foreach ($alerts as $alert) {
			$content .= '<li>'. $alert .'</li>';
		}

		$content .= '</ul>';
	}

	$content .= '<div><a href="../home">View all people</a></div>
					<form method="POST">
						<fieldset>
							<input type="hidden" name="action" value="create">
							<input type="hidden" name="id" >
							<div>
								<label for="firstname">Firstname:</label>
								<input id="firstname" type="text" name="firstname">
							</div>
							<div>
								<label for="lastname">lastname:</label>
								<input id="lastname" type="text" name="lastname">
							</div>
							<div>
								<button type="submit">Submit</button>
							</div>
						</fieldset>
					</form>
				</section>';

?>