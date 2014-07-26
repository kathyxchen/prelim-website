<html> 
<head>
<link rel="stylesheet" href="article.css"/>
</head>
<body>
  
  <div id="menu"> 
    <?php
        $menu = array(
            'HOME'=>'../kc', 
            'SUBMISSION'=>'submit',
            "AUTHOR'S INDEX"=>'authind');
            foreach ($menu as $tab => $link) {
                echo '<div class="tab">';
                echo '<a href="' . $link . '">' . $tab . '</a></div>';
            }
        ?>
  </div>
  <div class="side">
    <img src="cropped.jpg" class="sidebar" />
  </div>
  <div id="buffer">
  </div>
<?php
  $mysqli = new mysqli("127.0.0.1", "root", "test54321", "kathy_blog");
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
      echo '<div class="post"><div class="title">';
      echo '<h2>' . $a . '</h2></div><div class="author">';
      echo $auth_info['name'];
      echo '</div><div class="body">' . $c . '</div><br /></div>';
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
