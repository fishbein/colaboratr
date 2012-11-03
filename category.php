<?php
include('class.php');
?>
	<!DOCTYPE HTML>
	<title>Colaboratr</title>
<?php
	$id = $_GET['id'];
	include ('header.php');
	include('sidebar.php');
	$category = new View;
	$category->Categories($id);
	include('footer.php');
?>