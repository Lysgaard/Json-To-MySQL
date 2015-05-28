<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<?php

$auth_realm = 'Login';

require_once 'auth.php';

echo "You've logged in as {$_SESSION['username']}<br>";
echo '<p><a href="?action=logOut">LogOut</a></p>'

?>
<body>
<?php
error_reporting(E_ALL ^ E_DEPRECATED);
include('config.php');
extract($_GET);
$sql = "SELECT * FROM flightlog_details WHERE id = '$id' ";
$result = mysql_query($sql);
$row = mysql_fetch_object($result);

	print '<div style="width:100%" align="center">';
	print '<div style="border:2px solid black;width:850px;padding-top:20px;padding-bottom:20px;" align="center" >';


print '<form action="show.php" method="post" >';
	print '<table border="1px solid black">';
		print '<tr>';
			print '<td>Plane</td>';
			print "<td><input type=\"text\" name=\"plane\" value=\"$row->plane\" ></td>";
		print '</tr>';	
		
		print '<tr>';
			print '<td>Glider</td>';
			print "<td><input type=\"text\" name=\"glider\" value=\"$row->glider\" ></td>";
		print '</tr>';
			
		print '<tr>';
			print '<td>Takeoff</td>';
			print "<td><input type=\"text\" name=\"takeoff\" value=\"$row->takeoff\" ></td>";
		print '</tr>';
		
		print '<tr>';
			print '<td>Plane Landing</td>';
			print "<td><input type=\"text\" name=\"plane_landing\" value=\"$row->plane_landing\" ></td>";
		print '</tr>';
		
		print '<tr>';
			print '<td>Glider Landing</td>';
			print "<td><input type=\"text\" name=\"glider_landing\" value=\"$row->glider_landing\" ></td>";
		print '</tr>';
		
		print '<tr>';
			print '<td>Plane Time</td>';
			print "<td><input type=\"text\" name=\"plane_time\" value=\"$row->plane_time\" ></td>";
		print '</tr>';
		
		print '<tr>';
			print '<td>Glider Time</td>';
			print "<td><input type=\"text\" name=\"glider_time\" value=\"$row->glider_time\" ></td>";
		print '</tr>';
		
		print '<tr>';
			print '<td>Towplane Max Alt</td>';
			print "<td><input type=\"text\" name=\"towplane_max_alt\" value=\"$row->towplane_max_alt\" ></td>";
		print '</tr>';
		
		print '<tr>';
			print '<td>Pilot</td>';
			print "<td><input type=\"text\" name=\"pilot\" value=\"$row->pilot\" ></td>";
		print '</tr>';
		
		print '<tr>';
			print '<td>Comments</td>';
			print "<td><input type=\"text\" name=\"comments\" value=\"$row->comments\" ></td>";
		print '</tr>';
		
		print "<input type=\"hidden\" name=\"id\" value=\"$id\" >";
		
		print '<tr>';
			print "<td><input type=\"button\" onclick=\"javascript:location.href='show.php'\" value=\"Back\" ></td>";
			print "<td><input type=\"submit\" name=\"update\" value=\"Update\" ></td>";
		print '</tr>';
		
	print '</table>';
print '</form>';


	print '</div>';
	print '</div>';
	
?>

</body>
</html>