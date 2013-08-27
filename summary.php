<?php

include_once("connection.php");
session_start();

?>

<html>
<head>
<link rel="stylesheet" href="mystyle.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="tablesorter/jquery.tablesorter.js"></script> 		
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="tablesorter/themes/green/style.css" />
		<script type="text/javascript">
			$(document).ready(function()  { 
					$("#myTable").tablesorter(); 
			});
		</script>
	</head>
	<body>
<?php

echo '<div id="wrapper">
			<h3 id="summary">Summary</h3>';
echo '<a id="link" href="clock.php">Clock In/Out</a>';
echo '<table id="myTable" class="tablesorter">';
echo '<thead><tr>
			<th id="">Name (job title)</th> 
			<th id="">Date In</th> 
			<th id="">Clock In</th> 
			<th id="">Clock Out</th> 
			<th id="">Total Hours</th> 
			<th id="">Note</th> 
		</tr> 
	</thead>
	<tbody>';

// REMOVED PREVIOUS COMMENTS!!!
	
$query = "SELECT
			u.first_name, u.last_name,
			DATE_FORMAT(t.clock_in,'%b %D %Y') AS date_in,
			DATE_FORMAT(t.clock_in,'%h:%i %p') AS time_in,
			DATE_FORMAT(t.clock_out,'%h:%i %p') AS time_out,
			ROUND(TIMEDIFF(t.clock_out,t.clock_in)/60/60,2) AS total_hours,
			t.note
		  FROM users u JOIN timecards t ON u.id=t.user_id";
$result = dojo_fetch_all($query);
foreach($result as $workday)
{
	echo '<tr><td>'.$workday['first_name'].' '.$workday['last_name'].'</td>';
	echo '<td>'.$workday['date_in'].'</td>';
	echo '<td>'.$workday['time_in'].'</td>';
	echo '<td>'.$workday['time_out'].'</td>';
	if (isset($workday['total_hours']))	echo '<td>'.$workday['total_hours'].' hrs</td>';
	else echo '<td></td>';
	echo '<td>'.$workday['note'].'</td></tr>';
}
echo '</tbody></table></form>';

echo '</div>';


?>

</body>