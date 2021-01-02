<?php
	session_start();

	require_once "includes/db.php";
	require_once "includes/functions.php";
?>

<?php
	/*UPDATE: Initialize variables to hold login status. Include a script named functions.php, 
	in which several re-used functions are available. */
	$currentFileName = basename($_SERVER['PHP_SELF']);
	$loggedIn = false;
	$loginError = false;

	$variables_in_URL = $_SERVER['QUERY_STRING'];

	/* UPDATE: Script to process the "reporting issues" form. This script retrieves information submitted 
	by users through the "Report Issue" form, assembles a message to be submitted, and submits the 
	message (i.e. creates a new file in the folder named "misc".)*/
	if ( isset($_POST['submitIssue']) ) {
		$issueDetail['submittedBy'] = sanitize($_POST['preferredName']);
		$issueDetail['email'] = sanitize($_POST['userEmail']);
		$issueDetail['issueType'] = sanitize($_POST['typeOfIssue']);

		$dateTimeObject = new DateTime("now", new DateTimeZone("America/Halifax"));
		$dateTimeObject->setTimestamp(time()); //adjust the object to correct timestamp
		$issueDetail['issueDate'] = $dateTimeObject->format('d.m.Y');
		$issueDetail['issueTime'] = $dateTimeObject->format('h:i:sa');
		$issueDetail['timeStamp'] = time();

		switch ($issueDetail['issueType']) {
			case "linkNotWorking":
				$issueDetail['issueType'] = "Link not working";
				break;
			case "pageNotFound":
				$issueDetail['issueType'] = "Page not found";
				break;
			case "incorrectScript":
				$issueDetail['issueType'] = "Incorrect script";
				break;
			default:
				$issueDetail['issueType'] = "Issue not reported! OR there was an error!";
		}

		$issueDetail['detailedReport'] = sanitize($_POST['detailedReport']);

		$issueMessage = <<<_ENDISSUEREPORT
Issue Alert!
Type of issue: {$issueDetail['issueType']}

Submitted by: {$issueDetail['submittedBy']}
Email ID: {$issueDetail['email']}
Submitted at: {$issueDetail['issueTime']} - on - {$issueDetail['issueDate']}

Details: {$issueDetail['detailedReport']}
_ENDISSUEREPORT;

/* I am wordwrapping this issueMessage because mail() only goes to 70 characters per line. 
Then I am sending this error report to a random Wookie on Kashyyyk followed by a generic subject line 
(which I considered making the issue type but since it is already in the message that seemed reduncant), 
followed by the message. Finally I am routing the user back to the page that they came from with an additional 
url string to signal that the submission was indeed successful. */
		$msg = wordwrap($issueMessage);
		mail("wookie@Kashyyyk.universe","issue",$msg);
		header("Location: " . $currentFileName . "?issueReported=true");
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
	<link href="css/jumbotron.css" rel="stylesheet">

	<!-- CDN links for Google's Material Icon set -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	<!-- Custom styles for this assignment solution -->
	<link href="css/forceUI.css" rel="stylesheet">
</head>

<body>
	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
		<a class="navbar-brand" href="index.php">ForceCMS</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item <?php if ($currentFileName == 'index.php') { echo "active"; } ?>">
				<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item <?php if ($currentFileName == 'posts.php') { echo "active"; } ?>">
				<a class="nav-link" href="posts.php">Posts</a>
				</li>
				<li class="nav-item <?php if ($currentFileName == 'report.php') { echo "active"; } ?>">
				<a class="nav-link" href="report.php">Report Issues</a>
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

									echo "<a class='dropdown-item' href='category_post.php?c_id=$cat_id'>$cat_title</a>";
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
						<a class="nav-link" href="index.php">View your site</a>
					</li>
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
_END;

				$usermenu2 = <<<_END
						<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a class='dropdown-item' href="admin/profile.php">Profile</a>
							</li>
							<li>
								<a class='dropdown-item' href="admin/includes/logout.php">Log Out</a>
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
							<a class='dropdown-item' href='admin/view_posts.php'>View All Posts</a>
							<a class='dropdown-item' href='admin/add_post.php'>Add Post</a>
						</div>
					</li>
				</ul>
				<a class="nav-link" href="admin/categories.php">Categories</a>
				<a class="nav-link" href="">Comments</a>
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Users</a>
						<div class="dropdown-menu">
							<a class='dropdown-item' href='admin/view_users.php'>View All Users</a>
							<a class='dropdown-item' href='admin/includes/add_user.php'>Add New User</a>
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
							<a class='dropdown-item' href='admin/view_posts.php'>View All Posts</a>
							<a class='dropdown-item' href='admin/add_post.php'>Add Post</a>
						</div>
					</li>
				</ul>
				<a class="nav-link" href="admin/categories.php">Categories</a>
				<a class="nav-link" href="">Comments</a>
			</nav>
		</div>

		<?php
		}

	?>
	</div>
