<?php
include('class.php');
include ('header.php');
include('sidebar.php');
$view = new View;
$view->idea($_GET['id']);
include('footer.php');
?>