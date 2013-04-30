<?php
// include header, connect to DB
include ("html_top.php");
if (isset($_GET['edit'])) {
    // collect data to show a form with existing information
    print "<h2>Edit Member Details</h2>";
    $did = mysql_real_escape_string($_GET['edit']);
    $result = mysql_query("SELECT * FROM users WHERE id = '$did' LIMIT 1");
    $idrow = mysql_fetch_array($result);
    $dname = $idrow['name'];
    $dage = $idrow['age'];
    $dgname = $idrow['guardian'];
    $dcemail = $idrow['email'];
    $dcphone = $idrow['phonenumber'];
    $dcomputer = $idrow['pcid'];
    $buttontext = "Update";
    // in case we need to add member to today's dojo after updating details
    if (@$_GET['aos'] == '1') {$buttontext .= " & Add";}
} else {
    // show an empty form in order to add new members
    print "<h2>Add New Member</h2>";
    $dname = "";
    $dage = "";
    $dgname = "";
    $dcemail = "";
    $dcphone = "";
    $dcomputer = "";
    $buttontext = "Add";
}

print "<form action='index.php";
// in case we need to add member to today's dojo after updating details
if (@$_GET['aos'] == '1') {print "?add=".$did;}

print "' method='post' >
        Name<br><input type='text' class='typein' name='dname' value=\"".$dname."\"><br>
        Age<br><input type='number' class='typein' name='dage' value='".$dage."'><br>
        Guardian Name<br><input type='text' class='typein' name='dgname' value=\"".$dgname."\"><br>
        Guardian Phone Number<br><input type='text' class='typein' name='dcphone' value='".$dcphone."'><br>
        Contact E-mail Address<br><input type='email' class='typein' name='dcemail' value='".$dcemail."'><br>
        Computer ID(s)<br><input type='text' class='typein' name='dcomputer' value='".$dcomputer."'><br><br>
        <center>
            <input class='largebutton' type='submit' value='".$buttontext."'>
        </center>";

        if (isset($_GET['edit'])) {print "<input type='hidden' name='uid' value='".mysql_real_escape_string($_GET['edit'])."'>";}

print "
      </form>";
// footer, close DB connection
include ("html_bottom.php");
?>
