<?php
include_once('shortURL.php');

if (!empty($_REQUEST) && $_REQUEST['longurl'] !='' ){
    $url=$_REQUEST['longurl'];

    try {
        $pdo = new PDO(DB_PDODRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);

        $shortUrl = new ShortURL($pdo);
        $shortcode = $shortUrl->convertURlToShortURl($url);
        if($shortcode){
            $html='<p><strong>Short URL:</strong><br/>'.
                    'As a query string: '.BASE_URL.'r.php?c='.$shortcode.'<br/>'.
                    'As a friendly url: '.BASE_URL.'r/'.$shortcode.'</p>';
            
                    echo $html; exit;
        }
    }
    catch (PDOException $e) {
        trigger_error("Error: Failed to establish connection to database.");
        exit;
    }
}