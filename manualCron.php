<?php
error_reporting(E_ALL ^ E_DEPRECATED);
set_time_limit(0);
include('config.php');

 
 if(!empty($_POST['submit']))
 // Start date
 {
 	extract($_POST);
	 $date = "$year-01-01";
 	// End date
 	$end_date = date('Y-m-d');
 
	 while (strtotime($date) <= strtotime($end_date)) {
	
	 $current_date = date ("dmY", strtotime($date));
	 $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
	 
	
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
			if($airfield != "" && $alt_setting != "" && $unit != "" )
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
	 
	 }
	 
 }
?>

<form method="post" action="manualCron.php">

<input type="text" name="year"  />
<input type="submit" name="submit" value="Submit" />
</form>