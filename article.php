<html> 
<head>
<link rel="stylesheet" href="article.css"/>
</head>
<body>
  <div class="side">
    <img src="cropped.jpg" class="sidebar" />
  </div>
  <div id="buffer">
  </div>
<?php
  $mysqli = new mysqli("127.0.0.1", "root", "", "kathy_blog");
  if ($mysqli->connect_errno) {
    echo "Failed";
  }
 
 // lots of reused code: next time make an object and refactor
  
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
  function get_db($mysqli, $str_params, $which) {
    $query = "SELECT " . $str_params . " FROM articles WHERE ID=" . $which;
    if ($stmt = $mysqli->prepare($query)) {
      $stmt->execute();
      $stmt->store_result();  
      $stmt->bind_result($a, $b, $c);
      $stmt->fetch();
      $auth_info = get_author($mysqli, $b);
      echo '<div class="post"><span class="title">';
      echo '<h2>' . $a . '</h2></span><span class="author">';
      echo $auth_info['name'];
      echo '</span><br /><span class="body">' . $c . '</span><br /></div>';
      $stmt->close();
   }
  }

  $fields = 'title, author_id, body';

  if (!empty($_GET)) {
    $id=$_GET['id'];
    if ($id) {
      get_db($mysqli, $fields, $id);
    }
  }
?>
</body>
</html>
