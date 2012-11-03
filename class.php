<?php
session_start();
//Database Connection Information
class Database
{
	function __construct()
	{
		$DB_HOST = '';
		$DB_USER = '';
		$DB_PASS = '';
		$DB_DB = '';
		$conn = mysql_connect($DB_HOST, $DB_USER, $DB_PASS);
		if(!$conn) {
     		die("Well this is embarrasing.  It seems we're having an issue connecting to our database.  If you see our developer tell him: ".mysql_error());
		}
		$db = mysql_select_db($DB_DB);
		if(!$db) {
    		 die("Database selection failed. Error code: <br /><br />".mysql_error());
		}
	}
}

//Prelaunch About Info and Sign Up
class preLaunch extends Database
{
	function mailinglist()
	{
		echo "<h2>What is Colaboratr?</h2>
            	<p>Colaboratr is a place to share ideas, get feedback, and of course, <b>collaborate</b>.  Essentially, ideas are posted (publicly, to friends, or privately) and they are rated and suggestions are made.  With Colaboratr, you can make your <span id='reload'>idea</span> better.</p>
            	<h4>Sound cool?  Want to learn more?</h4>  <p>Sign up for the mailing list for timely development updates and to be notified when the beta begins.</p>
            	<form id='pre' action='http://colaboratr.us4.list-manage.com/subscribe/post?u=109d992e86baa80ad3315bacc&amp;id=edcb5b55bb' method='post' id='mc-embedded-subscribe-form' name='mc-embedded-subscribe-form' class='validate' target='_blank'>
            	<label for='mce-EMAIL'>Email</label> <input type='text' id='pre-email' name='EMAIL' class='email' id='mce-EMAIL' required><br /><button class='btn' type='submit' name='subscribe' id='mc-embedded-subscribe'>Keep Me Posted</button>
            	</form>";
            	if($_GET['err']=='empty'){
	          echo "<p class='red' align='center'>Please enter your email address.</p>";
          }
          if($_GET['err']=='valid'){
	          echo "<p class='red' align='center'>Please enter a valid email address.</p>";
          }
          if($_GET['success']=='true'){
	          echo "<p class='green' align='center'>Thanks for subscribing. Check your email for more information.</p>";
          }
	}
	
}

//All Authentication Functions
class Auth extends Database
{
	function login($email,$password){
		parent::__construct();
		if (empty($email)) 		{ $err = "Please make sure your E-mail is filled in."; }
		if (empty($password)) 	{ $err = "Please make sure your Password is filled in."; }
		if (!empty($password))	{ $password = md5($password); }
		if($err){header("Location:/index.php?err=$err");}
		$checkUserQ = mysql_query("SELECT * FROM users WHERE email='$email' OR username='$email'");
		$checkUser = mysql_num_rows($checkUserQ);
		if ($checkUser!=1) { $err = "Wrong username/password combination, please try again.";header("Location:/login.php?err=$err");}
		if(empty($err)) {
			$query = mysql_query("SELECT * FROM users WHERE email='$email' OR username='$email'");
			while ($row = mysql_fetch_assoc($query)) {
				$dbid = $row["id"];
				$dbemail = $row["email"];
				$dbpassword = $row["password"];			
				$dbusername = $row["username"];

			}
			if ($email==$dbemail&&$password==$dbpassword OR $email==$dbusername&&$password==$dbpassword) {
				$_SESSION["user_userid"] = $dbid;
				header('Location:index.php');
			}
			else {$err = "Wrong username/password combination, please try again.";header("Location:/login.php?err=$err");}
	}
	}
	
	function logout()
	{
		session_destroy();
		header('Location:index.php');
	}
	
	function register($first, $last, $email, $username, $password, $confirmpassword, $captcha, $rand1, $rand2)
	{
		if (empty($first)){ $err = "Don't forget your name."; }
		if (empty($last)){ $err = "Don't forget your name."; }
		if (empty($email)){ $err = "Don't forget your email."; }
		if (empty($username)){ $err = "Don't forget to select a username."; }
		if (empty($password)){ $err = "Don't forget to set a password."; }
		if (empty($confirmpassword)){ $err = "Don't forget to reenter your password."; }
		//Check Password
		if($password!=$confirmpassword){$err = "Passwords do not match.";}
		//Check Captcha 
		if($rand1+$rand2!=$captcha){$err = "Please try the equation again.";}
		if($err){
			header("Location:/register.php?err=$err");
		}
		else{
		$password = md5($password);
		$query = mysql_query("INSERT INTO users VALUES('','$first','$last','$email','$password','0','$username')");
		header('Location:/index.php');
		}
	}
}

