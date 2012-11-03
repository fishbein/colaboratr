<?php
include('class.php');

if(empty($_SESSION['user_userid'])){
	?>
	<!DOCTYPE HTML>
	<title>Colaboratr</title>
	<?php
	include ('header.php');
	include('sidebar.php');
	$view = new preLaunch;
	$view->mailinglist();
	include('footer.php');
}
else{
	include ('header.php');
	include('sidebar.php');
	$view = new View;
	$view->Ideas('10','all');
	include('footer.php');
}
?>