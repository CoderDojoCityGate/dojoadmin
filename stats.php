<?php
// include header, connect to DB
include ("html_top.php");
// section #1
print "<p style='font-family: Arial;font-size:13px;font-weight:bold;'>List of Attendees per Dojo</p>";
$result = mysql_query("SELECT currdate FROM attended GROUP BY currdate ORDER BY currdate");
while ($row = mysql_fetch_array($result)) {
    $currdate = $row[0];
    $listofnames = "";
    $attendees = 0;
    $result2 = mysql_query("SELECT users.name FROM users, attended WHERE users.id = attended.userid AND attended.currdate = '".$currdate."' ORDER BY name");
    while ($row2 = mysql_fetch_array($result2)) {
        $listofnames .= $row2[0] . ", ";
        $attendees++;
        }
    print "<p style='font-family: Arial;font-size:11px;'><b><font color='#ff0'>" . $row[0] . "</font> - attendees: <font color='#ff0'>".$attendees."</font></b><br><font color='#999'>" . substr($listofnames, 0, -2) . "</font></p>";
}
// section #2
print "<p style='font-family: Arial;font-size:13px;font-weight:bold;'>List of Dojos per Attendee</p>";
$result = mysql_query("SELECT users.id, users.name, users.age FROM users ORDER BY name");
while ($row = mysql_fetch_array($result)) {
    $curruser = $row[0];
    $listofdates = "";
    $dojos = 0;
    $result2 = mysql_query("SELECT currdate FROM attended WHERE userid = $curruser ORDER BY currdate");
    while ($row2 = mysql_fetch_array($result2)) {
        $listofdates .= $row2[0] . ", ";
        $dojos++;
        }
    print "<p style='font-family: Arial;font-size:11px;'><b>[ ".$curruser." ] <font color='#ff0'>" . $row[1] . "</font> (age: " . $row[2] . ") - attended <font color='#ff0'>".$dojos."</font> dojo</b><br><font color='#999'>" . substr($listofdates, 0, -2) . "</font></p>";
}
// footer, close DB connection
include ("html_bottom.php");
?>
