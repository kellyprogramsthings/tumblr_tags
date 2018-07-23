<?php

//database connection

//CREATE USER 'tumblrtags'@'localhost' IDENTIFIED BY 'tumblrtagspwd';
//GRANT ALL PRIVILEGES ON *.* TO 'tumblrtags'@'localhost' WITH GRANT OPTION;

$db = new mysqli('localhost', 'tumblrtags', 'tumblrtagspwd', 'tumblr_tags');

?>