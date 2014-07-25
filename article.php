<?php
  
  $mysqli = new mysqli("127.0.0.1", "root", "", "kathy_blog");
  if ($mysqli->connect_errno) {
    echo "Failed";
  }
  function get_db($mysqli, $str_params, $which) {
    $query = "SELECT " . $str_params . " FROM articles WHERE ID=" . $which;
    if ($stmt = $mysqli->prepare($query)) {
      $stmt->execute();
      $stmt->store_result();  
      $stmt->bind_result($a, $b, $c);
      $stmt->fetch();
      echo '<div class="post"><table style="width:300px"><tr><td class="title">';
      echo '<h2>' . $a . '</h2></td></tr><tr><td class="author">' . $b;
      echo '</td></tr><tr><td class="body">' . $c . '</td></tr></table></div>';
      $stmt->close();
   }
  }

  $fields = 'title, author, body';

  if (!empty($_GET)) {
    $id=$_GET['id'];
    if ($id) {
      get_db($mysqli, $fields, $id);
    }
  }
?>
