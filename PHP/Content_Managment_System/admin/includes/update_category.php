<?php
	$variables_in_URL = $_SERVER['QUERY_STRING'];
?>

<?php
	// Statements that Update the category in the database
	if (isset($_POST['update_this_cat'])) {
		$cat_title_to_be_updated = htmlspecialchars(stripslashes(trim($_POST['updated_cat_title'])));
		$cat_id_to_be_updated = $_GET['update_category'];

		$sql = "UPDATE category SET cat_title = '$cat_title_to_be_updated' WHERE cat_id = $cat_id_to_be_updated";

		$result_update_category = $conn->query($sql);

		if (!$result_update_category) {
			die("<p><em>Sorry, could not update category!</em></p>" . $conn->error);
		}
		else {
			/************************************************************************************
			 * This is important because it reloads the page, and does not show 
			 * the ID of the updated category in the address bar, after it has been updated.
			 ************************************************************************************/
			header("Location: categories.php");
		}
	}
?>
	<form action="<?php echo $currentFileName . '?' . $variables_in_URL; ?>" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="cat_title">Update category</label>

			<?php
				// Script to update a category that is visible in the HTML table on the right
				if (isset($_GET['update_category'])) {
					$update_this_cat_id = $_GET['update_category'];

					$sql = "SELECT * FROM category WHERE cat_id = $update_this_cat_id";
					$result_select_category = $conn->query($sql);

					if ($result_select_category->num_rows > 0) {
						while ($row = $result_select_category->fetch_assoc()) {
							$update_this_cat_title = $row['cat_title'];
						}
					}
				}
			?>

			<input class="form-control" type="text" name="updated_cat_title" value="<?php if(isset($update_this_cat_title)) { echo $update_this_cat_title; } ?>">

		</div>
		<div class="form-group">
			<input class="btn btn-primary" type="submit" name="update_this_cat" value="Update Category">
		</div>
	</form>
