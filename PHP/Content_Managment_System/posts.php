<?php include "includes/header.php"; ?>


<main role="main">
	<div class="jumbotron">
	<div class="container">
		<h1 class="display-3">ForceCMS: Blog Post</h1>
	</div>
	</div>

	<div class="container">
	<!-- Row of columns -->
	<div class="row">
		<div class="col-md-9">

			<?php
				if (isset($_GET['p_id'])) {
					// If everything seems alright, retrieve the post ID and display the post here.
					$post_id = $_GET['p_id'];

					$sql = "SELECT * FROM posts WHERE post_id = $post_id";
					$retrieve_post_result = $conn->query($sql);

					if ($retrieve_post_result->num_rows > 0) {
						while ($row = $retrieve_post_result->fetch_assoc()) {
							$post_title = $row['post_title'];
							$post_author = $row['post_author'];
							$post_date = explode(" ",$row['post_date']);
							$post_image = $row['post_image'];
							$post_content = create_paragraphs_from_DBtext($row['post_content']);
				?>

				<article>
					<h2><a href=""><?php echo $post_title; ?></a></h2>

					<p class="text-secondary small space-top-bottom">
						Posted by <a href=""><?php echo $post_author; ?></a> 
						on <span class="text-primary"><?php echo $post_date[0]; ?></span> 
						at <span class="text-primary"><?php echo $post_date[1]; ?></span>
					</p>

					<?php 
						//Show the post image only if one has been set.
						if ($post_image != "") {
					?>
							<img class="col-md-6 col-no-left-padding" src="images/<?php echo $post_image; ?>" alt="">
							<hr class="space-top-bottom">
					<?php
						}
					?>

					<p><?php echo $post_content; ?></p>
				</article>
				<hr class="space-top-bottom">


				<?php
						}	//Closing the posts "while loop" here.
?>
					
		<div class="jumbotron">
			<div class="container">
			<h3>Leave a Comment</h3>
				<form method="post" action="<?php echo $currentFileName . '?' . $variables_in_URL; ?>">
					<div class="form-group">
						<label for="Author">Author</label>
						<input type="username" class="form-control" id="Author" name="Author" require>
					</div>
					<div class="form-group">
						<label for="Email">Email</label>
						<input type="email" class="form-control" id="Email" name="Email" required>
					</div>
					<div class="form-group">
						<label for="Comment">Comment</label>
						<textarea type="text area" class="form-control" rows="5" id="Comment" name="Comment" required></textarea>
					</div>
					<input type="submit" name="submitComment" value="Submit" class="btn btn-primary">
				</form>
			</div>
		</div>

<?php 

	if(isset($_POST['submitComment'])){

		$author = sanitize($_POST['Author']);
		$email = sanitize($_POST['Email']);
		$comment = sanitize($_POST['Comment']);
		$post_id = sanitize($_GET['p_id']);
		$comment_status = "submitted";

		$sqlComment = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_date, comment_status) VALUES ('$post_id', '$author', '$email', '$comment', now(), '$comment_status')";

		$comment_query = $conn->query($sqlComment);
	
		if (!$comment_query) {
			die ("<p>Sorry. Could not delete user.</p>" . $conn->error);
		}
	}
?>

	<!--PUT NEWLY MADE COMMENT HERE -->

			<?php
				if (isset($_GET['p_id'])) {
					// If everything seems alright, retrieve the post ID and display the post here.
					$post_id = $_GET['p_id'];

					$sql = "SELECT * FROM comments WHERE comment_post_id = $post_id";
					$retrieve_post_result = $conn->query($sql);

					if ($retrieve_post_result->num_rows > 0) {
						while ($row = $retrieve_post_result->fetch_assoc()) {
							$comment_contents = $row['comment_content'];
							$comment_name = $row['comment_author'];
							$comment_time = $row['comment_date'];
						}
				echo "<article>";
					echo "<h5>"; echo $comment_name; echo "&nbsp&nbsp&nbsp&nbsp&nbsp"; echo $comment_time;  echo "</h5>";
					echo "<p class=\"text-secondary small space-top-bottom\">";
						 echo $comment_contents;
						 echo"<hr>";	
					echo "</p>";
				echo "</article>";
					}
				}
				?>
<?php
					}
					else {
						echo "<p>No posts to show!</p>";
					}
				}
				else {
					/* If someone tries to access posts.php without specifying a post ID, they must 
					not be allowed access to the page. So, we redirect them to the home page.*/
					echo "<p>No posts to show!</p>";
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