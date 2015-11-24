<?php

/**
	There are many things to improve in the code below. However, it helps to visualise how the CRUD would work after some
	refactoring and the introduction of Patterns. A few functions can be added to deal with repeated code or non-existing 
	functionality such as sanitization.
	The main logic of the code is at the top, which helps to other developers to know where things are. The view is by 
	the end of the document to help visualised the webpage in the code and with very little php code (mainly use to get
	the necessary DB values). All in all, it helps to distinguish where things can start to be separated (separation of 
	concerns) and improve overall.

*/


	
/*
 *
 * 	Conect to the database. This connection is using mysqli Object Oriented:
 *  Note how the queries to the $conn object are: $conn->some_method
 *  This is much easier to use as the connection is always saved in the object
 */
	$servername = 'xxxxxxxxxxx';
	$username = 'xxxxxxxxxxx';
	$password = 'xxxxxxxxxxx';

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


/*
 *
 *	Check CRUD HTTP actions: we can make them all POST or GET, but there is a mix
 * - Create: use a POST form
 * - Read: always trigger the query to read all records
 * - Update: use a POST form and only trigger it when edit action is on
 * - Delete: use a GET request
 *
 * - Edit: use a GET request. This is added to make the 
 */

	//Initiate variables to be used below
	$action = ''; //Define the CRUD action
	$sql = ''; //Make the respective query for each action
	$heading = 'Create new user'; //Use to handle editing in the same page
	$result = ''; //Use it when editing by storing the result
	$params = array(); //Use it to clean the values send in the POST or GET request
	$alerts = array(); //Add alerts to help the end user undertand what has happened 
	$editUser = array(); //Store the User to be edited and get it from the query result->fetch_row()
	$users = array(); //Store the list of users to display

	//assing the respetive action to the variable
	if (isset($_POST['action'])) {
		$action = $_POST['action'];
	} elseif (isset($_GET['action'])) {
		$action = $_GET['action'];
	}

	//This is the main CRUD functionality, but read which is triggered every time except when on editing
	switch ($action) {
		case 'create':
			
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
		break;
		case 'update':

			$params['id'] = trim($_POST['id']);
			$params['firstname'] = trim($_POST['firstname']);
			$params['lastname'] = trim($_POST['lastname']);

			if (strlen($params['firstname']) > 0 && strlen($params['lastname']) > 0 && $params['id'] > 0) {
				//we need to update all values from the table (except id of course) as we don't know which field has been updated
				$sql = 'UPDATE people SET firstname = "'. $params['firstname'] .'", lastname = "'. $params['lastname'] .'" WHERE id = '. $params['id'];
			}

			if ($conn->query($sql)) {
				array_push($alerts, 'Record updated successfully');
			} else {
				array_push($alerts, $conn->error);
			}

		break;
		case 'delete':

			$params['id'] = trim($_GET['id']);

			if ($params['id'] > 0) {
				$sql = 'DELETE FROM people WHERE id = ' . $params['id'];
			}

			if ($conn->query($sql)) {
				array_push($alerts, 'Record Deleted successfully');
			} else {
				array_push($alerts, $conn->error);
			}
			
		break;
		case 'edit':
			
			$params['id'] = trim($_GET['id']);

			if ($params['id'] > 0) {
				$sql = 'SELECT * FROM people WHERE id = '. $params['id'];
				$heading = 'Edit user';
				$result = $conn->query($sql);

				//Make the query and fetch the row, which should be only one.
				if ($result->num_rows > 0) {
					$editUser = $result->fetch_row();
					array_push($alerts, 'editing user');
				} else {
					array_push($alerts, $conn->error);
				}
			} else {
				array_push($alerts, 'Something went wrong');
				$action = '';
			}	

		break;
	}


	if ($action != 'edit') {
		//always check if there are people records
		///note that the variable is being overwritten 
		$sql = "SELECT * FROM people";
		//asigned all the results to the user variable
		$users = $conn->query($sql);
	}

	//Debugging area
	//print_r($sql);
	//print_r($alerts);
	//print_r($editUser);
	

?>

<!-- The view for the page always at the end -->

<!DOCTYPE html>
<html>
	<head>
		<title>CRUD</title>
	</head>
	<body>
		<header>
			<h1>CRUD</h1>
		</header>
		<section>
			<header>
				<h3><?php echo $heading; ?>
				</h3>
			</header>
			<ul>
				<?php foreach ($alerts as $alert) { ?>
					<li><?php echo $alert; ?></li>
				<?php } ?>
			</ul>
			<form action="#" method="POST">
				<fieldset>
					<?php if ($action != 'edit' && count($editUser) > 0) { ?>
						<input type="hidden" name="action" value="create">
					<?php } else { ?>
						<input type="hidden" name="action" value="update">
						<input type="hidden" name="id" value="<?php echo $editUser[0]; ?>">
					<?php } ?>
					<div>
						<label for="firstname">Firstname:</label>
						<input id="firstname" type="text" name="firstname" value="<?php echo $editUser[1]; ?>">
					</div>
					<div>
						<label for="lastname">lastname:</label>
						<input id="lastname" type="text" name="lastname" value="<?php echo $editUser[2]; ?>">
					</div>
					<div>
						<button type="submit">Submit</button>
					</div>
				</fieldset>
			</form>
		</section>
		<?php if ($users->num_rows > 0) { ?>
		<section>
			<header>
				<h3>View all users</h3>
			</header>
			<table>
				<thead>
					<tr>
						<td></td>
					</tr>
				</thead>
				<tbody>

					<?php while($user = $users->fetch_assoc()) { ?>
					<tr>
						<td><?php echo $user['id'] ?></td>
						<td><?php echo $user['firstname'] ?></td>
						<td><?php echo $user['lastname'] ?></td>
						<td><a href="?action=edit&id=<?php echo $user['id'] ?>">edit</a></td>
						<td><a href="?action=delete&id=<?php echo $user['id'] ?>">delete</a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</section>
		<?php } ?>
	</body>
</html>

<?php $conn->close(); ?>