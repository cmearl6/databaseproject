<?php
    include 'search_header.php';
?>

<h1>Search Results</h1>

<div class="search-container">
<?php
    if (isset($_POST['submit_search'])) {
        $search = mysqli_real_escape_string($db->db_connect_id, $_POST['search']);
        $query = "SELECT * FROM mediainfo WHERE title LIKE '%$search%' OR description LIKE '%$search%' ";
        $result = mysqli_query($db->db_connect_id, $query);
        if (!$result)
	    {
	        die ("Could not query the media table in the database: <br />". mysqli_error($db->db_connect_id));
	    }
        $queryResult = mysqli_num_rows($result);

        if ($queryResult > 0) {

            /* Display number of results */
            echo "There are ".$queryResult." result";
            if ($queryResult > 1) {
                echo "s";
            }
            echo ":";

            /* Display results */
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<a href='media.php?id=".$row['mediainfoid']."'><div class='search-box'>
                    <h3>".$row['title']."</h3>
                    <p>".$row['description']."</p>
                </div></a>";
            }
        } else {
            /* Display no results */
            echo "No results matching '".$_POST['search']."'";
        }
    }
?>
</div>

</body>
</html>