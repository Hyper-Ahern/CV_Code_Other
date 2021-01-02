<?php include "includes/header.php"; ?>


<main role="main">
	<div class="jumbotron">
	<div class="container">
		<h1 class="display-3">ForceCMS: Reporting Issues</h1>
	</div>
	</div>

	<div class="container">
	<!-- Example row of columns -->
	<div class="row">
		<div class="col-md-12">
			<?php
			/*UPDATE: A confirmation message will be printed on the screen when the user submits the form.
			Form processing script is in header.php*/
				if (isset($_GET['issueReported'])) {
					echo "<p class='text-primary space-top-bottom'>Thank you for reporting the issue. Your message has been submitted.</p>";
				}
			?>
			<p class="space-top-bottom">Did you experience any issues when interacting with this website? If so, please let us know.</p>
			<p class="space-top-bottom text-danger">* all form fields are required</p>
			<form method="post" action="report.php">
				<div class="form-group space-top-bottom">
					<label for="preferredName"><strong>Your preferred name</strong> <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="preferredName" name="preferredName" required>
				</div>
				<div class="form-group space-top-bottom">
					<label for="userEmail"><strong>Email address</strong> <span class="text-danger">*</span></label>
					<input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="in the format name@example.com" required>
				</div>
				<div class="form-group space-top-bottom">
					<label for="typeOfIssue"><strong>What type of issue did you experience?</strong> <span class="text-danger">*</span></label>
					<select class="form-control" id="typeOfIssue" name="typeOfIssue" required>
						<option></option>
						<option value="linkNotWorking">Link not working</option>
						<option value="pageNotFound">Page not found</option>
						<option value="incorrectScript">Incorrect script</option>
					</select>
				</div>
				<div class="form-group space-top-bottom">
					<label for="detailedReport"><strong>Detailed report of the issue</strong> <span class="text-danger">*</span></label>
					<textarea class="form-control" id="detailedReport" name="detailedReport" rows="3" required></textarea>
				</div>
				<button id="submitIssue" type="submit" name="submitIssue" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>

	<hr class="space-top-bottom">

	</div> <!-- /end main container -->

</main>

<?php include "includes/footer.php"; ?>