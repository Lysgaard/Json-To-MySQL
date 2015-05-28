<?php
error_reporting(E_ALL ^ E_DEPRECATED);
set_time_limit(0);
include('config.php');
	
	//CODE FOR MANUAL
	//QUERY FOR READING DATA BY MANUAL DATE
	//BY THIS QUEYR YOU CAN IMPORT PREVISOUS DATA OF ANY DATE
	
	/*$query = "http://live.glidernet.org/flightlog/index.php?a=EKLV&s=QFE&u=M&z=2&p=&d=15052015&j";
	$date = date('2015-05-15');*/
	
	//CODE FOR AUTOMATIC
	//QUERY FOR READING DATA FROM CURRENT DATE AUTOMATICALLY
	//BY THIS QUERY YOU CAN IMPORT CURRENT DATE DATA
	
	$current_date = date("dmY");
	$date = date('Y-m-d');
	$query = "http://live.glidernet.org/flightlog/index.php?a=EKLV&s=QFE&u=M&z=2&p=&d=$current_date&j";
	
		
	$jsonData = file_get_contents($query);
	$phpArray = json_decode($jsonData, true);
	//print_r($phpArray['flights']);
	
	$airfield = $phpArray['airfield']; 
	$alt_setting = $phpArray['alt_setting'];
	$unit = $phpArray['unit'];
		
	$result = mysql_query("SELECT * FROM flightlog WHERE flight_date = '$date' ");
	if(mysql_num_rows($result) > 0)
	{
		$row = mysql_fetch_object($result);
		$flight_id = $row->flight_id;
	}
	else
	{
		mysql_query("INSERT INTO  flightlog (flight_date, airfield, alt_setting, unit) VALUES ('$date', '$airfield', '$alt_setting', '$unit' ) ");
		$flight_id = mysql_insert_id();
	}
	
		
	$count = count($phpArray['flights']);
	for($i=0;$i<$count;$i++)
	{
		$plane = $phpArray['flights'][$i]['plane'];
		$glider = $phpArray['flights'][$i]['glider'];
		$takeoff = $phpArray['flights'][$i]['takeoff'];
		$plane_landing = $phpArray['flights'][$i]['plane_landing'];
		$glider_landing = $phpArray['flights'][$i]['glider_landing'];
		$plane_time = $phpArray['flights'][$i]['plane_time'];
		$glider_time = $phpArray['flights'][$i]['glider_time'];
		$towplane_max_alt = $phpArray['flights'][$i]['towplane_max_alt'];
		
		if($takeoff != "" && $glider_landing != "" ) {
		
		$result_chk = mysql_query("SELECT * FROM flightlog_details WHERE takeoff = '$takeoff' AND glider_landing = '$glider_landing'  ");
		if(mysql_num_rows($result_chk) == 0)
			mysql_query(" INSERT INTO flightlog_details (flight_id, plane, glider, takeoff, plane_landing, glider_landing, plane_time, glider_time, towplane_max_alt) VALUES 
		('$flight_id', '$plane', '$glider', '$takeoff', '$plane_landing', '$glider_landing', '$plane_time', '$glider_time', '$towplane_max_alt') ");	
		}
	}
	
	
	$result = mysql_query("SELECT * FROM flightlog WHERE flight_date = '$date' ");
	$row = mysql_fetch_object($result);
	
	$result_det = mysql_query("SELECT * FROM flightlog_details WHERE flight_id = '$flight_id' ");
	
	print '<div style="width:100%" align="center">';
	print '<div style="border:2px solid black;width:850px;padding-top:20px;padding-bottom:20px;" align="center" >';
	print '<table border="1px solid black">';
		print '<tr>';
			print '<td width="150">Date : '.date('d/m/Y',strtotime($row->flight_date)).'</td>';
			print '<td width="150">Air Field : '.$row->airfield.'</td>';
			print '<td width="150">Alt Setting : '.$row->alt_setting.'</td>';
			print '<td width="150">Unit : '.$row->unit.'</td>';
		print '</tr>';
	print '</table>';
	print '<br><br>';
	print '<table border="1px solid black">';
	print '<tr>';
			print '<td>Plane</td>';
			print '<td>Glider</td>';
			print '<td>Takeoff</td>';
			print '<td>Plane Landing</td>';
			print '<td>Glider Landing</td>';
			print '<td>Plane Time</td>';
			print '<td>Glider Time</td>';
			print '<td>Towplane Max Alt</td>';
		print '</tr>';
	
	while($row_det = mysql_fetch_object($result_det))
	{
		print '<tr>';
			print '<td>'.$row_det->plane.'</td>';
			print '<td>'.$row_det->glider.'</td>';
			print '<td>'.$row_det->takeoff.'</td>';
			print '<td>'.$row_det->plane_landing.'</td>';
			print '<td>'.$row_det->glider_landing.'</td>';
			print '<td>'.$row_det->plane_time.'</td>';
			print '<td>'.$row_det->glider_time.'</td>';
			print '<td>'.$row_det->towplane_max_alt.'</td>';
		print '</tr>';	
	}
	print '</table>';
	
	print '</div>';
	print '</div>';
?>