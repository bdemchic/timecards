<?php

include_once("connection.php");
session_start();
?>

<link rel="stylesheet" href="mystyle.css" />

<?php

echo '<h1>Clock In/Out</h1>';
echo '<h2>Step 1: Choose Your Name</h2>';
echo '<form name="choose_user" action="process.php" method="post">';
echo '<label for="select">Name: </label>';

echo '<select name="select">';
$result=dojo_fetch_all("SELECT * FROM users ORDER BY first_name ASC");
foreach($result as $user)
{
	echo '<option value="'.$user['id'].'">'.$user['first_name'].' '.$user['last_name'].'</option>';
}
echo '</select>';
echo '<input id=name_button type="submit" value="Update" />';
echo '<input type="hidden" name="action" value="choose_user" />';
echo '</form>';

if (isset($_SESSION['userid']))
{
	$userid=$_SESSION['userid'];
	echo '<div id="step2">';
	$result=dojo_fetch_all("SELECT DATE_FORMAT(NOW(),'%b %D %Y') AS date_now,
							DATE_FORMAT(NOW(),'%h:%i:%s %p') AS time_now,
							first_name, last_name FROM users 
							WHERE id=$userid");
	echo '<h1>Welcome '.$result[0]['first_name'].'!</h1>';
	echo '<h2>'.$result[0]['date_now'].'</h2>';
	echo '<h2>'.$result[0]['time_now'].'</h2>';
	echo '<form action="process.php" method="post">';
	if ($_SESSION['clocked_in'])
	{
		echo '<textarea name="note" id="note" cols="30" rows="10"></textarea>';
		echo '<p><input id=clock_out type="submit" value="Clock Out" /></p>';
		echo '<input type="hidden" name="action" value="clock_out" />';
	}
	else
	{
		echo '<p><input id=clock_in type="submit" value="Clock In" /></p>';
		echo '<input type="hidden" name="action" value="clock_in" />';
	}
}

if(isset($_SESSION['message']))
{
	echo '<span>'.$_SESSION['message'].'</span>';
	unset($_SESSION['message']);
}
?>

