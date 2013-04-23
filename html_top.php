<?php
session_start();
// manual redirection
if ($redirectnow <> "33") {
    if (!isset($_SESSION['uid'])) {
        echo '            
<script type="text/javascript">
<!--
window.location = "login.php"
//-->
</script>
';
    }
}
// header
?><!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title>CoderDojo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="style.css">
        <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-precomposed.png">
    </head>
    <body><?php
// your database details here    
$dbhost = "localhost";
$dbuser = "username";
$dbpass = "password";
$dbname = "database_name";
// connect to DB
$con = mysql_connect($dbhost, $dbuser, $dbpass);
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db($dbname, $con) or die(mysql_error());
?>