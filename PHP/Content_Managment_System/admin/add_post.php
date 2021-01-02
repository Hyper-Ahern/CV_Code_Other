<?php
	include "includes/header.php"; 
	require_once "../includes/functions.php";
	require "includes/submit_post.php";
?>

<main role="main">
	<div class="jumbotron">
	<div class="container">
		<h1 class="display-3">ForceCMS Admin: Add Post</h1>
	</div>
	</div>

	<div class="container">
	<!-- Example row of columns -->
		<div class="row">
			<div class="col-md-12">

				<form action="<?php echo $currentFileName; ?>" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="title">Post Title</label>
						<input type="text" class="form-control" name="post_title" required>
					</div>
					<div class="form-group">
						<label for="post_category_id">Post Category</label>
						<select class="form-control" name="post_category_id" required>
						<?php
							//Creates category "options" dynamically, in a dropdown list
							categories_into_dropdown_options();
						?>
						</select>
					</div>

					<div class="form-group">
						<label for="author">Post Author</label>
						<input type="text" class="form-control" name="post_author" value="<?php if(isset($_SESSION['role'])) { echo $_SESSION['username']; } ?>">
					</div>

					<div class="form-group">
						<label for="status">Post Status</label>
						<select class="form-control" name="post_status" required>
							<option value="draft">Draft</option>
							<option value="published">Published</option>
						</select>
					</div>

					<div class="form-group col-md-3 col-no-left-padding">
						<label for="post_image">Post Image</label>
						<input type="file" id="post_image" name="post_image">
					</div>

					<div class="form-group">
						<label for="post_tags">Post Tags</label>
						<input type="text" class="form-control" name="post_tags" required>
					</div>

					<div class="form-group">
						<label for="post_content">Post Content</label>
						<textarea class="form-control" name="post_content" id="post_content" cols="30" rows="10"></textarea>
					</div>

					<div class="form-group">
						<input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
					</div>
				</form>

			</div>
		</div>

		<hr>

	</div> <!-- /end main container -->

</main>

<?php include "includes/footer.php"; ?>