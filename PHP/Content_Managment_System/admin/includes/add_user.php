<?php
	include "header_add_user.php"; 
	//Include the code to submit user data.
	require "./submit_user.php";
?>

	<main role="main">
		<div class="jumbotron">
			<div class="container">
				<h1 class="display-3">ForceCMS Admin: Add User</h1>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<form action="<?php echo $currentFileName; ?>" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="user_firstname" class="control-label">First Name</label>
									<input type="text" class="form-control" name="user_firstname">
								</div>
								<div class="form-group">
									<label for="user_lastname">Last Name</label>
									<input type="text" class="form-control" name="user_lastname">
								</div>
								<div class="form-group">
									<label for="user_role">User Role</label>
									<select class="form-control" name="user_role">
										<option value='0'>Administrator</option>
										<option value='1'>Author</option>
										<option value='2'>Subscriber</option>
									</select>
								</div>
							</div>

							<div class="form-group col-lg-6">
								<label for="user_image">Profile Image</label>
								<input type="file" name="user_image">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="user_email">Email</label>
									<input type="text" class="form-control" name="user_email">
								</div>
								<div class="form-group">
									<label for="user_address">Address</label>
									<input type="text" class="form-control" name="user_address">
								</div>
								<div class="form-group">
									<label for="user_phone">Phone</label>
									<input type="text" class="form-control" name="user_phone">
								</div>
								<div class="form-group">
									<label for="username">Username</label>
									<input type="text" class="form-control" name="username">
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control" name="password">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<input type="submit" class="btn btn-primary" name="create_user" value="Add User">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<p><a href="<?php echo $currentFileName; ?>" class="btn btn-danger">Discard All Changes</a></p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<p><a href="../view_users.php" class="btn btn-info">Go back to view all users</a></p>
								</div>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</main>

<?php include "footer_add_user.php"; ?>