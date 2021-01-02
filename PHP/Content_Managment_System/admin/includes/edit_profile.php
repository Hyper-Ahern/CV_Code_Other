<?php
	//Include a file that processes all profile updates.
	require "includes/submit_profile.php";

	$username = $_SESSION['username'];

	$sql0 = "SELECT * FROM login WHERE username = '$username'";
	$select_login_query = $conn->query($sql0);


	if (!$select_login_query) {
		die ("<p>Sorry. Your request could not be completed.</p>" . $conn->connect_error);
	}
	else {
		while ($row = $select_login_query->fetch_assoc()) {
			$user_id = $row['user_id'];
			$_SESSION['user_id'] = $user_id;
			$password = $row['password'];
		}
	}

	$sql = "SELECT * FROM users WHERE user_id = {$user_id}";
	$edit_post_query = $conn->query($sql);

	if (!$edit_post_query) {
		die ("<p>Sorry. Your request could not be completed.</p>" . $conn->connect_error);
	}
	else {
		while ($row = $edit_post_query->fetch_assoc()) {
			$user_id = $row['user_id'];
			$user_image = $row['user_image'];
			$user_firstname = $row['user_firstname'];
			$user_lastname = $row['user_lastname'];
			$user_role = $row['user_role'];
			$user_email = $row['user_email'];
			$user_address = $row['user_address'];
			$user_phone = $row['user_phone'];

?>
<?php
	/* Get the query string, because we will need to preserve the options when the profile is updated,
	 because it will be processed in the same file. */
	$queryString = $_SERVER['QUERY_STRING'];
?>

	<form action="<?php echo $currentFileName . "?" . $queryString ; ?>" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label for="user_firstname" class="control-label">First Name</label>
					<input type="text" class="form-control" name="user_firstname" value="<?php if(isset($user_firstname)) { echo $user_firstname; } else { echo ''; } ?>">
				</div>
				<div class="form-group">
					<label for="user_lastname">Last Name</label>
					<input type="text" class="form-control" name="user_lastname" value="<?php if(isset($user_lastname)) { echo $user_lastname; } else { echo ''; } ?>">
				</div>
				<div class="form-group">
					<label for="user_role">User Role</label>
					<select class="form-control" name="user_role" disabled="disabled">
						<option value='0' <?php if($user_role === '0') { echo 'selected'; } else { echo ''; } ?>>Administrator</option>
						<option value='1' <?php if($user_role === '1') { echo 'selected'; } else { echo ''; } ?>>Author</option>
						<option value='2' <?php if($user_role === '2') { echo 'selected'; } else { echo ''; } ?>>Subscriber</option>
					</select>
				</div>
			</div>

			<div class="form-group col-lg-6">
				<label for="user_image">Profile Image</label>
					<?php
						if($user_image != "") {
							echo "<br><img width='100' src='../images/{$user_image}' alt='thumbnails'><br><br>";
						}
						else {
							echo "<br>No Profile Image Assigned Yet<br><br><br>";
						}
					?>
				<input type="file" name="user_image">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="user_email">Email</label>
					<input type="text" class="form-control" name="user_email" value="<?php if(isset($user_email)) { echo $user_email; } else { echo ''; } ?>">
				</div>
				<div class="form-group">
					<label for="user_address">Address</label>
					<input type="text" class="form-control" name="user_address" value="<?php if(isset($user_address)) { echo $user_address; } else { echo ''; } ?>">
				</div>
				<div class="form-group">
					<label for="user_phone">Phone</label>
					<input type="text" class="form-control" name="user_phone" value="<?php if(isset($user_phone)) { echo $user_phone; } else { echo ''; } ?>">
				</div>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" name="username" value="<?php if(isset($username)) { echo $username; } else { echo ''; } ?>" disabled="disabled">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" name="password" value="<?php if(isset($password)) { echo $password; } else { echo ''; } ?>">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<input type="submit" class="btn btn-primary" name="update_user" value="Save Updated Profile">
				</div>
			</div>
		</div>
	</form>


<?php
		}
	}
?>