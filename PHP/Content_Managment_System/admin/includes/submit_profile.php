<?php 
	//CODE TO UPDATE THE PROFILE AFTER USER SUBMITS THE FORM.
	if(isset($_POST['update_user'])) {
		// Retrieve all the form values using the $_POST superglobal.
		$user_firstname = sanitize($_POST['user_firstname']);
		$user_lastname = sanitize($_POST['user_lastname']);
		$user_address = sanitize($_POST['user_address']);
		$user_phone = sanitize($_POST['user_phone']);
		$user_email = sanitize($_POST['user_email']);

		$user_image = $_FILES['user_image']['name'];
		$user_image_temp = $_FILES['user_image']['tmp_name'];
		$user_image_filesize = $_FILES['user_image']['size'];


		$sql = "SELECT user_image FROM users WHERE user_id = {$_SESSION['user_id']}";
		$check_if_image_exists = $conn->query($sql);

		if (!$check_if_image_exists) {
			die ("<p>Sorry. Your request could not be completed. You can see the detailed error report below:</p>" . $conn->error);
		}

		while ($row = $check_if_image_exists->fetch_assoc()) {
			$image_name_check = $row['user_image'];
		}

		if (($image_name_check == "" && $user_image != "") || 
			($image_name_check != "" && $user_image != "" && $image_name_check != $user_image)) {

			$post_image_temp = $_FILES['user_image']['tmp_name'];
			$post_image_filesize = $_FILES['user_image']['size'];

			$target_file = "../images/" . $user_image;

			$post_image_filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			$goodToUpload = true;

			if ($post_image_filetype != 'jpg' && $post_image_filetype != 'png') {
				$goodToUpload = false;
			}

			if ($post_image_filesize < TWO_MEGA_BYTES && $goodToUpload === true) {
				//Upload the image.
				move_uploaded_file($post_image_temp, $target_file);
			}
		}
		else {
			$user_image = $image_name_check;
		}

		$sql = "UPDATE users SET ";
		$sql .= "user_firstname = '{$user_firstname}', ";
		$sql .= "user_lastname = '{$user_lastname}', ";
		$sql .= "user_email = '{$user_email}', ";
		$sql .= "user_address = '{$user_address}', ";
		$sql .= "user_phone = '{$user_phone}', ";
		$sql .= "user_image = '{$user_image}' ";
		$sql .= "WHERE user_id = '{$_SESSION['user_id']}'";

		$update_post_result = $conn->query($sql);

		if (!$update_post_result) {
			die ("Error updating user.<br>" . $conn->error . "<br>");
		}

		header("Location: profile.php");
		die();
	}

?>