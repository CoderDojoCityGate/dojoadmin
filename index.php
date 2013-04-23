<?php
// include header, connect to DB
include ("html_top.php");
// no message means nothing to communicate
$message = "";
$messagex = "";
// handle "ADD NEW ATTENDEE" action
if ($_POST['dname'] && !isset($_POST['uid'])) {
    // collect details
    $dname = mysql_real_escape_string($_POST['dname']);
    $dage = mysql_real_escape_string($_POST['dage']);
    $dgname = mysql_real_escape_string($_POST['dgname']);
    $dcemail = mysql_real_escape_string($_POST['dcemail']);
    $dcphone = mysql_real_escape_string($_POST['dcphone']);
    $dcomputer = mysql_real_escape_string($_POST['dcomputer']);
    // insert to users DB
    $sql = "INSERT INTO users (name, age, guardian, email, phonenumber, pcid) VALUES ('$dname',$dage,'$dgname','$dcemail','$dcphone','$dcomputer')";
    if (mysql_query($sql, $con)) {
        $message = 'New member added';
    } else {
        $messagex = 'Error while adding new member';
    }
    // insert to attended DB (assuming that whoever is newly registered is attending today's dojo)
    $result = mysql_query("SELECT id FROM users WHERE name = '$dname' ORDER BY id desc LIMIT 1");
    $idrow = mysql_fetch_array($result);
    $newid = $idrow[0];
    $sql = "INSERT INTO attended (userid, currdate) VALUES ($newid, DATE(NOW()))";
    mysql_query($sql, $con);
}
// handle "ADD" action (when an already registered user attends today's dojo)
if ($_GET['add']) {
    // collect details
    $did = mysql_real_escape_string($_GET['add']);
    $result = mysql_query("SELECT count(id) FROM users WHERE id = '$did' LIMIT 1");
    $idrow = mysql_fetch_array($result);
    // make sure selected user exists
    if ($idrow[0] == 1) {
        $result2 = mysql_query("SELECT count(id) FROM attended WHERE userid = '$did' AND DATE(currdate) = DATE(NOW())");
        $idrow2 = mysql_fetch_array($result2);
        // make sure user hasn't been added already
        if ($idrow2[0] == 0) {
            $sql = "INSERT INTO attended (userid, currdate) VALUES ($did, DATE(NOW()))";
            mysql_query($sql, $con);
            $message .= " Attendee added";
        }
    }
}
// handle "REMOVE" action (when someone added an attendee to today's dojo by mistake)
if ($_GET['remove']) {
    // collect details
    $did = mysql_real_escape_string($_GET['remove']);
    $result = mysql_query("SELECT count(id) FROM users WHERE id = '$did' LIMIT 1");
    $idrow = mysql_fetch_array($result);
    // make sure selected user exists
    if ($idrow[0] == 1) {
        $result2 = mysql_query("SELECT count(id) FROM attended WHERE userid = '$did' AND DATE(currdate) = DATE(NOW())");
        $idrow2 = mysql_fetch_array($result2);
        // make sure user can be removed
        if ($idrow2[0] == 1) {
            $sql = "DELETE FROM attended WHERE userid = $did AND DATE(currdate) = DATE(NOW()) LIMIT 1";
            mysql_query($sql, $con);
            $message = "Attendee removed";
        }
    }
}
// handle "UPDATE DETAILS" action (for updating users details)
if ($_POST['uid']) {
    // collect details
    $dname = mysql_real_escape_string($_POST['dname']);
    $dage = mysql_real_escape_string($_POST['dage']);
    $dgname = mysql_real_escape_string($_POST['dgname']);
    $dcemail = mysql_real_escape_string($_POST['dcemail']);
    $dcphone = mysql_real_escape_string($_POST['dcphone']);
    $dcomputer = mysql_real_escape_string($_POST['dcomputer']);
    $uid = mysql_real_escape_string($_POST['uid']);
    // insert to users DB
    $sql = "UPDATE users SET name='$dname', age=$dage, guardian='$dgname', email='$dcemail', phonenumber='$dcphone', pcid='$dcomputer' WHERE id=$uid LIMIT 1";
    if (mysql_query($sql, $con)) {
        $message .= ' Details updated';
    } else {
        $messagex = 'Error while updating details';
    }
}
// END OF HANDLE ACTIONS
// START SHOWING HOMEPAGE
$result = mysql_query("SELECT count(id) FROM attended WHERE DATE(currdate) = DATE(NOW())");
$row = mysql_fetch_array($result);
// number of registered attendees for today's dojo
print "<a href='index.php'><h1>" . $row[0] . "</h1></a>";
// show messages if needed
if (strlen($message) > 1) {
    print "<div id='goodnews'>" . $message . "</div>";
}
if (strlen($messagex) > 1) {
    print "<div id='badnews'>" . $messagex . "</div>";
}
// today's date
print "<h2>" . date("jS M Y") . "</h2>";
// Add Attendee button > this leads to the list of registered kids
print "<form action='list.php' method='get'>
        <center>
            <input class='largebutton' type='submit' value='Add Attendee'>
        </center>
      </form>";
// list of registered attendees for today's dojo
if ($row[0] > 0) {
    $listofnames = "";
    $result = mysql_query("SELECT name FROM users, attended WHERE users.id = attended.userid AND DATE(currdate) = DATE(NOW()) ORDER BY name");
    while ($row = mysql_fetch_array($result)) {
        $listofnames .= " ".$row[0] . ",";
    }
    $listofnames = substr($listofnames, 0, -1);
} else {
    $listofnames = "";
}
print "<div id='names'>" . $listofnames . "</div>";
// footer, close DB connection
include ("html_bottom.php");
?>
