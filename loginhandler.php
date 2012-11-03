<?php
include('class.php');
$database = new Database;
$email = strip_tags(mysql_real_escape_string($_POST["email"]));
$password = strip_tags(mysql_real_escape_string($_POST["password"]));
$auth = new Auth;
$auth->Login($email, $password);
?>