<?php
	$db_host = "localhost";
	$db_username = "root";
	$db_password = "root";
	$db_name = "Assignments";

	$conn = new mysqli ($db_host, $db_username, $db_password, $db_name);

	if ($conn->connect_error) {
		die ("Error connecting to the DB.<br>" . $db->connect_error);
	}
	/* For debug purposes only. This is otherwise not required.
	else {
		echo "Connected!";
	}
	*/
?>