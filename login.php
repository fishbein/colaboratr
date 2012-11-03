<?php
include('class.php');
include ('header.php');
include('sidebar.php');
?>
<form action="loginhandler.php" method="post" style="text-align:center;">
            <div align="center"><input type="email" name="email" placeholder="Email"></div>
            <div align="center"><input type="password" name="password" placeholder="Password"></div>
            <button align="center" class="btn" type="submit" style="width:175px;">Sign in</button>
          </form>
<?php
include('footer.php');
?>