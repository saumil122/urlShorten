<?php
/*
 * Author name: Saumil Nagariya
 * Repo: https://github.com/saumil122/urlShorten.git
 */

// db options
define('DB_NAME', 'urlShorten');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');
define('DB_TABLE', 'urlShorten');
define('DB_PDODRIVER', 'mysql');

// connect to database


// base location of script (include trailing slash)
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/urlShorten/');
define('ASSETS_URL', BASE_URL.'assets');

// change to limit short url creation to a single IP
define('LIMIT_TO_IP', $_SERVER['REMOTE_ADDR']);

// change to TRUE to start tracking referrals
define('TRACK_URL', FALSE);

// check if URL exists first
define('CHECK_URL', FALSE);

// change the shortened URL allowed characters
define('ALLOWED_CHARS', '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');