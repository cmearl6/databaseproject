<?php
    session_start();
    include_once "function.php"
?>

<html>

<div style="background:#339900;color:#FFFFFF; width:150px;">Select one of the following categories</div>

<form method="post">
    <input type="submit" name="music" value="Music">
    <input type="submit" name="entertainment" value="Entertainment">
    <input type="submit" name="gaming" value="Gaming">
</form>


<?php

    if (isset($_POST['music'])) {
        $query = "SELECT * from media WHERE mediaid in (SELECT videoid FROM keywords WHERE keyword='music')"; 
        $result = mysqli_query($db->db_connect_id, $query );
        if (!$result)
        {
           die ("Could not query the media table in the database: <br />". mysqli_error($db->db_connect_id));
        }
    } else if (isset($_POST['gaming'])) {
        $query = "SELECT * from media WHERE mediaid in (SELECT videoid FROM keywords WHERE keyword='gaming')"; 
        $result = mysqli_query($db->db_connect_id, $query );
        if (!$result)
        {
           die ("Could not query the media table in the database: <br />". mysqli_error($db->db_connect_id));
        }
    } else if (isset($_POST['entertainment'])) {
        $query = "SELECT * from media WHERE mediaid in (SELECT videoid FROM keywords WHERE keyword='entertainment')"; 
        $result = mysqli_query($db->db_connect_id, $query );
        if (!$result)
        {
           die ("Could not query the media table in the database: <br />". mysqli_error($db->db_connect_id));
        }
    } else {
        $result = 0;
    }


    
	$queryi = "SELECT * from mediainfo";
	$infores = mysqli_query($db->db_connect_id,$queryi);
?>
    
    <div style="background:#339900;color:#FFFFFF; width:150px;">Uploaded Media</div>
	<table width="50%" cellpadding="0" cellspacing="0">
		<?php
        if ($result) {
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
            	<a href="<?php echo $result_row[2].$result_row[1];?>" target="_blank" onclick="javascript:saveDownload(<?php echo $result_row[0];?>);" download>Download</a>
            </td>
		</tr>
        <?php
			}
        }

		?>
	</table>
    
    <br><br>

    <form action="browse.php">
        <input type="submit" value="Back">
    </form>

</html>