<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
error_reporting(E_ALL ^ E_DEPRECATED);
set_time_limit(0);
include('config.php');
extract($_POST);	

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
	
	print '<div style="width:100%" align="center">';
	print '<div style="border:2px solid black;width:850px;padding-top:20px;padding-bottom:20px;" align="center" >';
	
	print '<form action="show.php" method="post" >';
	print '<table border="1px solid black">';
		print '<tr>';
			print '<td>Select Year</td>';
			print '<td>';
				print '<select name="year" >';
					for($i=2000;$i<= date('Y');$i++)
					if(!empty($year))
					{
						if($year == $i)
							print '<option value="'.$i.'" selected="selected">'.$i.'</option>';
						else
							print '<option value="'.$i.'">'.$i.'</option>';	
					}
					else
						print '<option value="'.$i.'">'.$i.'</option>';	
						
				print '</select>';
			print '</td>';
			print '<td>Select Month</td>';
			print '<td>';
				print '<select name="month" >';
					if(!empty($month))
					{
						if($month == '01')
							print '<option value="01" selected="selected">January</option>';
						else
							print '<option value="01">January</option>';
								
						if($month == '02')
							print '<option value="02" selected="selected">February</option>';
						else
							print '<option value="02">February</option>';
								
						if($month == '03')
							print '<option value="03" selected="selected">March</option>';
						else
							print '<option value="03">March</option>';
							
						if($month == '04')
							print '<option value="04" selected="selected">April</option>';
						else
							print '<option value="04">April</option>';
								
						if($month == '05')
							print '<option value="05" selected="selected">May</option>';
						else
							print '<option value="05">May</option>';
								
						if($month == '06')
							print '<option value="06" selected="selected">June</option>';
						else
							print '<option value="06">June</option>';
								
						if($month == '07')
							print '<option value="07" selected="selected">July</option>';
						else
							print '<option value="07">July</option>';
								
						if($month == '08')
							print '<option value="08" selected="selected">August</option>';
						else
							print '<option value="08">August</option>';
								
						if($month == '09')
							print '<option value="09" selected="selected">September</option>';
						else
							print '<option value="09">September</option>';
								
						if($month == '10')
							print '<option value="10" selected="selected">October</option>';
						else
							print '<option value="10">October</option>';	
							
						if($month == '11')
							print '<option value="11" selected="selected">November</option>';
						else
							print '<option value="11">November</option>';
								
						if($month == '12')
							print '<option value="12" selected="selected">December</option>';
						else
							print '<option value="12">December</option>';
					}
					else
					{
						print '<option value="01">January</option>';
						print '<option value="02">February</option>';
						print '<option value="03">March</option>';
						print '<option value="04">April</option>';
						print '<option value="05">May</option>';
						print '<option value="06">June</option>';
						print '<option value="07">July</option>';
						print '<option value="08">August</option>';
						print '<option value="09">September</option>';
						print '<option value="10">October</option>';	
						print '<option value="11">November</option>';
						print '<option value="12">December</option>';	
					}
				print '</select>';
			print '</td>';
			print '<td><input type="submit" name="search" value="Search"></td>';
		print '</tr>';
	print '</table>';
	print '</form>';
	if(!empty($_POST['search']))
	{
		
		$sql = "SELECT * FROM flightlog,flightlog_details WHERE flightlog.flight_id  = flightlog_details.flight_id AND flight_date like '$year-$month-%'  ";
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
	print '<table border="1px solid black">';
		print '<tr>';
				print '<td>Date</td>';
				print '<td>Plane</td>';
				print '<td>Glider</td>';
				print '<td>Takeoff</td>';
				print '<td>Plane Landing</td>';
				print '<td>Glider Landing</td>';
				print '<td>Plane Time</td>';
				print '<td>Glider Time</td>';
				print '<td>Towplane Max Alt</td>';
				print '<td>Pilot</td>';
				print '<td>Comments</td>';
				print '<td>Edit</td>';
				
			print '</tr>';
	
	$sql = "SELECT * FROM flightlog ";
	if(!empty($_POST['search']))
	{
		$sql .= " WHERE  flight_date like '$year-$month-%'  ";
	}
	$sql .= ' ORDER BY flight_date DESC ';
			
	$result = mysql_query($sql);
	//print $sql;
	while($row = mysql_fetch_object($result)) 
	{
		//print "SELECT * FROM flightlog_details WHERE flight_id = '$flight_id' <br> ";
		$result_det = mysql_query("SELECT * FROM flightlog_details WHERE flight_id = '$row->flight_id' ");
		
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

</body>
</html>