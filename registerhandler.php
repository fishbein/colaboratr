<?php
include('class.php');
$database = new Database;
$firstname = strip_tags(mysql_real_escape_string($_POST["firstname"]));
$lastname = strip_tags(mysql_real_escape_string($_POST["lastname"]));
$email = strip_tags(mysql_real_escape_string($_POST["email"]));
$username = strip_tags(mysql_real_escape_string($_POST["username"]));
$password = strip_tags(mysql_real_escape_string($_POST["password"]));
$passwordconfirm = strip_tags(mysql_real_escape_string($_POST["passwordconfirm"]));
$captcha = strip_tags(mysql_real_escape_string($_POST["captcha"]));
$rand1 = strip_tags(mysql_real_escape_string($_POST["rand1"]));
$rand2 = strip_tags(mysql_real_escape_string($_POST["rand2"]));
$auth = new Auth;
$auth->register($firstname,$lastname,$email,$username,$password,$passwordconfirm,$captcha,$rand1,$rand2);
?>