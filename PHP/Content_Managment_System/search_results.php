
<?php include "includes/header.php"; ?>

<main role="main">
	<div class="jumbotron">
	<div class="container">
		<h1 class="display-3">ForceCMS: Search Results</h1>
	</div>
	</div>

	<div class="container">
	<!-- Example row of columns -->
	<div class="row">
		<div class="col-md-9">
			<?php
			$search = sanitize($_POST['search_value']);

			if (isset($_POST['search_value'])) {
				//Posts are displayed only if they are published
				if(isset($_POST['Tags'])){
					$sql = "SELECT * FROM posts WHERE post_status = 'published' AND post_tags LIKE '%$search%';";

				} else if (isset($_POST['Categories'])){
					$sql2 = "SELECT cat_id FROM category WHERE cat_title LIKE '%$search%';";
					$retrieve = $conn->query($sql2);

					if ($retrieve->num_rows > 0) {
						while ($row2 = $retrieve->fetch_assoc()) {
							$cat_id = $row2['cat_id'];
						}
					}
					$sql = "SELECT * FROM posts WHERE post_status = 'published' AND post_cat_id = '$cat_id';";

				} else if (isset($_POST['Authors'])){
					$sql = "SELECT * FROM posts WHERE post_status = 'published' AND post_author LIKE '%$search%';";
				}
			}

			$retrieve_post_result = $conn->query($sql);

		if($search != ""){
			if ($retrieve_post_result->num_rows > 0) {
				while ($row = $retrieve_post_result->fetch_assoc()) {
					$post_id = $row['post_id'];
					$post_title = $row['post_title'];
					$post_author = $row['post_author'];
					$post_date = explode(" ",$row['post_date']);
					$post_image = $row['post_image'];
					$post_content = create_paragraphs_from_DBtext($row['post_content']);
					$post_status = $row['post_status'];
			?>

			<article>
				<h3><a href="posts.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h3>
				<p class="text-secondary small space-top-bottom">Posted by <a href=""><?php echo $post_author; ?></a> on <span class="text-primary"><?php echo $post_date[0]; ?></span></p>

				<?php 
					//Show the post image only if one has been set.
					if ($post_image != "") {
				?>
						<img class="col-md-4 col-no-left-padding" src="images/<?php echo $post_image; ?>" alt="">
				<?php
					}
				?>

				<p><?php echo $post_content; ?></p>

				<p><a class="btn btn-secondary" href="posts.php?p_id=<?php echo $post_id; ?>" role="button">View details &raquo;</a></p>
			</article>
			<hr class="space-top-bottom">

			<?php
				}
			}
		}
			?>

		</div>
		<div class="col-md-3">
			<?php 
				/* Panel containing the login form and report issues link */
				include "includes/panel.php"; 
			?>
		</div>
	</div>

	<hr>

	</div> <!-- /end main container -->

</main>

<?php include "includes/footer.php"; ?>