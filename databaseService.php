<?php

require_once('database.php');

function writePostToDatabase($db, $tumblrPost) {
	// TODO 
	// 1. ADDSLASHES BAD, CHANGE LATER
	// 2. Change to ON DUPLICATE KEY UPDATE
	//    Right now it's apparently giving an error that I just ignore >.>
	

	// NOTE
	// 1. Depending on the version of MySQL, "insert ignore" may increase the auto increment
	//    for no good reason (which bothers me, especially if it's going to be doing it
	//    constantly and jacking up the number)

	//associative array to connect methods (because the variables are private) to column names
	$mapperArray['postId'] = "post_id";
	$mapperArray['content'] = "content";
	$mapperArray['date'] = "date_unix";
	$mapperArray['type'] = "type";
	$mapperArray['externalUrl'] = "external_url";
	$mapperArray['artist'] = "artist";
	$mapperArray['album'] = "album";
	$mapperArray['trackName'] = "trackname";
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

	$sql_query = $sql_intro . $sql_columns . $sql_midtro . $sql_values . $sql_outtro;

	//echo $sql_query . "<br><br>";

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

	$sql_values = implode('\'), (\'', $tumblrPost->tags);

	$sql_query = $sql_intro . $sql_values . $sql_outtro;

	//echo $sql_query . "<br><br>";

	mysqli_query($db, $sql_query);

	getIdsForTags($db, $tumblrPost);
}


function getIdsForTags($db, $tumblrPost) {
	//not wild about this, but we'll get there eventually

	// Construct a SQL insert statement
	// Example insert statement
	// SELECT tag_id FROM tumblr_tag WHERE name IN ('doctor who', 'type: text')
	$sql_intro = "SELECT tag_id FROM tumblr_tag WHERE name IN ('";
	$sql_outtro = "')";

	$sql_where = implode('\', \'', $tumblrPost->tags);

	$sql_query = $sql_intro . $sql_where . $sql_outtro;

	//echo $sql_query . "<br><br>";

	$listOfIds = array();
	if ($result = mysqli_query($db, $sql_query)) {
		while ($row = $result->fetch_assoc()) {
			$listOfIds[] = $row['tag_id'];
		}
	}
	else {
		//best error message ever
		die ("You broke it.");
	}

	writeManyToManyTable($db, $tumblrPost, $listOfIds);
}


function writeManyToManyTable($db, $tumblrPost, $listOfIds) {
	// Construct a SQL insert statement
	// Example insert statement
	// INSERT IGNORE INTO tagpost (post_id, tag_id)
	//     VALUES ('176100679368', 1), ('176100679368', 2')
	$postId = $tumblrPost->postId;
	$sql_intro = "INSERT IGNORE INTO tagpost (post_id, tag_id) VALUES ('$postId', ";
	$sql_outtro = ")";

	$sql_values = implode("), ('$postId', ", $listOfIds);

	$sql_query = $sql_intro . $sql_values . $sql_outtro;

	//echo $sql_query . "<br><br>";

	mysqli_query($db, $sql_query);
}

?>