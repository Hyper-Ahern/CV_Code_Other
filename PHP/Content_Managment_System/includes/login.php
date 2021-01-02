<?php
	session_start();

	require_once "db.php";
	require_once "functions.php";

	// Process data submitted by login form
	if (isset($_POST['submitLogin'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		$username = sanitize($username);
		$password = sanitize($password);

		if ($username != "" || $password != "") {

			$sql = "SELECT * FROM login WHERE username = '{$username}'";
			$login_result = $conn->query($sql);

			if (!$login_result) {
				die($conn->connect_error); 
			}

			if ($login_result->num_rows == 0) {
				header("Location: ../index.php?loginError=true");
			}


			while ($row = $login_result->fetch_assoc()) {
				$db_id = $row['user_id'];
				$db_username = $row['username'];
				$db_password = $row['password'];

				$checked_password = password_verify($password, $db_password);

				if (!$checked_password) {
					header("Location: ../index.php?loginError=true");
				}
				else {
					//Save previous cookie info, and set new cookie.
					date_default_timezone_set("America/Halifax"); 

					//Hash the user ID here so that we can store the cookie for multiple users.
					$cookie_enc_user_id = hash('md5', $db_id . $db_username);
					$saved_cookie_name = "cms_access_" . $cookie_enc_user_id;

					if (isset($_COOKIE[$saved_cookie_name])) {
						$_SESSION['last_access'] = $_COOKIE[$saved_cookie_name];
					}

					$cookie_name = "cms_access_" . $cookie_enc_user_id;
					$cookie_data = date("d-M-Y") . ", at " . date("h:i:sa");
					setcookie($cookie_name, $cookie_data, time() + (60*60*24*2), "/");

					$_SESSION['username'] = $db_username;

					$sql1 = "SELECT * FROM users WHERE user_id = '{$db_id}'";
					$users_query_result = $conn->query($sql1);

					while ($row1 = $users_query_result->fetch_assoc()) {
						$db_userrole = $row1['user_role'];
						$db_firstname = $row1['user_firstname'];
						$db_lastname = $row1['user_lastname'];
					}

					$_SESSION['firstname'] = $db_firstname;
					$_SESSION['lastname'] = $db_lastname;
					$_SESSION['role'] = $db_userrole;
					$_SESSION['loggedIn'] = TRUE;

					header("Location: ../index.php");
				}
			}
		}
	}
?>