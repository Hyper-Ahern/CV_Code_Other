<?php include "includes/header.php"; ?>

<main role="main">
	<div class="jumbotron">
	<div class="container">
		<h1 class="display-3">ForceCMS</h1>
		<p>To bring balance to the Force, the Jedi and the Sith need ways to manage their information too, you know?</p>
		<p>Hence, ForceCMS!</p>
	</div>
	</div>

	<div class="container">
	<!-- Example row of columns -->
	<div class="row">
		<div class="col-md-9">
			<?php

			$sql = "SELECT * FROM posts WHERE post_status = 'published'";	//Posts are displayed only if they are published
			$retrieve_post_result = $conn->query($sql);

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