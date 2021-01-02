<?php
	/* 
	 * @func: sanitize()
	 * @desc: Function to sanitize data.
	 * @param: $sanitizeThisThing = form input data to be sanitized;
	 * @return: $sanitizedThing = data that has been sanitized.
	 */

	function sanitize ($sanitizeThisThing) {
		$sanitizedThing = trim($sanitizeThisThing);
		$sanitizedThing = stripslashes($sanitizedThing);
		$sanitizedThing = htmlspecialchars($sanitizedThing);
		return $sanitizedThing;
	}


	/*
	 * delete_category($category_id)
	 * - A function that deletes a specified category from the table named "category".
	 * - @input: $category_id: ID of category to be deleted
	 * - @return: TRUE, if operation was successful; FALSE, otherwise.
	 */
	function delete_category($category_id) {
		global $conn;

		$sql = "DELETE FROM category WHERE cat_id = $category_id";

		$result_delete_category = $conn->query($sql);

		if (!$result_delete_category) {
			echo "<p><em>Sorry, the category could not be deleted!</em></p>" . $conn->error;
			return FALSE;
		}
		else {
			return TRUE;
		}
	}


	/*
	 * insert_category($category_title)
	 * - A function that inserts a specified category title into the table named "category".
	 * - @input: $category_title: title of newly created category
	 * - Does not return anything.
	 */
	function insert_category($category_title) {
		global $conn;

		$category_title = sanitize($category_title);

		if (empty($category_title)) {
			echo "<p></em>Category title cannot be empty!</em></p>";
		}
		else {
			$sql = "INSERT INTO category(cat_title) VALUES('$category_title')";

			$result_create_category = $conn->query($sql);

			if (!$result_create_category) {
				die("<p><em>Sorry, could not create category!</em></p>" . $conn->error);
			}
		}
	}


	/*
	 * findThisCategory($category_id)
	 * - A function that finds all categories from the table named "category".
	 * - @input: $category_id: ID of category to be deleted
	 */
	function findThisCategory($category_id){
		global $conn;

		$sql = "SELECT * FROM category WHERE cat_id = {$category_id}";
		$select_one_category_query = $conn->query($sql);

		while ($row = $select_one_category_query->fetch_assoc()) {
			$cat_id = $row['cat_id'];
			$cat_title = $row['cat_title'];
			echo "{$cat_title}";
		}
	}


	/*
	 * categories_into_dropdown_options()
	 * - A function that finds all categories saved in the table named "category".
	 * - Echos/prints each category in the form of an <option>, that can be included 
	 * within the <select> HTML element to create drop-down selection options in a form.
	 */
	function categories_into_dropdown_options() {
		global $conn;

		$sql = "SELECT * FROM category";
		$categories_query_result = $conn->query($sql);

		if ($categories_query_result->num_rows > 0) {
			while ($row = $categories_query_result->fetch_assoc()) {
				$cat_id = $row['cat_id'];
				$cat_title = $row['cat_title'];
				echo "<option value='$cat_id'>$cat_title</option>";
			}
		}
		else {
			echo "No categories exist yet.";
		}
	}


	/*
	 * categories_into_dropdown_options_selected($catId)
	 * - A function that finds all categories saved in the table named "category".
	 * - Echos/prints each category in the form of an <option>, that can be included 
	 * within the <select> HTML element to create drop-down selection options in a form.
	 * - Selects one of the categories.
	 */
	function categories_into_dropdown_options_selected($catId) {
		global $conn;

		$sql = "SELECT * FROM category";
		$categories_query_result = $conn->query($sql);

		if ($categories_query_result->num_rows > 0) {
			while ($row = $categories_query_result->fetch_assoc()) {
				$cat_id = $row['cat_id'];
				$cat_title = $row['cat_title'];

				if ($cat_id == $catId) {
					echo "<option value='$cat_id' selected>$cat_title</option>";
				}
				else {
					echo "<option value='$cat_id'>$cat_title</option>";
				}
			}
		}
		else {
			echo "No categories exist yet.";
		}
	}


	/*
	 * create_paragraphs_from_DBtext()
	 * - A function that takes text data from the database table and returns a 
	 * string with several paragraphs, instead of new line characters or line-breaks.
	 * - Returns sanitized data ($content).
	 */
	function create_paragraphs_from_DBtext($content) {
		$content = nl2br($content, false);
		$content = str_replace( '<br><br>', '</p><p>', $content );
		$content = str_replace( '<br>', '</p><p>', $content );
		return $content;
	}
?>