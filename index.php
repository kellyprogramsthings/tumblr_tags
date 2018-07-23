<html>
<head>
	<title>Uhhh...</title>
</head>

<body>

<?php

// TODO LIST
// 1. captions on photos
// 2. add additional field in database for smaller version saved on same server
// 3. get first frame of animated gif
// 4. Use an ORM (Propel)
// 5. Titles for text posts (and other posts?)


include_once('databaseService.php');

//includes classes as they are called
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.php';
});

//bad, don't do this
error_reporting( error_reporting() & ~E_NOTICE );

$api_key = 'qsoDhK6hYDFaI8HMZsHUZy0DokI4PvNYqv11MTDsxm5u4iX9wr';

$url = 'https://api.tumblr.com/v2/blog/tt-test-dw.tumblr.com/posts?api_key=' . $api_key; // path to your JSON file

$data = file_get_contents($url); // put the contents of the file into a variable
$jsonData = json_decode($data); // decode the JSON feed

$posts = $jsonData->response->posts;

$postCollection = array();

foreach ($posts as $post) {
	$tagCollection = array();
	
	//Tag List
	foreach ($post->tags as $tag) {
		array_push($tagCollection, $tag);
	}

	switch ($post->type) {

		case "photo":
			$tumblrPost = PhotoPost::createWithData($post->id, $post->timestamp, $post->type);

			//Post Content
			$tumblrPost->content = $post->caption;

			//Photo Stuff
			$tumblrPost->photoLayout = $post->photoset_layout;
			$photoCollection = array();

			foreach ($post->photos as $photo) {
				array_push($photoCollection, $photo->original_size->url);
			}

			$tumblrPost->photos = $photoCollection;
			break;

		case "audio":
			$tumblrPost = AudioPost::createWithData($post->id, $post->timestamp, $post->type);

			//Post Content
			$tumblrPost->content = $post->body;

			//Audio Stuff
			$tumblrPost->externalUrl = $post->audio_url;
			$tumblrPost->embedCode = $post->embed;
			$tumblrPost->artist = $post->artist;
			$tumblrPost->album = $post->album;
			$tumblrPost->trackName = $post->track_name;
			$tumblrPost->albumArtUrl = $post->album_art;
			break;

		case "text":
			$tumblrPost = TumblrPost::createWithData($post->id, $post->timestamp, $post->type);

			//Post Content
			$tumblrPost->content = $post->body;
			break;

		case "quote":
			$tumblrPost = QuotePost::createWithData($post->id, $post->timestamp, $post->type);

			//Post Content
			$tumblrPost->content = $post->text;

			//Quote Stuff
			$tumblrPost->quoteSource = $post->source;
			break;

		case "video":
			$tumblrPost = VideoPost::createWithData($post->id, $post->timestamp, $post->type);

			//Post Content
			$tumblrPost->content = $post->body;

			//Video Stuff
			$tumblrPost->externalUrl = $post->video_url;
			$tumblrPost->embedCode = $post->player[0]->embed_code;
			$tumblrPost->videoType = $post->video_type;
			$tumblrPost->thumbnailUrl = $post->thumbnail_url;
			break;

		case "link":
			$tumblrPost = LinkPost::createWithData($post->id, $post->timestamp, $post->type);

			//Post Content
			$tumblrPost->content = $post->description;

			//Link Stuff
			$tumblrPost->linkName = $post->title;
			$tumblrPost->externalUrl = $post->url;
			break;

		case "chat":
			$tumblrPost = TumblrPost::createWithData($post->id, $post->timestamp, $post->type);

			//Post Content
			$tumblrPost->content = $post->body;
			break;
	}
	$tumblrPost->tags = $tagCollection;
	array_push($postCollection, $tumblrPost);
}

//print_r($postCollection);

foreach ($postCollection as $post) {
	writePostToDatabase($db, $post);
}

?>

</body>

</html>