<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
	include_once "function.php";
?>	
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media</title>
<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body>



<?php

echo '<form action="browse.php">
<input type="submit" value="Return to Browsing">
</form>';

if(isset($_GET['id'])) {
	$query = "SELECT * FROM media WHERE mediaid='".$_GET['id']."'";
	$result = mysqli_query( $db->db_connect_id,$query );
	$result_row = mysqli_fetch_row($result);
	
	updateMediaTime($_GET['id']);
	
	$filename=$result_row[1];
	$filepath=$result_row[2];
	$type=$result_row[3];

	$query2 = "SELECT * FROM mediainfo WHERE mediainfoid='".$_GET['id']."'";
	$nres = mysqli_query( $db->db_connect_id,$query2 );
	$result_row2 = mysqli_fetch_row($nres);

	$title =$result_row2[1];
	$desc =$result_row2[2];

	if(substr($type,0,5)=="image") //view image
	{
		echo "Viewing Picture:<br>";
		echo $title;
		echo "<br><img src='".$filepath.$filename."'/>";
		echo "<br>",$desc;
	}
	else //view movie
	{	
?>
	<p>Viewing Video:<br><?php echo $title;?></p>
	      <!--
<object id='MediaPlayer' width=320 height=286 
	classid='CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95' 
	standby='Loading Windows Media Player components…' 
	type='application/x-oleobject'
	codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112'>

	<param name="filename" value="<?php echo $result_row[2].$result_row[1];  ?>">
	<param name="Showcontrols" value="true">
	<param name="autoStart" value="false">
	<param name="ClickToPlay" value="true"> 
	<embed type="application/x-mplayer2" pluginspage="http://www.microsoft.com/Windows/MediaPlayer/" src="<?php echo $result_row[2].$result_row[1];  ?>" name="MediaPlayer" width=320 height=240 autoStart="false"></embed>

</object>
-->
<?php
		if($result_row[3] == "video/mp4"){
			?>
			<video width="640" height="480" controls preload="auto">
					<source src="<?php echo $result_row[2].$result_row[1];?>" type="<?php echo $result_row[3];?>">
			</video>
			<?php
		}
		else if($result_row[3] == "video/ogg"){
			?>
			<video width="640" height="480" controls preload="auto">
					<source src="<?php echo $result_row[2].$result_row[1];?>" type="<?php echo $result_row[3];?>">
			</video>
			<?php
		}

		else if($result_row[3] == "video/webm"){
			?>
			<video width="640" height="480" controls preload="auto">
					<source src="<?php echo $result_row[2].$result_row[1];?>" type="<?php echo $result_row[3];?>">
			</video>
			<?php
		}

		else{
			echo "Media type unsupported, please try downloading instead<br>";
		}
?>
<?php
	
	}
	echo "<h3>Description</h3>";
	echo $desc,"<br><br>";
}
else
{
?>
<meta http-equiv="refresh" content="0;url=browse.php">
<?php
}
?>

<?php 


if(!isset($_SESSION['loggedin']) || empty($_SESSION['username'])){

echo '<form action="index.php">
		<input type="submit" value="Return to Browsing">
</form>';

}
else{      
	if (isset($_GET['channel'])) {
		$channel = $_GET['channel'];
		echo "Uploaded by: " . $channel;
		echo "<form method='post'>";
			echo "<input type='submit' name='subscribe' value='Subscribe'>";
		echo "</form>";
			
		echo "<br><br>";
	}

}

if (isset($_POST['subscribe'])) {
	$username = $_SESSION['username'];

	$existsquery = "SELECT * FROM userrelations WHERE subscriberid= (SELECT id FROM account WHERE username=\"".$username."\") AND subscribedtoid= (SELECT id FROM account WHERE username=\"".$channel."\")";
	$existsresult = mysqli_query($db->db_connect_id, $existsquery);

	if ($existsresult->num_rows == 0){
		$subscribequery = "INSERT INTO userrelations (subscriberid, subscribedtoid, relationship) VALUES ((SELECT id FROM account WHERE username=\"".$username."\"), (SELECT id FROM account WHERE username=\"".$channel."\"), 'subscribe')";
		$insertsubscriber = mysqli_query($db->db_connect_id, $subscribequery);
	}

}

if(!isset($_SESSION['loggedin']) || empty($_SESSION['username'])){
}
else{

	echo "<form method='post'>";
	echo "<input type='submit' name='like' value='Like'>";
	echo "</form>";


echo "<form method='post'>
<textarea  id='com' name='com' rows='2' cols='50'>Comment here</textarea><br>
<input name='comm' type='submit' value='submit'>
</form>";

}

if(isset($_POST['like'])) {
	$mediaid = $_GET['id'];
	$username = $_SESSION['username'];

	$allikedquery = "SELECT * FROM account_media WHERE accountid = (SELECT id FROM account WHERE username= \"".$username."\") AND mediaid = \"".$mediaid."\"";
	$allikedresult = mysqli_query($db->db_connect_id, $allikedquery);

	if ($allikedresult->num_rows == 0) {
		$likequery = "INSERT INTO account_media(accountid, mediaid) VALUES ((SELECT id FROM account WHERE username=\"".$username."\"), \"".$mediaid."\")";
		$likeresult = mysqli_query($db->db_connect_id, $likequery);
	}

}

if(isset($_POST['comm'])){
	$comment= $_POST['com'];
	$vid= $_GET['id'];

	$sessinfo = $_SESSION['username'];
	$queryi  = "SELECT id FROM account WHERE username = '$sessinfo'";
    $resulti = mysqli_query($db->db_connect_id,$queryi);
    $rowi = mysqli_fetch_array($resulti);
    $id = $rowi['id'];

 
	$queryc = "INSERT INTO comment (cid,vidid, userid, comments)VALUES (NULL, '$vid','$id','$comment' )";
	mysqli_query($db->db_connect_id,$queryc);
	
}

?>


<h2>Comments:</h2>


<?php
	$vd =$_GET['id'];
	$all = "SELECT * from comment WHERE vidid= $vd"; 
	$rall = mysqli_query($db->db_connect_id, $all );
	while($result_rall = mysqli_fetch_row($rall)){
		$q2 = "SELECT username,id FROM account WHERE id = $result_rall[2]";
		$q2r = mysqli_query($db->db_connect_id,$q2);
		$r = mysqli_fetch_array($q2r);
		$uname = $r[0];

		echo '<h4>User: ',$uname,'</h4>'; 
		echo $result_rall[3],'<br>';
	}



?>
</body>
</html>
