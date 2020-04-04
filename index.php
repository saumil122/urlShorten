<?php
include_once('config.php');
?>
<!DOCTYPE html>
<html lang="en" xml:lang="en" xmlns="https://www.w3.org/1999/xhtml"  >
<head>
<title>URL Shorten</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

<link type="text/css" rel="stylesheet" href="<?php echo ASSETS_URL;?>/css/main.css" />
<script type="text/javascript" src="<?php echo ASSETS_URL;?>/js/jquery.min.js"></script>
</head>
<body class="alignCenter">
<div class="mainContainer">
    <div class="headingWrapper">
    <h1>URL Shorten</h1>
    </div>
    <div class="formWrapper">
        <p>Enter the URL to generate the shorten URL!</p>
        <form action="<?php echo BASE_URL;?>formSubmit.php" id="urlForm" method="post">
            <div class="fieldWrapper">
                <input type="text" name="url" id="url" placeholder="http://" value="" />
                <input type="submit" id="generateURL" value="Submit"/>
            </div>
        </form>
        <div id="generateShortURL" class="hide alignLeft">&nbsp;</div>
    </div>
</div>
<script type="text/javascript" src="<?php echo ASSETS_URL;?>/js/main.js"></script>
</body>
</html>