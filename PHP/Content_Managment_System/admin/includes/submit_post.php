<?php 
	if(isset($_POST['create_post'])) {
		// Retrieve all the form values using the $_POST superglobal.
		$post_author = sanitize($_POST['post_author']);
		$post_title = sanitize($_POST['post_title']);
		$post_category_id = sanitize($_POST['post_category_id']);
		$post_status = sanitize($_POST['post_status']);

		$post_content = sanitize($_POST['post_content']);
		$post_tags = sanitize($_POST['post_tags']);
		$post_comments = 0;

		if($_FILES['post_image']['name'] != "") { 
			$post_image = $_FILES['post_image']['name'];
			$post_image_temp = $_FILES['post_image']['tmp_name'];
			$post_image_filesize = $_FILES['post_image']['size'];

			$target_file = "../images/" . $post_image;

			$post_image_filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			$goodToUpload = true;

			if ($post_image_filetype != 'jpg' && $post_image_filetype != 'png') {
				$goodToUpload = false;
			}

			if ($post_image_filesize < TWO_MEGA_BYTES && $goodToUpload === true) {
				//Upload the image.
				move_uploaded_file($post_image_temp, $target_file);
			}
		} 
		else { 
			//Otherwise, the user has not set any post image.
			$post_image = "";
		} 

		$sql = "INSERT INTO posts(post_cat_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comments, post_status) ";
		$sql .= "VALUES('$post_category_id','$post_title','$post_author',now(),'$post_image','$post_content','$post_tags','$post_comments','$post_status')";


		$submit_post_result = $conn->query($sql);

		if (!$submit_post_result) {
			die ("Error creating post.<br>" . $conn->error . "<br>");
		}
	}

	//CODE TO UPDATE POST AFTER USER SUBMITS THE FORM.
	if(isset($_GET['p_id']) && isset($_POST['update_post'])) {
		// Retrieve all the form values using the $_POST superglobal.
		$post_author = sanitize($_POST['post_author']);
		$post_title = sanitize($_POST['post_title']);
		$post_category_id = sanitize($_POST['post_category_id']);
		$post_status = sanitize($_POST['post_status']);

		$post_image = $_FILES['post_image']['name'];

		$post_content = sanitize($_POST['post_content']);
		$post_tags = sanitize($_POST['post_tags']);
		$post_comments = 0;


		$sql = "SELECT post_image FROM posts WHERE post_id = {$_GET['p_id']}";
		$check_if_image_exists = $conn->query($sql);

		if (!$check_if_image_exists) {
			die ("<p>Sorry. Your request could not be completed. You can see the detailed error report below:</p>" . $conn->error);
		}

		while ($row = $check_if_image_exists->fetch_assoc()) {
			$image_name_check = $row['post_image'];
		}

		if (($image_name_check == "" && $post_image != "") || 
			($image_name_check != "" && $post_image != "" && $image_name_check != $post_image)) {

			$post_image_temp = $_FILES['post_image']['tmp_name'];
			$post_image_filesize = $_FILES['post_image']['size'];

			$target_file = "../images/" . $post_image;

			$post_image_filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			$goodToUpload = true;

			if ($post_image_filetype != 'jpg' && $post_image_filetype != 'png') {
				$goodToUpload = false;
			}

			if ($post_image_filesize < TWO_MEGA_BYTES && $goodToUpload === true) {
				//Upload the image.
				move_uploaded_file($post_image_temp, $target_file);
			}
		}
		else {
			$post_image = $image_name_check;
		}

		$sql = "UPDATE posts SET ";
		$sql .= "post_title = '{$post_title}', ";
		$sql .= "post_cat_id = '{$post_category_id}', ";
		$sql .= "post_date = now(), ";
		$sql .= "post_author = '{$post_author}', ";
		$sql .= "post_status = '{$post_status}', ";
		$sql .= "post_tags = '{$post_tags}', ";
		$sql .= "post_content = '{$post_content}', ";
		$sql .= "post_image = '{$post_image}' ";
		$sql .= "WHERE post_id = '{$_GET['p_id']}'";

		$update_post_result = $conn->query($sql);

		if (!$update_post_result) {
			die ("Error updating post.<br>" . $conn->error . "<br>");
		}
		else {
			//Successfully updated the post - redirect the user to view_post.php
			header("Location: view_posts.php");
		}
	}
