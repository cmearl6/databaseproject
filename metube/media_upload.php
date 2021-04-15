<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media Upload</title>
</head>

<body>

<form method="post" action="media_upload_process.php" enctype="multipart/form-data" >
 
  <p style="margin:0; padding:0">
  <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
   Add a Media: <label style="color:#663399"><em> (Each file limit 10M)</em></label><br/>
   <input  name="file" type="file" size="50" />
  
	<input value="Upload" name="submit" type="submit" />
  </p>
  <table width="100%">
		<tr>
			<td  width="20%">Title:</td>
			<td width="80%"><input class="text"  type="text" name="title" size="50"><br /></td>
		</tr>
		<tr>
			<td  width="20%">Description:<br /></td>
			<td width="80%"><textarea  id="desc" name="desc" rows="2" cols="50"></textarea><br /></td>
		</tr>
        <tr>
			<td  width="20%">Keywords:<br /></td>
			<td width="80%"><textarea  id="keywords" name="keywords" rows="2" cols="50">Separate the keywords by spaces</textarea><br /></td>
		</tr>

	</table>

	<input type="radio" name="category" value="Music">
	<label for="music">Music</label><br>
	<input type="radio" name="category" value="Entertainment">
	<label for="entertainment">Entertainment</label><br>
	<input type="radio" name="category" value="Gaming">
	<label for="gaming">Gaming</label>
      
 </form>

 <form action="browse.php">
		<input type="submit" value="Back">
	</form>

</body>
</html>
