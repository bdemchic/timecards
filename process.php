<?php

include_once("connection.php");
session_start();

if(isset($_POST['action']) and $_POST['action']=="clock_out")
{
	if (isset($_SESSION['userid']))
	{
		$userid=$_SESSION['userid'];
		if (isset($_POST['note'])) $note=mysql_real_escape_string($_POST['note']);
		$query = "UPDATE timecards SET clock_out=NOW(), note='$note'
				  WHERE user_id = $userid AND clock_out IS NULL";
		// ECHO 'QUERY='.$query;		
		$success=mysql_query($query);
		if ($success) $_SESSION['message'] = "You were successfully clocked out.";
		else $_SESSION['message'] = "SORRY, SYSTEM ERROR OCCURRED.  PLEASE CONTACT SITE ADMINISTRATOR.";
		$_SESSION['clocked_in']=false;
	}
	unset($_SESSION['userid']);
	header('Location: clock.php');
}

if(isset($_POST['action']) and $_POST['action']=="clock_in")
{
	if (isset($_SESSION['userid']))
	{
		$userid=$_SESSION['userid'];
		$query="INSERT INTO timecards (user_id, clock_in)
				VALUES ($userid, NOW() )";
		$success=mysql_query($query);
		if ($success) $_SESSION['message'] = "You were successfully clocked in.";
		else $_SESSION['message'] = "SORRY, SYSTEM ERROR OCCURRED.  PLEASE CONTACT SITE ADMINISTRATOR.";
		$_SESSION['clocked_in']=true;
	}
	unset($_SESSION['userid']);
	header('Location: clock.php');
}

if(isset($_POST['action']) and $_POST['action']=="choose_user")
{
	if ($_POST['select'])
	{
		$userid=$_POST['select'];
		ECHO '<BR>USER='.$userid;
		$query = "SELECT COUNT(*) AS count FROM timecards
				  WHERE user_id = $userid
				  AND clock_out IS NULL";
		$result = dojo_fetch_all($query); // SEE IF USER CLOCKED IN WITHOUT CLOCKING OUT
		$_SESSION['userid']=$userid;
		$_SESSION['clocked_in']=false;
		// ECHO '<BR>COUNT='.$result[0]['count'];
		if ($result[0]['count']>0)
		{
			$_SESSION['clocked_in']=true;
			// ECHO '<BR>AQUI!!!!';
		}
		header('Location: clock.php');
	}
}

?>