//View Functions
class View extends Database
{
	function User($un){
		$query = mysql_query("SELECT * FROM users WHERE username = '$un'");
		while ($row = mysql_fetch_assoc($query)) {
			$username = $row['firstname'];
			$lastname = $row['lastname'];
			$id = $row['id'];
			}
			if(mysql_num_rows($query)==0){
				echo "<h1>404 Error</h1><img src='/404.jpg' align='center'><br />Sorry, we can't seem to find what you're looking for.  Please check to make sure you typed the address properly, or <a href='mailto:phil@colaboratr.com'>contact us</a>.";
				//header('Location:/404.php');
			}
			
			else{
				$title = "$username $lastname - Colaboratr";
			}
		if(mysql_num_rows($query)==0){
				//header('Location:/404.php');
			}
			else{
				echo "<h1>$username $lastname</h1> <a href='/friend.php?id=$id'>Add as Friend</a>";
			}
			
			$ideaquery = mysql_query("SELECT * FROM ideas WHERE user_id = '$id'");
		while ($row = mysql_fetch_assoc($ideaquery)) {
			$title = $row['title'];
			$postid = $row['id'];
			echo "<h3><a href='/idea/$postid'>".$title."</a></h3>";
			}
	}
	function Idea($id){
		parent::__construct();
		$query = mysql_query("SELECT * FROM ideas WHERE id='$id'");							
			while ($row = mysql_fetch_assoc($query)) {
			$title = $row['title'];
			$id = $row['id'];
			$description = $row['description'];
			$img = $row['image_path'];
			$category = $row['cat_id'];
			$uid = $row['user_id'];
			$likes = $row['likes'];
			$dislikes = $row['dislikes'];
			$featured = $row['featured'];
			
			echo "<div class='post-single'><h2>$title</h2>";
							//onmouseover="$('.span4').load('small.php?id=<?php echo $id;')"
							
							echo "<p>$description</p>";
							if($img){echo "<img src='/$img'><br />";}
							echo '<a href="/like.php?id='.$id.'"><img src="/up.png"></a>'.$likes.'  <a href="/dislike.php?id='.$id.'"><img src="/down.png"></a>'.$dislikes;
							$query1 = mysql_query("SELECT * FROM users WHERE id = '$uid'");
						while ($row1 = mysql_fetch_assoc($query1)) {
							$username = $row1['firstname'];
							$lastname = $row1['lastname'];
							$un = $row1['username'];
							echo "<div class='meta'>Posted by <a class='submitter' href='$un/'><b>$username $lastname</b></a></div></div>";
							$comments = new Comments;
							$comments->form($id);
							$comments->Display($id);
							}
							}
	}
	function Ideas($number,$type){
		parent::__construct();
		$query = mysql_query("SELECT * FROM ideas ORDER BY featured DESC, id DESC LIMIT $number");							
			while ($row = mysql_fetch_assoc($query)) {
			$title = $row['title'];
			$id = $row['id'];
			$description = $row['description'];
			$img = $row['image_path'];
			$cat_id = $row['cat_id'];
			$uid = $row['user_id'];
			$likes = $row['likes'];
			$dislikes = $row['dislikes'];
			$featured = $row['featured'];
				$category = mysql_query("SELECT * FROM categories WHERE id='$cat_id'");							
				while ($row1 = mysql_fetch_assoc($category)) {
					$categoryname = $row1['title'];
				}
				$query1 = mysql_query("SELECT * FROM users WHERE id = '$uid'");
						while ($row2 = mysql_fetch_assoc($query1)) {
							$username = $row2['firstname'];
							$lastname = $row2['lastname'];
							$un = $row2['username'];
							}
			
			echo "<div class='post'><h3><a href='idea/$id'>$title</a>";
if($img){
	echo "</h3>";
							}
							else{
								echo "</h3>";
							}
							
							echo "<p>$description</p>";
							echo '<a href="/like.php?id='.$id.'"><img src="/up.png"></a>'.$likes.'  <a href="/dislike.php?id='.$id.'"><img src="/down.png"></a>'.$dislikes;
							echo "<div class='meta'>Posted by <a class='submitter' href='$un/'><b>$username $lastname</b></a></div>
							<a href='category.php?id=$cat_id' style='text-decoration:none;'><div class='tag'>#$categoryname</div></a></div>";
							}
	}
	function Categories($cat_id){
		parent::__construct();
		$query = mysql_query("SELECT * FROM ideas WHERE cat_id='$cat_id'");							
			while ($row = mysql_fetch_assoc($query)) {
			$title = $row['title'];
			$id = $row['id'];
			$description = $row['description'];
			$img = $row['image_path'];
			$cat_id = $row['cat_id'];
			$uid = $row['user_id'];
			$likes = $row['likes'];
			$dislikes = $row['dislikes'];
			$featured = $row['featured'];
				$category = mysql_query("SELECT * FROM categories WHERE id='$cat_id'");							
				while ($row1 = mysql_fetch_assoc($category)) {
					$categoryname = $row1['title'];
				}
				$query1 = mysql_query("SELECT * FROM users WHERE id = '$uid'");
						while ($row2 = mysql_fetch_assoc($query1)) {
							$username = $row2['firstname'];
							$lastname = $row2['lastname'];
							$un = $row2['username'];
							}
			
			echo "<div class='post'><h3><a href='idea/$id'>$title</a>";
if($img){
	echo "</h3>";
							}
							else{
								echo "</h3>";
							}
							
							echo "<p>$description</p>";
							echo '<a href="/like.php?id='.$id.'"><img src="/up.png"></a>'.$likes.'  <a href="/dislike.php?id='.$id.'"><img src="/down.png"></a>'.$dislikes;
							echo "<div class='meta'>Posted by <a class='submitter' href='$un/'><b>$username $lastname</b></a></div>
							<a href='category.php?id=$cat_id' style='text-decoration:none;'><div class='tag'>#$categoryname</div></a></div>";
							}
	}
}
//Coments
class Comments extends Database
{
	function form($id){
		echo "
		<h3>Leave a comment!</h3>
		<form action='/commentsubmit.php' method='POST'>
			<textarea class='comment-form' name='comment' rows='5' cols='65'></textarea><br />
			<input type='hidden' name='id' value='$id'>
			<button class='btn' action='submit'>Post</button>
		</form>
		";
	}
	function Submit($id, $user_id, $comment){
		if (empty($comment)){ $err = "Don't forget a comment!"; }
		if($err){header("Location:/idea/$id?err=$err");}
		else{
			$query = mysql_query("INSERT INTO comments VALUES('','$user_id','$id','$comment')");
			header("Location:/idea/$id#comments");
		}
	}
	function Display($id){
		echo "<div id='comments'><h3>Comments</h3>";
		$query = mysql_query("SELECT * FROM comments WHERE idea_id = '$id'");
		while ($row = mysql_fetch_assoc($query)) {
			$comment = $row['text'];
			$user = $row['user_id'];
				$query1 = mysql_query("SELECT * FROM users WHERE id = '$user'");
				while ($row1 = mysql_fetch_assoc($query1)) {
					$username = $row1['firstname'];
					$lastname = $row1['lastname'];
					$un = $row1['username'];
					}
			echo "<div class='comment-single-text'><a href='/$un'>$username $lastname</a><br />$comment</div>";
		}
		echo "</div>";
	}
}
//Idea Submission (Coming Soon)
class Submit
{
	function Upload($user,$title,$description,$picture,$category,$diycategory,$privacy)
	{
		if (empty($title)){ $err = "Don't forget to title your idea!"; }
		if (empty($description)){ $err = "Don't forget to describe your idea!"; }
		if (empty($category)&empty($diycategory)){ $err = "Please categorize your idea."; }
		if (empty($privacy)){ $err = "Don't forget to choose who can see your idea!"; }
		
		if($err){header("Location:/submit.php?err=$err");}
		if($diycategory){
			$query = mysql_query("INSERT INTO categories VALUES('','$diycategory')");
			$query1 = mysql_query("SELECT * FROM categories WHERE title = '$diycategory'");
			while ($row1 = mysql_fetch_assoc($query1)) {
				$category = $row1['cat_id'];
			}
			$query = mysql_query("INSERT INTO ideas VALUES('','$user','$title','$description','$picture','$category','$privacy','0','0','0')");
			header('Location:/index.php');
		}
		else{
			$query = mysql_query("INSERT INTO ideas VALUES('','$user','$title','$description','$picture','$category','$privacy','0','0','0')");
			header('Location:/index.php');
		}
	}
}

