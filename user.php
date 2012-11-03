<?php
include('class.php');
include ('header.php');
include('sidebar.php');
$user = new View;
$user->User($_GET['id']);
include ('footer.php');
?>