<?php
	/**
	* Replaces spaces and slashes by '-'
	* @param $input
	* 	the string to be evaluated
	* @return
	*  mixed: false on error
	*         string on success
	*/

	function urlify ($input) {
		if (!is_string($input)) {
			return false;
		}

		return str_replace([' ', '/', '\\'], '-', $input);

	}
?>