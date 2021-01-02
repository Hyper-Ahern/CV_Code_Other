<?php include "includes/header.php"; ?>

	<main role="main">
		<div class="jumbotron">
			<div class="container">
				<h1 class="display-3">ForceCMS Admin: User Management</h1>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					
				<?php 
					$add_new_users = explode("&", $_SERVER['QUERY_STRING']); 

					if(isset($_SERVER['QUERY_STRING']) && $add_new_users[0] != "source=add_user") {
				?>

				<a href="includes/add_user.php" class="btn btn-primary float-right" style="margin-bottom: 20px;">Add User</a>

				<?php
					}
				?>
					
				<?php
					if (isset($_GET['source'])) {
						if ($_GET['source'] == 'edit_user') {
							include 'includes/edit_user.php';
						}
					}
					else {
						include 'includes/view_all_users.php';
					}
				?>

				</div>
			</div>
		</div>
	</main>

<?php include "includes/footer.php"; ?>
<?php
	ob_end_flush();
?>