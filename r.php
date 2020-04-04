<?php
include_once('shortURL.php');

if($_REQUEST['c']!='' && trim($_REQUEST['c']) !=''){
    $code = $_GET["c"];
    //var_dump($code);exit;
    try {
        $pdo = new PDO(DB_PDODRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $shortUrl = new ShortURL($pdo);
        try {
            $url = $shortUrl->shortCodeToUrl($code);
            header("Location: " . $url);
            exit;
        }
        catch (Exception $e) {
            // log exception and then redirect to error page.
            header("Location: ".BASE_URL."error.php");
            exit;
        }
    }
    catch (PDOException $e) {
        trigger_error("Error: Failed to establish connection to database.");
        exit;
    }
}else if(strpos($_SERVER['REQUEST_URI'], '/r/') !== false){
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);
    $code =end($uri_segments);
    //var_dump($code);exit;
    
    try {
        $pdo = new PDO(DB_PDODRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $shortUrl = new ShortURL($pdo);
        try {
            $url = $shortUrl->shortCodeToUrl($code);
            header("Location: " . $url);
            exit;
        }
        catch (Exception $e) {
            // log exception and then redirect to error page.
            header("Location: ".BASE_URL."error.php");
            exit;
        }
    }
    catch (PDOException $e) {
        trigger_error("Error: Failed to establish connection to database.");
        exit;
    }
}else{
    header("Location: ".BASE_URL."error.php");
    exit;
}

