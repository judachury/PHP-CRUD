<?php

	//Initiate variables to be used below
	$sql = ''; //Make the respective query for each action
	$alerts = array(); //Add alerts to help the end user undertand what has happened 
	$users = array(); //Store the list of users to display

	//always check if there are people records
	///note that the variable is being overwritten 
	$sql = "SELECT * FROM people";
	//asigned all the results to the user variable
	$users = $conn->query($sql);

	/*$finfo = $users->fetch_fields();

    foreach ($finfo as $val) {
        printf("Name:      %s\n",   $val->name);
        echo '<br>';
        printf("Table:     %s\n",   $val->table);
        echo '<br>';
        printf("Max. Len:  %d\n",   $val->max_length);
        echo '<br>';
        printf("Length:    %d\n",   $val->length);
        echo '<br>';
        printf("charsetnr: %d\n",   $val->charsetnr);
        echo '<br>';
        printf("Flags:     %d\n",   $val->flags);
        echo '<br>';
        printf("Type:      %d\n\n", $val->type);
        echo '<br>';
    }
    $users->fetch_fields();*/

	//Set the view to be printed in the index
	$content .= '<section>
			<header>
				<h3>People</h3>
			</header>
			<div>
				<a href="/CRUD/version-2/person/create">Create new person</a>
			</div>
			<table>
				<thead>
					<tr>';

	$finfo = $users->fetch_fields();

	foreach ($finfo as $val) {
		$content .= '<td>'. $val->name .'</td>';
	}

	$content .= '<td>Action</td><td>Action</td>';
	$content .=	'</tr>
				</thead>
			<tbody>';

	while($user = $users->fetch_assoc()) { 
		$content .=	'<tr>
			<td>'. $user['id'] .'</td>
			<td>'. $user['firstname'] .'</td>
			<td>'. $user['lastname'] .'</td>
			<td><a href="/CRUD/version-2/person/'. $user['id'] .'">edit</a></td>
			<td><a href="/CRUD/version-2/person/'. $user['id'] .'/delete">delete</a></td>
		</tr>';
	}

	$content .= '</tbody>
			</table>
		</section>';

?>