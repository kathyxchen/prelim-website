<?php 
    $mysqli = new mysqli("127.0.0.1", "root", "test54321", "kathy_blog");
    if ($mysqli->connect_errno) {
        echo "Failed";
    }

    function delete($mysqli, $id) {
        $query = "DELETE FROM articles WHERE ID=" . $id;
        if (mysqli_query($mysqli, $query)) {
            echo "Post has been deleted";
        }
        else {
            echo "Deletion failed.";
        }
    }
?>
