<?php
include('class.php');
$database = new Database;
$user_id = $_SESSION["user_userid"];
$comment = strip_tags(mysql_real_escape_string($_POST["comment"]));
$id = strip_tags(mysql_real_escape_string($_POST["id"]));
$comments = new Comments;
$comments->Submit($id, $user_id, $comment);
?>