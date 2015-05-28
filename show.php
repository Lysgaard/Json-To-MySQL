<html>
<head>
<link href="css/style.css" rel="stylesheet" type="text/css" />


  <link rel="stylesheet" href="css/jquery-ui.css">
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script type="text/javascript" src="js/__jquery.tablesorter.min.js"></script> 
</head>
<body>
	<?php 
	error_reporting(E_ALL ^ E_DEPRECATED);
	set_time_limit(0);

	include('config.php');
	extract($_POST);	

	?>
	<script type="text/javascript">
  $(function() {
    var availableTags = [
	<?php $sql = "SELECT * FROM flightlog,flightlog_details WHERE flightlog.flight_id = flightlog_details.flight_id group by glider";
	$result = mysql_query($sql);
	while($row = mysql_fetch_object($result))
	{
		 echo '"'.$row->glider.'",';
	} ?>
	];
	$( "#reg" ).autocomplete({
	source: availableTags
	});
	});
	</script>
	<?php


if(!empty($update))
{
	mysql_query("UPDATE flightlog_details SET
	plane = '$plane',
	glider = '$glider',
	takeoff = '$takeoff',
	plane_landing = '$plane_landing',
	glider_landing = '$glider_landing',
	plane_time = '$plane_time',
	glider_time = '$glider_time',
	towplane_max_alt = '$towplane_max_alt',
	pilot = '$pilot',
	comments = '$comments'
	WHERE id = '$id'
	 ");	
}
	if(isset($_POST["from"]) || isset($_POST["to"])){
		$from = $_POST["from"];
		$to = $_POST["to"];
	}
	else{
		$from = "";
		$to = "";
	}
	if(isset($_POST['registration'])){
		$reg = $_POST["registration"];
	}
	else{
		$reg = "";
	}

	print '<div style="width:100%" align="center">';
	print '<div style="border:2px solid black;width:850px;padding-top:20px;padding-bottom:20px;" align="center" >';
	
	print '<form action="show.php" method="post" >';
	print '<table border="1px solid black">';
		print '<tr>';
			print '<td>*Date from</td>';
			print '<td>';
				print "<input type = 'date' value = '$from' name = 'from'>";
			print '</td>';		
			print '<td>*Date to</td>';
			print '<td>';
				print "<input type = 'date' name = 'to' value = '$to'>";
			print '</td>';
		
			print '<td>Registration:</td>';
			print '<td>';
				print "<input id = 'reg' style = 'width:100px' value = '$reg' name = 'registration'>";
			print '</td>';
			print '<td><input type="submit" name="search" value="Filter"></td>';
		print '</tr>';
	print '</table>';
	print '</form>';
	if(!empty($_POST['search']))
	{
		
		if(empty($_POST['from'] && empty($_POST['to'] && empty($_POST['registration']  )))){
			$sql = "SELECT * FROM flightlog,flightlog_details WHERE flightlog.flight_id  = flightlog_details.flight_id";
		

		}
		if(!empty($_POST['registration'])){
		
				$sql = "SELECT * FROM flightlog,flightlog_details WHERE flightlog.flight_id  = flightlog_details.flight_id  and glider = '".$_POST['registration']."'  ";
			
		}
		if(!empty($_POST['from'] && !empty($_POST['to'] && !empty($_POST['registration'])))){
			$sql = "SELECT * FROM flightlog,flightlog_details WHERE flightlog.flight_id  = flightlog_details.flight_id AND flight_date  >= '".$_POST['from']."' and flight_date <= '".$_POST['to']."' and glider = '".$_POST['registration']."'   ";
		}
		
		

		$result = mysql_query($sql);
		$total_hour = 0;
		$total_min = 0;
		while($row = mysql_fetch_object($result))
		{
			$g_time = explode('h',$row->glider_time);
			$total_hour += $g_time[0];
			$total_min += $g_time[1];
		}
		
		$total_hour += floor($total_min / 60);
		$total_min = $total_min % 60;
		
		print '<h3>Total Gliding Time : '.$total_hour.'h'.$total_min.'</h3>';
	
	}	
	print '<table id = "myTable" border="1px solid black">';
	print '<thead>';
		print '<tr>';
				print '<th>Date</td>';
				print '<th>Plane</td>';
				print '<th>Glider</td>';
				print '<th>Takeoff</td>';
				print '<th>Plane Landing</td>';
				print '<th>Glider Landing</td>';
				print '<th>Plane Time</td>';
				print '<th>Glider Time</td>';
				print '<th>Towplane Max Alt</td>';
				print '<th>Pilot</td>';
				print '<th>Comments</td>';
				print '<th>Edit</td>';
				
			print '</tr>';
			print '</thead>';
	
	$sql = "SELECT * FROM flightlog  ";
	if(!empty($_POST['search']))
	{
		if(!empty($_POST['from'] && !empty($_POST['to']))){
			$sql .= " WHERE  flight_date  >= '".$_POST['from']."' and flight_date <= '".$_POST['to']."' ";
		}
		else{
			$sql = "SELECT * FROM flightlog  ";
		}
	}
	$sql .= ' ORDER BY flight_date DESC ';
			
	$result = mysql_query($sql);
	
	while($row = mysql_fetch_object($result)) 
	{
		//print "SELECT * FROM flightlog_details WHERE flight_id = '$flight_id' <br> ";

		if(!empty($_POST['registration'])){
			$result_det = mysql_query("SELECT * FROM flightlog_details WHERE flight_id = '$row->flight_id'  and glider = '".$_POST['registration']."' ");
		}
		else{
			$result_det = mysql_query("SELECT * FROM flightlog_details WHERE flight_id = '$row->flight_id'");
		}
		
		/*print '<table border="1px solid black">';
			print '<tr>';
				print '<td width="150">Date : '.date('d/m/Y',strtotime($row->date)).'</td>';
				print '<td width="150">Air Field : '.$row->airfield.'</td>';
				print '<td width="150">Alt Setting : '.$row->alt_setting.'</td>';
				print '<td width="150">Unit : '.$row->unit.'</td>';
			print '</tr>';
		print '</table>';
		print '<br><br>';*/
		
		
		while($row_det = mysql_fetch_object($result_det))
		{
			print '<tr>';
				print '<td>'.$row->flight_date.'</td>';
				print '<td>'.$row_det->plane.'</td>';
				print '<td>'.$row_det->glider.'</td>';
				print '<td>'.$row_det->takeoff.'</td>';
				print '<td>'.$row_det->plane_landing.'</td>';
				print '<td>'.$row_det->glider_landing.'</td>';
				print '<td>'.$row_det->plane_time.'</td>';
				print '<td>'.$row_det->glider_time.'</td>';
				print '<td>'.$row_det->towplane_max_alt.'</td>';
				print '<td>'.$row_det->pilot.'</td>';
				print '<td>'.$row_det->comments.'</td>';
				print "<td><a href='edit.php?id=$row_det->id'>Edit</a></td>";
			print '</tr>';	
		}
		
	}
	print '</table>';
	print '</div>';
	print '</div>';
	
?>
<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
); 
    
</script>
</body>
</html>