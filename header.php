<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/style.css" media="screen"/>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<title>Colaboratr</title>
</head>
<body>
<div id="header">
		<A href="/"><img id="logo" src="/images/logo.png" style="float:left;"></a>
		<?php if(empty($_SESSION)){ ?>
		<form action="loginhandler.php" method="post" style="float:right;padding:10px;">
            <input type="email" name="email" placeholder="Email or Username" value="Email or Username" onclick="this.value=''">
            <input type="password" name="password" value="Password" onclick="this.value=''">
            <label align="center"></label><button align="center" class="btn" type="submit">Sign in</button>
          </form>
          <?php } else { ?>
          <ul>
          	<li><a href="/">Home</a></li>
          	<li><a href="/submit.php">Submit</a></li>
          	<li><a href="/logout">Log Out</a></li>
          </ul>
          <?php } ?>
	</div>
	<div id="pad"></div>
	<div id="wrapper">