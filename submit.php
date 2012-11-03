<?php
include('class.php');
include ('header.php');
include('sidebar.php');
$DB = new Database; //Connect to database
?>
<?php
	if($_GET['err']){
		echo "<p style='color:red'>".stripslashes($_GET['err'])."</p>";
	}
?>
<h2>Submit an Idea</h2>
			<form action="submithandler.php" method="post" enctype="multipart/form-data">
            	<label>Title</label><br /><input type="text" placeholder="Give your idea a name." name="title"><br />
            	<label>Description</label><br /><textarea placeholder="Give some more information." rows="5" cols="25" name="description"></textarea><br />
            	<label>Upload a picture.</label><br /><input type="file" name="file" style="border:0"/> <p  style="margin-top:6px;color:red;"></p><br />
            	<label>Setect a category...</label><br />
            	<select name="category">
            		<?php
            			$query = mysql_query("SELECT * FROM categories");
            			while ($row = mysql_fetch_assoc($query)) {
	            			$categoryid = $row["id"];
	            			$categorytitle = $row["title"];
	            			echo "<option value='$categoryid'>$categorytitle</option>";
	            		}
            		?>          	
            	</select>
            	<br />
            	<label>...or add your own</label><br /><input type="text" placeholder="Categoy" name="diycategory"><br />
            	<label>Who sees this idea?</label><br /><div style="margin-top:5px;"><input type="radio" value="true" name="public"> Anyone (Public)
            	<input type="radio" value="true" name="friends"> Friends Only
            	<input type="radio" value="true" name="private"> Private URL Only</div>
            	<label></label><button class="btn" style="margin-top:10px;" type="submit">Submit</button>
            </form>
<?php
include('footer.php');
?>