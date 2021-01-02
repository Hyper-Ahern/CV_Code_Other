	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Author</th>
				<th>Title</th>
				<th>Category</th>
				<th>Status</th>
				<th>Image</th>
				<th>Tags</th>
				<th>Comments</th>
				<th>Date</th>
				<th>Modify/Delete</th>
			</tr>
		</thead>
		<tbody>

		<?php

			if ($_SESSION['role'] == 0) {
				$sql = "SELECT * FROM posts";
			}
			elseif ($_SESSION['role'] == 1) {
				$author = $_SESSION['username'];
				$sql = "SELECT * FROM posts WHERE post_author = '{$author}'";
			}

			$select_all_posts = $conn->query($sql);

			while ($row = $select_all_posts->fetch_assoc()) {
				$post_id = $row['post_id'];
				$post_author = $row['post_author'];
				$post_title = $row['post_title'];
				$post_cat_id = $row['post_cat_id'];
				$post_status = $row['post_status'];
				$post_image = $row['post_image'];
				$post_content = $row['post_content'];
				$post_tags = $row['post_tags'];
				$post_comments = $row['post_comments'];
				$post_date = $row['post_date'];

				echo "<tr>";
				echo "<td>{$post_id}</td>";
				echo "<td>{$post_author}</td>";
				echo "<td>{$post_title}</td>";
				echo "<td>";

				// Finds the category name using the category ID
				findThisCategory($post_cat_id);   
				echo "</td>";
				echo "<td>{$post_status}</td>";
				echo "<td>";
				if($post_image != "") { 
					echo "<br><img width='100' src='../images/{$post_image}' alt='thumbnails'><br><br>"; 
				} 
				else { 
					echo "No Image Assigned"; 
				}
				echo "</td>";
				echo "<td>{$post_tags}</td>";
				echo "<td>{$post_comments}</td>";
				echo "<td>{$post_date}</td>";
				echo "<td><a href='{$currentFileName}?source=edit_post&p_id={$post_id}' class='btn btn-primary'>Edit</a>&nbsp;&nbsp;";
				echo "<a href='{$currentFileName}?delete_post={$post_id}' class='btn btn-danger'>Delete</a></td>";
				echo "</tr>";
			}
		?>

		</tbody>
	</table>

	<?php
		if(isset($_GET['delete_post'])) {
			$delete_this_post = $_GET['delete_post'];

			$sql = "DELETE FROM posts WHERE post_id = {$delete_this_post}";
			$delete_post_status = $conn->query($sql);

			if (!$delete_post_status) {
				die ("<p>Sorry. Could not delete post.</p>" . $conn->connect_error);
			}
			else {
				/************************************************************************************
				  Because this is a GET query and the page has already loaded, the removed category
				  might still be showing in the table. For this, you need to "refresh" or "reload" 
				  the page. We do so using the header() function.
				 ************************************************************************************/
				header("Location: view_posts.php");
			}
		}
	?>