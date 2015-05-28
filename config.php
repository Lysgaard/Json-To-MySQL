<?php 

$host = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_db = "flarm";


//make connection with mysql and select the database
$mysql_connect = mysql_connect($host, $mysql_user, $mysql_password) ;
if(!$mysql_connect) {echo ("<P>Connection issues. No results displayed.</P>");}
$db_select = mysql_select_db($mysql_db);
if(!$db_select) {echo ("<P>Connection issues. No results displayed.</P>");}
?>
