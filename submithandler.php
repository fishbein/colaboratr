<?php
include('class.php');
$database = new Database;
$user = $_SESSION["user_userid"];
$title = strip_tags(mysql_real_escape_string($_POST["title"]));
$description = strip_tags(mysql_real_escape_string($_POST["description"]));
//$picture = strip_tags(mysql_real_escape_string($_POST["file"]));
$category = strip_tags(mysql_real_escape_string($_POST["category"]));
$diycategory = strip_tags(mysql_real_escape_string($_POST["diycategory"]));
$public = strip_tags(mysql_real_escape_string($_POST["public"]));
$friends = strip_tags(mysql_real_escape_string($_POST["friends"]));
$private = strip_tags(mysql_real_escape_string($_POST["private"]));
if($public){
  $privacy = 'public';
}
else if($friends){
  $privacy = 'friends';
}
else if($private){
  $privacy = 'private';
}

if($_FILES["file"]["size"]!=0){
//Image Script
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 200000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      $rand = rand();
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $rand . $_FILES["file"]["name"]);
      $picture = "upload/" . $rand . $_FILES["file"]["name"];
      }
    }
  }
else
  {
  		$err = "Invalid image";
  }
}
$submit = new Submit;
$submit->Upload($user,$title,$description,$picture,$category,$diycategory,$privacy);
?>