<?php
include "mysqlClass.inc.php";

function user_pass_check($username, $password)
{
	global $db;
	$query = "select * from account where username='$username'";
	$result = mysqli_query($db->db_connect_id, $query );
		
	if (!$result)
	{
	   die ("user_pass_check() failed. Could not query the database: <br />". mysqli_error($db->db_connect_id));
	}
	else{
		$row = mysqli_fetch_row($result);
		if(strcmp($row[1],$password))
			return 2; //wrong password
		else 
			return 0; //Checked.
	}	
}

function updateMediaTime($mediaid)
{
	$query = "	update  media set lastaccesstime=NOW()
   						WHERE '$mediaid' = mediaid
					";
					 // Run the query created above on the database through the connection
    $result = mysqli_query($db->db_connect_id, $query );
	if (!$result)
	{
	   die ("updateMediaTime() failed. Could not query the database: <br />". mysqli_error());
	}
}

function upload_error($result)
{
	//view erorr description in http://us2.php.net/manual/en/features.file-upload.errors.php
	switch ($result){
	case 1:
		return "UPLOAD_ERR_INI_SIZE";
	case 2:
		return "UPLOAD_ERR_FORM_SIZE";
	case 3:
		return "UPLOAD_ERR_PARTIAL";
	case 4:
		return "UPLOAD_ERR_NO_FILE";
	case 5:
		return "File has already been uploaded";
	case 6:
		return  "Failed to move file from temporary directory";
	case 7:
		return  "Upload file failed";
	}
}

function other()
{
	//You can write your own functions here.
}

function newnamecheck($username){
	global $db;
	$query = "select * from account where username='$username'";
	$result = mysqli_query($db->db_connect_id, $query );

	if(mysqli_num_rows($result)>=1){
		return 1;
	}
	return 0;
}	
?>
