<?php
	require_once "includes/submit_post.php"; 

	$queryString = $_SERVER['QUERY_STRING'];

	//CODE TO FETCH THE POST, WHICH USER INTENDS TO UPDATE.
	if(isset($_GET['p_id'])) {
		$sql = "SELECT * FROM posts WHERE post_id = {$_GET['p_id']}";
		$edit_post_query = $conn->query($sql);

		if (!$edit_post_query) {
			die ("<p>Sorry. Your request could not be completed.</p>" . $conn->connect_error);
		}
		else {
			while ($row = $edit_post_query->fetch_assoc()) {
				$post_id = $row['post_id'];
				$post_author = $row['post_author'];
				$post_title = $row['post_title'];
				$post_category_id = $row['post_cat_id'];
				$post_status = $row['post_status'];
				$post_image = $row['post_image'];
				$post_content = $row['post_content'];
				$post_tags = $row['post_tags'];
				$post_comments = $row['post_comments'];
				$post_date = $row['post_date'];

?>
		<h3 class="display-4 text-primary">Edit Post</h3>
		<hr>

		<form action="<?php echo $currentFileName . "?" . $queryString; ?>" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="title">Post Title</label>
				<input type="text" class="form-control" name="post_title" value="<?php if(isset($post_title)) { echo $post_title; } else { echo ''; } ?>">
			</div>
			<div class="form-group">
				<label for="post_category_id">Post Category</label>
				<select class="form-control" name="post_category_id" required>
				<?php
					// Creates category "options" dynamically, in a dropdown list
					categories_into_dropdown_options_selected($post_category_id);
				?>
				</select>
			</div>

			<div class="form-group">
				<label for="author">Post Author</label>
				<input type="text" class="form-control" name="post_author" value="<?php if(isset($post_author)) { echo $post_author; } else { echo $_SESSION['username']; } ?>">
			</div>

			<div class="form-group">
				<label for="status">Post Status</label>
				<select class="form-control" name="post_status" required>
					<option value="draft" <?php if(isset($post_status) && ($post_status == 'draft')) { echo 'selected'; } ?> >Draft</option>
					<option value="published" <?php if(isset($post_status) && ($post_status == 'published')) { echo 'selected'; } ?> >Published</option>
				</select>
			</div>

			<div class="form-group col-md-3 col-no-left-padding">
				<label for="post_image">Post Image</label>
				<?php 
					if($post_image != "") { 
						echo "<br><img width='100' src='../images/{$post_image}' alt='thumbnails'><br><br>"; 
					} 
					else { 
						echo "<br>No Image Assigned Yet<br>"; 
					} 
				?>

				<input type="file" id="post_image" name="post_image">
			</div>

			<div class="form-group">
				<label for="post_tags">Post Tags</label>
				<input type="text" class="form-control" name="post_tags" value="<?php if(isset($post_tags)) { echo $post_tags; } else { echo ''; } ?>">
			</div>

			<div class="form-group">
				<label for="post_content">Post Content</label>
				<textarea class="form-control" name="post_content" id="post_content" cols="30" rows="10"><?php if(isset($post_content)) { echo $post_content; } else { echo ''; } ?></textarea>
			</div>

			<div class="form-group">
				<input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
			</div>
		</form>

<?php
			}
		}
	}
?>
