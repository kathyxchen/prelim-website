<html> 
<head>
<link rel="stylesheet" href="article.css"/>
<link rel="stylesheet" href="general.css"/>
</head>
<body>
  
  <div id="menu"> 
    <?php
        $menu = array(
            'HOME'=>'../kc', 
            "POSTS"=>'../kc/#posts-container',
            'SUBMISSION'=>'submit',
            "AUTHOR INDEX"=>'authind');
            foreach ($menu as $tab => $link) {
                echo '<span class="tab">';
                echo '<a href="' . $link . '">' . $tab . '</a></span>';
            }
        ?>
  </div>
  <div id="container">
  <div id="side">
    <img src="cropped.jpg" id="sidebar" />
  </div>
<?php
  include("dbinfo.inc.php");
  include("email.php");
  include("author.php");
  $mysqli = new mysqli($host, $username, $password, $database);
  if ($mysqli->connect_errno) {
    echo "Failed";
  }
 

  function convertTime($d) {
    $ts = strtotime($d);
    return date("F d, Y", $ts);
  }

  function get_db($mysqli, $str_params, $which) {
    $query = "SELECT " . $str_params . " FROM articles WHERE ID=" . $which;
    if ($stmt = $mysqli->prepare($query)) {
      $stmt->execute();
      $stmt->store_result();  
      $stmt->bind_result($a, $b, $c, $d);
      $stmt->fetch();
      $auth_info = get_author($mysqli, $b);
      echo '<div class="post"><div class="title">';
      echo '<h2>' . $a . '</h2></div><div class="author">';
      echo check($auth_info['email'], $auth_info['name']);
      echo '</div><div class="body">' . $c . '</div>';
      echo '<span class="tm">(submitted ' . convertTime($d) . '.)</span></div>';
      $stmt->close();
   }
  }

  $fields = 'title, author_id, body, post_time';

  if (!empty($_GET)) {
    $id=$_GET['id'];
    if ($id) {
      get_db($mysqli, $fields, $id);
    }
  }
?>
  </div>
</body>
</html>
