<link rel="stylesheet" type="text/css" href="css/default.css" />
<?php
session_start();

include_once "function.php";

if(isset($_POST['submit'])) {
		if($_POST['username'] == "" || $_POST['password'] == "") {
			$login_error = "One or more fields are missing.";
		}
		else {
			$check = user_pass_check($_POST['username'],$_POST['password']); // Call functions from function.php
			if($check == 1) {
				$login_error = "User ".$_POST['username']." not found.";
			}
			elseif($check==2) {
				$login_error = "Incorrect password.";
			}
			else if($check==0){
				$_SESSION['username']=$_POST['username']; //Set the $_SESSION['username']
				$_SESSION['loggedin']='true';
				header('Location: browse.php');
			}		
		}
}
?>

	<form method="post" action="<?php echo "index.php"; ?>">

	<table width="100%">
		<tr>
			<td  width="20%">Username:</td>
			<td width="80%"><input class="text"  type="text" name="username"><br /></td>
		</tr>
		<tr>
			<td  width="20%">Password:</td>
			<td width="80%"><input class="text"  type="password" name="password"><br /></td>
		</tr>
		<tr>
        
			<td><input name="submit" type="submit" value="Login"><input name="reset" type="reset" value="Reset"><br /></td>
		</tr>
		<tr>
			
		</tr>
	</table>
	</form>
	<form action="register.php">
		<input type="submit" value="Register">
	</form>
<?php
  if(isset($login_error))
   {  echo "<div id='passwd_result'>".$login_error."</div>";}
?>

<!-- Search Area: relocate as needed -->

<form action="search.php" method="POST">
		<input type="text" name="search" placeholder="Search MeTube">
		<button type="submit" name="submit_search">Search</button>
	</form>

<!-- End Search Area-->

<?php


$query = "SELECT * from media"; 
$result = mysqli_query($db->db_connect_id, $query );
if (!$result)
{
   die ("Could not query the media table in the database: <br />". mysqli_error($db->db_connect_id));
}
$queryi = "SELECT * from mediainfo";
$infores = mysqli_query($db->db_connect_id,$queryi);
?>

<div style="background:#339900;color:#FFFFFF; width:150px;">Uploaded Media</div>
<table width="50%" cellpadding="0" cellspacing="0">
	<?php
		while ($result_row = mysqli_fetch_row($result))
		{ $resi_row = mysqli_fetch_row($infores);
	?>
	<tr valign="top">			
		<td>
				<?php 
					echo $result_row[0];
				?>
		</td>
		<td>
			<?php
				echo $resi_row[1];
			?>
		</td>
		<td>
			<a href="media.php?id=<?php echo $result_row[0];?>" target="_blank"><?php echo $result_row[1];?></a> 
		</td>
		<td>
			<a href="<?php echo $result_row[2].$result_row[1];?>" target="_blank" onclick="javascript:saveDownload(<?php echo $result_row[0];?>);">Download</a>
		</td>
	</tr>
	<?php
		}
	?>
</table>

