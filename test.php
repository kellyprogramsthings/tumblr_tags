<?php

include_once('databaseService.php');

spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.php';
});

$postUrl = "http://www.test.com";

$test = TumblrPost::createWithUrl($postUrl);

//echo $test->postUrl;

$test->tags = array('one', 'two', 'three');

//echo "<br>" . $test->tags[2];

$differentPost = new VideoPost();

$post = VideoPost::createWithData("post->id", "post->date", "post->type");
//print_r($differentPost);
//print_r($post);

//print_r($post->getAttributes());

writeToDatabase($db, $post);

?>