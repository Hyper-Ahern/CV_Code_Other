<?php
	//Code to delete the user
	if(isset($_GET['delete_user'])) {
		$delete_this_user = $_GET['delete_user'];

		$sql = "DELETE FROM login WHERE user_id = {$delete_this_user}";
		$delete_user_login = $conn->query($sql);

		if (!$delete_user_login) {
			die ("<p>Sorry. Could not delete user.</p>" . $conn->error);
		}


		$sql = "DELETE FROM users WHERE user_id = {$delete_this_user}";
		$delete_user_status = $conn->query($sql);

		if (!$delete_user_status) {
			die ("<p>Sorry. Could not delete user.</p>" . $conn->error);
		}
		else {
			/*Because this is a GET query and the page has already loaded, the removed category
			* might still be showing in the table. For this, you need to "refresh" or "reload" 
			* the page. We do so using the header() function. */
			
			/********************************************************************************************
			 * This is important because it reloads the page, and does not show the ID in the address bar.
			 ********************************************************************************************/
			header("Location: view_users.php");
			die();
		}
	}
?><table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>Image</th>
			<th>Username</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Role</th>
			<th>Modify/Delete</th>
		</tr>
	</thead>
	<tbody>

<?php
	$sql = "SELECT * FROM users";
	$select_all_users = $conn->query($sql);

	while ($row = $select_all_users->fetch_assoc()) {
		$user_id = $row['user_id'];
		$user_image = $row['user_image'];
		$user_firstname = $row['user_firstname'];
		$user_lastname = $row['user_lastname'];
		$user_email = $row['user_email'];
		$user_role = $row['user_role'];

		$sql1 = "SELECT * FROM login WHERE user_id = '{$user_id}'";
		$retrieve_userlogin = $conn->query($sql1);

		if (!$retrieve_userlogin) {
			 die ("Error retrieving user info.<br>" . $conn->error . "<br>");
		}

		while ($row1 = $retrieve_userlogin->fetch_assoc()) {
			 $username = $row1['username'];
		}

		echo "<tr>";
		echo "<td>{$user_id}</td>";
		echo "<td>";
		if($user_image != "") { 
			 echo "<img width='100' src='../images/{$user_image}' alt='thumbnails'>"; 
		} 
		else { 
			 echo "<img width='100' src='../images/placeholder.png' alt='thumbnails'>"; 
		}
		echo "</td>";
		echo "<td>{$username}</td>";
		echo "<td>{$user_firstname}</td>";
		echo "<td>{$user_lastname}</td>";
		echo "<td>{$user_email}</td>";

		echo "<td>";
		switch ($user_role) {
			case '0':
				echo "Administrator";
				break;

			case '1':
				echo "Author";
				break;

			case '2':
				echo "Subscriber";
				break;

			default:
				echo "Role not set!";
				break;
		}

		echo "</td>";

		$current_page = basename($_SERVER['PHP_SELF']);
		echo "<td><a href='{$current_page}?source=edit_user&u_id={$user_id}' class='btn btn-primary'>Edit</a>&nbsp;&nbsp;";
		echo "<a href='{$current_page}?delete_user={$user_id}' class='btn btn-danger'>Delete User</a></td>";
		echo "</tr>";
	}
?>

	</tbody>
</table>