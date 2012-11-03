<?php
$id = $_GET['id'];
include('class.php');
$database = new Database;
$id = strip_tags(mysql_real_escape_string($_GET['id']));
$like = new Votes;
$like->Like($id);
?>