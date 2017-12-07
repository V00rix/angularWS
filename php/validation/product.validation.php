<?php /* Product related validations */
// includes
$root = $_SERVER['DOCUMENT_ROOT'] . '/angularWS/php/';

// classes
include_once $root . '/classes/Exceptions/exceptions.php';

// validation
include_once $root . '/validation/common.validation.php';

function validateReview($review) {
	// Review title length constraints
	$minTitleLength = 5;
	$maxTitleLength = 20;

	// Review description constraints
	$minDescriptionLength = 25;
	$maxDescriptionLength = 200;

	// review object
	if (!isset($review))
		throw new argumentMissingException("Missing Review");

	// review title
	if (!isset($review->title))
		throw new argumentMissingException("Missing Review Title");
	checkStringLength($review->title, $minTitleLength, $maxTitleLength, "Title Length");
	
	// review description
	if (!isset($review->description))
		throw new argumentMissingException("Missing Review Description");
	checkStringLength($review->description, $minDescriptionLength, $maxDescriptionLength, "Description Length");

	// review date
	if (!isset($review->date))
		throw new argumentMissingException("Missing Review Date");
	
	// TODO: check date

	// review rating
	if (!isset($review->rating))
		throw new argumentMissingException("Missing Review Rating");
	inRange($review->rating, 1, 5, "Rating");

	// review user/username
	if (!isset($review->user) || !isset($review->user->username) )
		throw new argumentMissingException("Missing User");
}
 ?>