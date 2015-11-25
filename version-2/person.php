<?php
	
	


	$params = array();
	if (isset($_GET)) {
		foreach ($_GET as $key => $value) {
			//TODO clean the parameters before they are assigned to the array
			$params[$key] = $value;
		}
	}



?>
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
				<h3>

				</h3>
			</header>
			<form action="#" method="POST">
				<fieldset>
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="id" value="<?php echo $editUser[0]; ?>">
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
	</body>
</html>