<?php

$redirectnow = "33";
include ("html_top.php");

$username = "dojo2";
$password = "pword";
$uid = "123";
$message = '';

if ($_POST['usern']) {
    // collect details
    $usern = $_POST['usern'];
    $passw = $_POST['passw'];
    if (($usern == $username) && ($passw == $password)) {
        $_SESSION['uid'] = $uid;
        echo '            
<script type="text/javascript">
<!--
window.location = "index.php"
//-->
</script>
';
    } else {
        $message = 'Incorrect login details';
    }
}

print "
<center><img src='logo.jpg' style='height:40%;width:40%;max-height:256px;max-width:256px;'></center>
<form action='login.php' method='post'>
        <p class='loginform'>
            Username: <input type='text' name='usern'><br>
            Password: <input type='password' name='passw'><br>
        </p>";

if (strlen($message) > 0) {
    print "<center><font color='#f00'>" . $message . "</font></center>";
}

print "<center><input type='submit' value='Login' class='largebutton'></center>
</form>";

include ("html_bottom.php");
?>
