<?php
	session_start();

	// Start output buffer, in case you don't know when you might need to call header() function.
	ob_start();

	require_once "../includes/db.php";
	require_once "../includes/functions.php";

	const TWO_MEGA_BYTES = 2097152;
	$currentFileName = basename($_SERVER['PHP_SELF']);


	// Check if user is logged in:
	if(!isset($_SESSION['loggedIn'])) {
		header("Location: ../index.php?unauthAccess=true");
		die();
	}

	// Check if the user is either administrator or author:
	if(($_SESSION['role'] == 2) && (basename($_SERVER['PHP_SELF']) != "profile.php")) {
		header("Location: ../index.php?unauthAccess=true&subAccess=true");
		die();
	}

	$variables_in_URL = $_SERVER['QUERY_STRING'];

	// Function call that submits the category to the database
	if (isset($_POST['add_category'])) {
		$cat_title = $_POST['cat_title'];

		insert_category($cat_title);
	}

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

	// Delete a category when the "delete" button is pressed
	if (isset($_GET['delete_category'])) {
		$delete_this_category = $_GET['delete_category'];

		$delete_cat_status = delete_category($delete_this_category);

		if ($delete_cat_status) {
			/*Because this is a GET query and the page has already loaded, the removed category might 
			still be showing in the table. To update the HTML table being displayed, you need to 
			"refresh" or "reload" the page. We do so using the header() function. */
			/************************************************************************************
			 * This is important because it reloads the page, and does not show 
			 * the ID of the deleted category in the address bar, after it has been deleted.
			 ************************************************************************************/
			header("Location: categories.php");
		}
	}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- This favicon is downloaded/used from the Dalhousie website (https://www.dal.ca), accessible through the URL set as the value of HREF -->
	<link rel="icon" href="https://cdn.dal.ca/etc/designs/dalhousie/clientlibs/global/default/images/favicon/favicon.ico.lt_cf5aed4779c03bd30d9b52d875efbe6c.res/favicon.ico">

	<title>ForceCMS</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<!-- Custom styles for this template -->
	<link href="../css/jumbotron.css" rel="stylesheet">

	<!-- CDN links for Google's Material Icon set -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	<!-- Custom styles for this assignment solution -->
	<link href="../css/forceUI.css" rel="stylesheet">
</head>

<body>
	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
		<a class="navbar-brand" href="../index.php">ForceCMS</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item <?php if ($currentFileName == 'index.php') { echo "active"; } ?>">
				<a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item <?php if ($currentFileName == 'posts.php') { echo "active"; } ?>">
				<a class="nav-link" href="../posts.php">Posts</a>
				</li>
				<li class="nav-item <?php if ($currentFileName == 'report.php') { echo "active"; } ?>">
				<a class="nav-link" href="../report.php">Report Issues</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Categories</a>
					<div class="dropdown-menu">

					<?php
							$sql = "SELECT * FROM category";
							$categories_query_result = $conn->query($sql);

							if ($categories_query_result->num_rows > 0) {
								while ($row = $categories_query_result->fetch_assoc()) {
									$cat_id = $row['cat_id'];
									$cat_title = $row['cat_title'];

									echo "<a class='dropdown-item' href='../category_post.php?c_id=$cat_id'>$cat_title</a>";
								}
							}
							else {
								echo "No categories exist yet.";
							}
					?>
					</div>
				</li>
				<?php
					if (isset($_SESSION['role'])) {
						if (($_SESSION['role'] == 0) || ($_SESSION['role'] == 1)) {
							echo "<li class='nav-item'><a class='nav-link' data-toggle='collapse' data-target='#control-panel' href='#'>Control Panel</a></li>";
						}
					}
				?>
			</ul>

			<!-- User Profile -->
			<?php if(isset($_SESSION['loggedIn'])) {
				$usermenu1 = <<<_END
				<ul class="navbar-nav pull-right">
					<li class="nav-item">
						<a class="nav-link" href="../index.php">View your site</a>
					</li>
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
_END;

				$usermenu2 = <<<_END
						<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a class='dropdown-item' href="profile.php">Profile</a>
							</li>
							<li>
								<a class='dropdown-item' href="includes/logout.php">Log Out</a>
							</li>
						</ul>
					</li>
				</ul>
_END;
				echo $usermenu1 . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . $usermenu2;
			}
			?>
		</div>
	</nav>



	<div id="control-panel" class="collapse">

	<!-- List of Admin-only/Author-only navigation items -->
		<?php
		if ($_SESSION['role'] == 0) { 
			//Nav for Admin only
		?>

		<div class="nav-scroller bg-white box-shadow">
			<nav class="nav nav-underline">
				<a class="nav-link active text-info" href="#"><strong>Admin Control Panel</strong></a>
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Posts</a>
						<div class="dropdown-menu">
							<a class='dropdown-item' href='view_posts.php'>View All Posts</a>
							<a class='dropdown-item' href='add_post.php'>Add Post</a>
						</div>
					</li>
				</ul>
				<a class="nav-link" href="categories.php">Categories</a>
				<a class="nav-link" href="">Comments</a>
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Users</a>
						<div class="dropdown-menu">
							<a class='dropdown-item' href='view_users.php'>View All Users</a>
							<a class='dropdown-item' href='includes/add_user.php'>Add New User</a>
						</div>
					</li>
				</ul>
			</nav>
		</div>

		<?php
		}
		elseif ($_SESSION['role'] == 1) { 
			//Nav for Author only
		?>

		<div class="nav-scroller bg-white box-shadow">
			<nav class="nav nav-underline">
				<a class="nav-link active text-info" href="#"><strong>Author Control Panel</strong></a>
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Posts</a>
						<div class="dropdown-menu">
							<a class='dropdown-item' href='view_posts.php'>View All Posts</a>
							<a class='dropdown-item' href='add_post.php'>Add Post</a>
						</div>
					</li>
				</ul>
				<a class="nav-link" href="categories.php">Categories</a>
				<a class="nav-link" href="">Comments</a>
			</nav>
		</div>

		<?php
		}

	?>
	</div>
