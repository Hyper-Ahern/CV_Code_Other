<?php
	include "includes/header.php"; 

	if (!isset($_SESSION['role'])) {
		echo "You must be logged in to access this resource";
		die();
	}
?>

	<main role="main">
		<div class="jumbotron">
			<div class="container">
				<h1 class="display-3">ForceCMS Admin: Post Management</h1>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					
				<?php
					if (isset($_GET['source'])) {
						if ($_GET['source'] == 'edit_post') {
							include 'includes/edit_post.php';
						}
					}
					else {
						include 'includes/view_all_posts.php';
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