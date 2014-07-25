<html>
<head>
  <link rel="stylesheet" href="style.css"/>
  <title>read me.</title>
</head>
<body>
  <div id="container">
    <div id="menu"> 
        <?php
            $menu = array(
            'HOME'=>'', 
            'SUBMISSION'=>'submit',
            "AUTHOR'S INDEX"=>'authind');
            foreach ($menu as $tab => $link) {
                echo '<div class="tab">' . $tab . '</div>';
            }
        ?>
    </div>
    <div id="top">
    <div id="overlay">
      <img class="bg" alt="" src="city.jpg" />
    </div>
    <div id="about">    
      <h2> Presently </h2>
      <?php 
        echo date('l, F d, Y') . '<br /></div>';
      ?>
    </div>
    </div>
    <div id="transition">
    </div>
    <br />
    <div id="posts-container" class="top">    
    <?php
      $mysqli = new mysqli("127.0.0.1", "root", "test54321", "kathy_blog");
      if ($mysqli->connect_errno) {
        echo "Failed";
      }
      // maybe implement infinite scrolling later
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
      function get_db($mysqli) {
        $query = "SELECT title, author_id, body, ID FROM articles ORDER BY ID DESC";
        if ($stmt = $mysqli->prepare($query)) {
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($a, $b, $c, $d);
          while ($stmt->fetch()) {
            if (strlen($c) > 650) {
                $c = substr($c,0,650) . ' ...';
            }
            $author_info = get_author($mysqli, $b);
            echo '<article id="' .$d .'" class="entry"><span class="title">';
            echo '<h2><a href="article.php?id=' . $d . '">';
            echo $a . '</a></h2></span><span class="author">';
            echo $author_info['name'];
            echo '</span><br /><div class="body">' . $c;
            echo '</div></article>'; 
          }
          $stmt->free_result();
          $stmt->close();
       }
      }    
      get_db($mysqli);
    ?>
    </div>
  </div>
</body>
</html>
