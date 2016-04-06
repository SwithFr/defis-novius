<?php

function d($var) {
	echo '<pre style="border:1px solid red">';
	print_r($var);
	echo '</pre>';
}

?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>YEAH</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/foundation/6.2.0/foundation.min.css">
	<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div>
	<div class="row">
		<h1>Novius Sound</h1>
	</div>
	<form action="getUser.php" method="post">
		<div class="row login">
			<div class="columns">
				<input name="auth_pseudo" type="text" placeholder="Name">
				<input type="submit" value="GO"/>
			</div>
		</div>
	</form>
</div>

</body>
</html>