class Votes extends Database{
	function Like($id){
		$query1 = mysql_query("SELECT * FROM ideas WHERE id = '$id'");
		while ($row = mysql_fetch_assoc($query1)) {
			$like = $row['likes'];
			$dislike = $row['dislikes'];
		}
		$likestotal = $like + 1;
		$session = $_SESSION['user_userid'];
		
		$query3 = mysql_query("SELECT * FROM likes WHERE user_id = '$session' AND idea_id = '$id'");
		while ($row = mysql_fetch_assoc($query3)) {
			$type = $row['type'];
		}
			$num = mysql_num_rows($query3);
		if($num==0){
			$query = mysql_query("UPDATE ideas SET likes='$likestotal' WHERE id='$id'");
			$query2 = mysql_query("INSERT INTO likes VALUES ('','like','$id','$session')");
		}
		if($type=='dislike'){
			$likestotal = $like + 1;
			$dislikestotal = $dislike - 1;
			$query = mysql_query("UPDATE ideas SET likes='$likestotal', dislikes='$dislikestotal' WHERE id='$id'");
			$query2 = mysql_query("UPDATE likes SET type='like' WHERE idea_id='$id'");
		}
		header('Location:/index.php');		
	}
	function Dislike($id){
		$query1 = mysql_query("SELECT * FROM ideas WHERE id = '$id'");
		while ($row = mysql_fetch_assoc($query1)) {
			$like = $row['likes'];
			$dislike = $row['dislikes'];
		}
		$dislikestotal = $dislike + 1;
		$session = $_SESSION['user_userid'];
		
		$query3 = mysql_query("SELECT * FROM likes WHERE user_id = '$session' AND idea_id = '$id'");
		while ($row = mysql_fetch_assoc($query3)) {
			$type = $row['type'];
		}
			$num = mysql_num_rows($query3);
		if($num==0){
			$query = mysql_query("UPDATE ideas SET dislikes='$dislikestotal' WHERE id='$id'");
			$query2 = mysql_query("INSERT INTO likes VALUES ('','dislike','$id','$session')");
		}
		if($type=='like'){
			$likestotal = $like - 1;
			$dislikestotal = $dislike + 1;
			$query = mysql_query("UPDATE ideas SET likes='$likestotal', dislikes='$dislikestotal' WHERE id='$id'");
			$query2 = mysql_query("UPDATE likes SET type='dislike' WHERE idea_id='$id'");
		}
		
		header('Location:/index.php');		
	}
}

/*class Small extends Database
{
	function Display($id){
	parent::__construct();
	$query = mysql_query("SELECT * FROM ideas WHERE id='$id'");							
			while ($row = mysql_fetch_assoc($query)) {
			$title = $row['title'];
			$id = $row['id'];
			$description = $row['description'];
			$img = $row['image_path'];
			$category = $row['cat_id'];
			$uid = $row['user_id'];
			$likes = $row['likes'];
			$dislikes = $row['dislikes'];
			$featured = $row['featured'];
			
			echo "<h3><a href='idea/$id'>$title </a>";
							//onmouseover="$('.span4').load('small.php?id=<?php echo $id;')"
if($img){
	echo "<img src='pic.png'/></h3>";
							}
							else{
								echo "</h3>";
							}
							
							echo "<p>$description</p>";
							echo '<a href="like.php?id='.$id.'"><img src="/up.png"></a>'.$likes.'  <a href="dislike.php?id='.$id.'"><img src="/down.png"></a>'.$dislikes;
							}
		}
}*/
?>