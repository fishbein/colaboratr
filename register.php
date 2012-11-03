<?php
include('header.php');
include('sidebar.php');
?>
<?php if($_GET['err']){echo "<p style='color:red'>".$_GET['err']."</p>";}?>
<h2>Register</h2>
            <form action="registerhandler.php" method="post">
            <?php $rand[1] = rand(1,10);$rand[2] = rand(1,10);?>
            <label>First Name</label><br /> <input type="text" name="firstname" placeholder="John"><br/>
            <label>Last Name</label><br /><input type="text" name="lastname" placeholder="Smith"><br/>
            <label>Email</label><br /> <input type="email" name="email" placeholder="johnsmith@gmail.com"><br />
            <label>Username</label><br /> <input type="text" name="username" placeholder="johnsmith"><br />
            <label>Password</label><br /> <input type="password" name="password" placeholder=""><br />
            <label>Confirm Password</label><br /><input type="password" name="passwordconfirm" placeholder=""><br />
            <label>Are you human? <?php echo $rand[1].'+'.$rand[2]; ?></label> <br /> <input type="text" name="captcha"><br />
            <input type="hidden" name="rand1" value="<?php echo $rand[1];?>">
            <input type="hidden" name="rand2" value="<?php echo $rand[2];?>">
            <label></label><button class="btn" type="submit">Let's Go!</button>
            </form>
 <?php
 include('footer.php');
 ?>