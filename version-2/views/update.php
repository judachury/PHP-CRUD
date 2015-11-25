<?php

	/* 
	 * Update and edit are handle here
	 * Edit means that we are in process of updating a record
	 * Update is when the record is updated
	 */

	$params = array();
	$alerts = array();

	//Clean and move all the parameters, good idea for a function here. TODO = function
	if (isset($_GET)) {
		foreach ($_GET as $key => $value) {
			//TODO clean the parameters before they are assigned to the array
			$params[$key] = trim($value);
		}
	}

	if (isset($_POST['action']) && $_POST['action'] == 'update') {

		foreach ($_POST as $key => $value) {
			//TODO clean the parameters before they are assigned to the array
			$params[$key] = trim($value);
		}

		if (strlen($params['firstname']) > 0 && strlen($params['lastname']) > 0 && $params['id'] > 0) {
			//we need to update all values from the table (except id of course) as we don't know which field has been updated
			$sql = 'UPDATE people SET firstname = "'. $params['firstname'] .'", lastname = "'. $params['lastname'] .'" WHERE id = '. $params['id'];
		}

		if ($conn->query($sql)) {
			array_push($alerts, 'Record updated successfully');
		} else {
			array_push($alerts, $conn->error);
		}
	}
	
	//Check in the DB who is this person to add his/her current values in the form
	if ($params['id'] > 0) {
		$sql = 'SELECT * FROM people WHERE id = '. $params['id'];
		$heading = 'Edit user';
		$result = $conn->query($sql);

		//Make the query and fetch the row, which should be only one.
		if ($result->num_rows > 0) {
			$editUser = $result->fetch_row();
		} else {
			array_push($alerts, $conn->error);
		}

	} else {
		array_push($alerts, 'Something went wrong');
		$action = '';
	}	

	$content .= '<section>
					<header>
						<h3>
							Edit person
						</h3>
					</header>';

	$content .= '<ul>';

	foreach ($alerts as $alert) {
		$content .= '<li>'. $alert .'</li>';
	}

	$content .= '</ul>';


	$content .= '<div><a href="../home">View all people</a></div>
					<form method="POST">
						<fieldset>
							<input type="hidden" name="action" value="update">
							<input type="hidden" name="id" value="'. $editUser[0] .'">
							<div>
								<label for="firstname">Firstname:</label>
								<input id="firstname" type="text" name="firstname" value="'. $editUser[1] .'">
							</div>
							<div>
								<label for="lastname">lastname:</label>
								<input id="lastname" type="text" name="lastname" value="'. $editUser[2] .'">
							</div>
							<div>
								<button type="submit">Submit</button>
							</div>
						</fieldset>
					</form>
				</section>';
?>