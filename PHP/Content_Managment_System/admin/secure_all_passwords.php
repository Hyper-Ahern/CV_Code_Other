<?php 
	 include "includes/header.php";
	 $sql = "SELECT * FROM login";
	 $sql_query = $conn->query($sql);

	 while ($row = $sql_query->fetch_assoc()) {
		$login_id = $row['login_id'];
		$password = $row['password'];

		if(preg_match('/^\$2y\$/', $password)){

		} else {
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

			$sql2 = "UPDATE login SET password = '$hashedPassword' WHERE login_id = '$login_id'";
			$sql_update = $conn->query($sql2);
		}
	}

	$enc = 1;
	$_SESSION['enc'] = $enc;
	header("location: profile.php?enc=1");
?>