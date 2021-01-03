<?php include "includes/header.php"; ?>

<!-- This is where the search bar and relevant information goes. It is not a header but it is toward the top of the page -->
<main role="main">
	<div class="jumbotron">
	<div class="container">
		<h1 class="display-3">Crawler Google</h1>
		<p>Dalhousie Univeristy Transfer Credit Crawler Search Engine</p>
			<form method="post" action="index.php?">
				<div>
					<input type="username" id="search_value" name="search_value">
					<input type="submit" name="Search" value="Search" class="btn btn-success">
				</div>
			</form>
	</div>
	</div>

	<!-- ALWAYS SANITIZE!! Also, if the search post variable is set, then create the following SQL query with the search value -->
	<?php
		$search = sanitize($_POST['search_value']);

		if (isset($_POST['search_value'])) {
				$sql = "SELECT * FROM lab6 WHERE COL1 LIKE '%$search%' UNION 
				SELECT * FROM lab6 WHERE COL3 LIKE '%$search%' UNION
				SELECT * FROM lab6 WHERE COL5 LIKE '%$search%' UNION
				SELECT * FROM lab6 WHERE COL6 LIKE '%$search%' UNION
				SELECT * FROM lab6 WHERE COL2 = '$search' UNION
				SELECT * FROM lab6 WHERE COL4 = '$search'";
			}

	?>

	<!-- Now that there is either a SQL query or not (blank search bar), execute the query and pring out all the results -->
	<div class="container">
	<div class="row">
		<div class="col-md-9">
			<?php
			// $search_values = 'CHEM 1 General Chemistry'; 
			// $sql = "SELECT * FROM lab6 WHERE COL1 = '$search_values'";
			$search_sql_results = $conn->query($sql);

			// If the search bar isn't empty, iterate through and print out the query return set
			if($search != ""){
				if ($search_sql_results->num_rows > 0) {
					while ($row = $search_sql_results->fetch_assoc()) {
						$host_course = $row['COL1'];
						$host_credit_hours = $row['COL2'];
						$dal_course = $row['COL3'];
						$dal_credit_hours = $row['COL4'];
						$approval_date = $row['COL5'];
						$institution = $row['COL6'];
						$subject = $row['COL7'];
			?>

			<!-- Rudimentary print alignment for concise viewing -->
			<article>
				<?php echo $institution; ?> <br>
				<?php echo $host_course; echo "--- Credit Hours: "; echo $host_credit_hours;?> <br> <br>
				<?php echo "Dalhousie University Equivalent:"; ?> <br>
				<?php echo $dal_course; echo "--- Credit Hours: "; echo $dal_credit_hours; ?> <br>
				<?php echo "Approved: "; echo $approval_date; ?> <br>
				<?php echo "Faculty of:  "; echo $subject; ?> <br> <br>

				<!-- This button does nothing but it COULD do something like have more information if ever this was expanded on -->
				<p><a class="btn btn-secondary" href="posts.php?p_id=<?php echo $host_course; ?>" role="button">View Course Details &raquo;</a></p>
			</article>
			<hr class="space-top-bottom">

			<?php
				}
			}
		}
			?>
		<hr>
	</div>
</main>