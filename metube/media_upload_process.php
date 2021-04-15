<?php
session_start();
include_once "function.php";

/******************************************************
*
* upload document from user
*
*******************************************************/

$username=$_SESSION['username'];


//Create Directory if doesn't exist
if(!file_exists('uploads/'))
	mkdir('uploads/', 0755);
$dirfile = 'uploads/'.$username.'/';
if(!file_exists($dirfile))
	mkdir($dirfile, 0755);


	if($_FILES["file"]["error"] > 0 )
	{ $result=$_FILES["file"]["error"];} //error from 1-4
	else
	{
	  $upfile = $dirfile.urlencode($_FILES["file"]["name"]);
	  
	  if(file_exists($upfile))
	  {
	  		$result="5"; //The file has been uploaded.
	  }
	  else{
			if(is_uploaded_file($_FILES["file"]["tmp_name"]))
			{
				if(!move_uploaded_file($_FILES["file"]["tmp_name"],$upfile))
				{
					$result="6"; //Failed to move file from temporary directory
				}
				else /*Successfully upload file*/
				{
					//insert into media table
					$insert = "insert into media(
							  mediaid, filename,filepath,type)".
							  "values(NULL,'". urlencode($_FILES["file"]["name"])."','$dirfile','".$_FILES["file"]["type"]."')";
					$queryresult = mysqli_query($db->db_connect_id,$insert)
						  or die("Insert into Media error in media_upload_process.php " .mysqli_error($db->db_connect_id));
					$result="0";
					
					$mediaid = mysqli_insert_id($db->db_connect_id);
					//insert into upload table
					$insertUpload="insert into upload(uploadid,username,mediaid) values(NULL,'$username','$mediaid')";
					$queryresult = mysqli_query($db->db_connect_id,$insertUpload)
						  or die("Insert into view error in media_upload_process.php " .mysqli_error($db->db_connect_id));

					//setup for video information
					$title = $_POST['title'];
					if($title == ''){
						$title=urlencode($_FILES["file"]["name"]);
					}
					$desc = $_POST['desc'];
					if($desc == ''){
						$desc = "No description provided";
					}
					$str = $_POST['keywords'];

					//add to the mediainfo table
					
					
					$addto ="INSERT INTO mediainfo (mediainfoid,title,description) VALUES ('$mediaid','$title','$desc')";
					$queryresult = mysqli_query($db->db_connect_id,$addto)
						  or die("Insert into mediainfo error in media_upload_process.php " .mysqli_error($db->db_connect_id));
					//add to the keywords table
					if($str != ''){
						$words = array();
						$words = explode(' ', $str);
						for($i=0;$i<= (count($words) -1);$i++){
							$word = $words[$i];
						
							$addkey="INSERT INTO keywords (id, videoid, keyword) VALUES (NULL,'$mediaid','$word')";
							$queryresult = mysqli_query($db->db_connect_id,$addkey)
							or die("Insert into keyword error in media_upload_process.php " .mysqli_error($db->db_connect_id));
						}
						if (isset($_POST["category"])) {
							$radioVal = $_POST["category"];

							$addradval="INSERT INTO keywords (id, videoid, keyword) VALUES (NULL,'$mediaid','$radioVal')";
							$addradvalresult=mysqli_query($db->db_connect_id,$addradval)
							or die("Insert into keyword error in media_upload_process.php " .mysqli_error($db->db_connect_id));
						}
					}
				}
			}
			else  
			{
					$result="7"; //upload file failed
			}
		}
	}
	
	//You can process the error code of the $result here.
?>

<meta http-equiv="refresh" content="0;url=browse.php?result=<?php echo $result;?>">
