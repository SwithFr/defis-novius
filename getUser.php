<?php


require_once "./libs/Model.php";
$DB = new Model();

if (isset($_POST['auth_pseudo'])) {

	$author = $DB->getAuthor($_POST['auth_pseudo']);

	if (!$author) {
		$DB->add([
			"auth_pseudo" => $_POST['auth_pseudo']
		], "author");
	}

	header('location: ' . $_REQUEST['PHP_SELF'] . "interface.php?user=" . $_POST['auth_pseudo']);
}