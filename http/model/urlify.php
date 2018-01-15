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

/**
* Checks if two URLs have the the same domain.
* @param $ref
*  The first URL
* @param $host
*  The second URL to compare
* @return
*  Whether or not these two URLs have the same domain
**/
function same_origin($ref, $host, $scheme)
{
	# There HAS to be a smarter way
	return substr($ref, 0, strlen($host) + strlen($scheme) + 3) === $scheme . "://" . $host;
}