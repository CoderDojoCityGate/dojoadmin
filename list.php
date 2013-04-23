<?php
// include header, connect to DB
include ("html_top.php");
// title with link to homepage
print "<a href='index.php'><h2>Add Attendee</h2></a>";
// "Add New Member" button for first time visitors
print "<form action='add.php' method='get'>
        <center>
            <input class='largebutton' type='submit' value='Add New Member'>
        </center>
      </form>";
// list of existing attendees
print "<table cellpadding=0 cellspacing=0>";
$result = mysql_query("SELECT users.id, users.name, users.pcid, B.id, users.phonenumber FROM users LEFT JOIN (
    SELECT * FROM attended WHERE DATE(currdate) = DATE(NOW())) as B
ON B.userid = users.id ORDER BY name");
while ($row = mysql_fetch_array($result)) {

    if (($row[3] * 1) > 0) {
        $whattodo = "remove";
    } else {
        $whattodo = "add";
    }

    print "<tr>
    <td>" . $row[1];

    if (strlen($row[2]) > 0) {
        print " <b>(" . $row[2] . ")</b>";
    }

    print "</td>
    <td><form action='";

    if (strlen($row[4]) < 2) {
        if ($whattodo == "add") {
            print "add.php";
        } else {
            print "index.php";
        }
    } else {
        print "index.php";
    }

    print "' method='get'";

    if ($whattodo == "remove") {
        print " onsubmit=\"return confirm('Are you sure?');\"";
    }

    print ">
            <input type='hidden' name='" . $whattodo . "' value='" . $row[0] . "'>
            <input class='largebutton' type='image' src='" . $whattodo;

    // if no phone number exists for current kid, show a register+update button
    if (strlen($row[4]) < 2) {
        if ($whattodo == "add") {
            print "-update";
        }
    }

    print ".png' value='" . $whattodo . "'>";

    // add on submit
    if (strlen($row[4]) < 2) {
        if ($whattodo == "add") {
            print "
        <input type='hidden' name='aos' value='1'>
        <input type='hidden' name='edit' value='" . $row[0] . "'>
    ";
        }
    }
    // enable to Update details
    print "</form></td>
    <td><form action='add.php' method='get'>
            <input type='hidden' name='edit' value='" . $row[0] . "'>
            <input class='largebutton' type='image' src='edit.png' value='Edit'>
      </form></td>
    </tr>
    ";
}

print "</table>
    ";
// footer, close DB connection
include ("html_bottom.php");
?>
