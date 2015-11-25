<?php
	
	$content = '';
	$dirs = array_filter(glob('*'), 'is_dir');


	foreach ($dirs as $subdir) {
		$content .= '<li><a href="'. $subdir .'">'. $subdir .'</a></li>';
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
		<ul>
			<?php echo $content; ?>
		</ul>
	</body>
</html>