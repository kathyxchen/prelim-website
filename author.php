<?php
function get_author($mysqli, $id) {
    $author_info = array();
    $query = "SELECT name, email FROM authors WHERE ID=" . $id;
    if ($stmt = $mysqli->prepare($query)) {
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($n, $e);
      $stmt->fetch();
      $author_info['name'] = $n;
      $author_info['email'] = $e;
    }
    return $author_info;
  }
?>