<?php include "includes/header.php"; ?>

<main role="main">
	<div class="jumbotron">
	<div class="container">
		<h1 class="display-3">ForceCMS Admin: Category Management</h1>
	</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-6">

					<!-- Create new category -->
					<form action="<?php echo $currentFileName; ?>" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label for="cat_title">Add new category</label>
							<input class="form-control" type="text" name="cat_title">
						</div>
						<div class="form-group">
							<input class="btn btn-primary" type="submit" name="add_category" value="Add Category">
						</div>
					</form>

					<!-- Edit/Update category -->
					<?php 
						if (isset($_GET['update_category'])) {
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
					<?php
						}
					?>

			</div>
			<div class="col-md-6">
				<!-- Displays table containing available Categories -->
				<?php 
					// Retrieves and prints all categories using these statements
					$sql = "SELECT * FROM category";
					$categories_query_result = $conn->query($sql);

					$category_display_table_header = <<<_END
							<table class="table table-hover">
								<thead>
									<tr>
										<th>ID</th>
										<th colspan="2">Category Title</th>
									</tr>
								</thead>
								<tbody>
_END;

					$category_display_table_footer = <<<_END
								</tbody>
							</table>
_END;

					echo $category_display_table_header;

					if ($categories_query_result->num_rows > 0) {
						while ($row = $categories_query_result->fetch_assoc()) {
							$cat_id = $row['cat_id'];
							$cat_title = $row['cat_title'];
							echo "<tr>";
							echo "<td>$cat_id</td>";
							echo "<td>$cat_title</td>";
							echo "<td class='text-right'><a class='btn btn-info' href='categories.php?update_category=$cat_id'>UPDATE</a>";
							echo "&nbsp;<a class='btn btn-danger' href='categories.php?delete_category=$cat_id'>DELETE</a></td>";
							echo "</tr>";
						}
					}
					else {
						echo "<tr>";
						echo "<td colspan='3'>No categories exist yet.</td>";
						echo "</tr>";
					}
					echo $category_display_table_footer;
				?>


			</div>
		</div>

		<hr>

	</div> <!-- /end main container -->

</main>

<?php include "includes/footer.php"; ?>