<?php
    session_start();
    include_once "function.php"
?>

<html>


<?php
    global $db;

    $username = $_SESSION['username'];
    $query = "SELECT username FROM account WHERE id IN (SELECT subscribedtoid FROM userrelations WHERE subscriberid = (SELECT id FROM account WHERE username = \"".$username."\"));";

    $result = mysqli_query($db->db_connect_id, $query);

	if (isset($_SESSION['currentchannel'])) {
		$currentchannel = $_SESSION['currentchannel'];
	}
?>

<div style="background:#339900;color:#FFFFFF; width:150px;"><?php echo $_SESSION['username'];?>'s contacts</div>
	<table width="50%" cellpadding="0" cellspacing="0">
		<?php
            if ($result->num_rows == 0) {
                echo "<br>You have no contacts.<br>Subscribe to add contacts.";
            }

			while ($result_row = mysqli_fetch_row($result))
			{
		?>
        <tr valign="top">			
			<td>
				<a href="http://webapp.computing.clemson.edu/~cmearl/databaseproject/metube/channel_content.php?channel=<?php echo $result_row[0];?>" target="_blank"><?php echo $result_row[0] ?></a>
			</td>
		</tr>
        <?php
			}
		?>
	</table>

    <?php echo "<br><br>" ?>

    <form action="browse.php" method="post">
        <input type="submit" value="Back">
    </form>

</html>