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