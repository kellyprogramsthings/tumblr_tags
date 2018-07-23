<?php

require_once('database.php');

function writePostToDatabase($db, $tumblrPost) {
	// TODO ADDSLASHES BAD, CHANGE LATER

	//associative array to connect methods (because the variables are private) to column names
	$mapperArray['postId'] = "post_id";
	$mapperArray['content'] = "content";
	$mapperArray['date'] = "date_unix";
	$mapperArray['type'] = "type";
	$mapperArray['externalUrl'] = "external_url";
	$mapperArray['artist'] = "artist";
	$mapperArray['album'] = "album";
	$mapperArray['trackname'] = "trackname";
	$mapperArray['albumArtUrl'] = "album_art_url";
	$mapperArray['linkName'] = "link_name";
	$mapperArray['photoLayout'] = "photo_layout";
	$mapperArray['quoteSource'] = "quote_source";
	$mapperArray['embedCode'] = "embed_code";
	$mapperArray['videoType'] = "video_type";
	$mapperArray['thumbnailUrl'] = "thumbnail_url";

	// Construct a SQL insert statement
	// Example insert statement
	// INSERT INTO tumblr_post (post_id, content, date_unix, type)
	//     VALUES ('175825018824', '', 1531429536, 'video')
	$sql_intro = "INSERT INTO tumblr_post (";
	$sql_midtro = ") VALUES ('";
	$sql_outtro = "')";

	$mappedArray = array();
	foreach ($tumblrPost->getAttributesWithoutArray() as $attribute) {
		$mappedArray[] = addslashes($mapperArray[$attribute]);
	}

	$sql_columns = implode(', ', $mappedArray);

	$attributes = array();
	foreach ($tumblrPost->getAttributesWithoutArray() as $attribute) {
		$attributes[] = addslashes($tumblrPost->{$attribute});
	}

	$sql_values = implode('\', \'', $attributes);

	//return $sql_intro . $sql_columns . $sql_midtro . $sql_values . $sql_outtro;

	$sql_query = $sql_intro . $sql_columns . $sql_midtro . $sql_values . $sql_outtro;

	echo $sql_query . "<br><br>";

	mysqli_query($db, $sql_query);

	writeTagsToDatabase($db, $tumblrPost);
}


function writeTagsToDatabase($db, $tumblrPost) {
	// Construct a SQL insert statement
	// Example insert statement
	// INSERT IGNORE INTO tumblr_tag (name)
	//     VALUES ('peter capaldi'), ('jenna coleman')
	$sql_intro = "INSERT IGNORE INTO tumblr_tag (name) VALUES ('";
	$sql_outtro = "')";

	$tagList = array();
	foreach ($tumblrPost->tags as $tag) {
		$tagList[] = $tag;
	}

	$sql_values = implode('\'), (\'', $tagList);

	$sql_query = $sql_intro . $sql_values . $sql_outtro;

	echo $sql_query;

	mysqli_query($db, $sql_query);
}
?>