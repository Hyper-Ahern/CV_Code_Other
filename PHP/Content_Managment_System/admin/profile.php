<?php include "includes/header.php"; ?>

	<main role="main">
		<div class="jumbotron">
			<div class="container">
				<h1 class="display-3">ForceCMS: User Profile</h1>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php 
					if($_SESSION['role'] == 0 && isset($_GET['enc'])){
						echo "<p class = \"float-right\"> Passwords Secured!</p>";
					} else if ($_SESSION['role'] == 0 && !isset($_GET['enc'])){
						echo "<a href=\"secure_all_passwords.php\" class=\"btn btn-success float-right\">Secure All Passwords</a>";
					} else {
						echo "nothing";
					}
					?>
					<a href="profile.php?edit=1" class="btn btn-primary float-right" <?php if(isset($_GET['edit']) && $_GET['edit'] == 1) { echo " disabled"; } ?>>Edit Profile</a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					
				<?php

					if (isset($_GET['edit']) && $_GET['edit'] =='1') {

							//If edit profile is enabled, allow user to edit their profile by including "edit_profile.php".
							include 'includes/edit_profile.php';

							/*Also, enable a button that allows them to discard all changes, i.e. in the most simple 
							implementation, it reloads the same page and does not submit any information to the DB. */
							$saveProfileButton = <<<_END
							<div class="col-lg-12 row">
								<p><a href="profile.php?edit=1" class="btn btn-danger">Discard All Changes</a></p>
							</div>
_END;
							echo $saveProfileButton;
					}
					else {
						//Else, simply allow user to view their profile by including "view_profile.php".
						include 'includes/view_profile.php';
					}
				?>

				</div>
			</div>
		</div>
	</main>

<?php
	include "includes/footer.php";
?>