<html>
<head>
  <link rel="stylesheet" href="style.css"/>
  <title>read me.</title>
</head>
<body>
  <div id="container">
    <div id="overlay"></div>
    <div id="about">    
      <h2> Presently </h2>
      <?php 
        echo date('l, F d, Y') . '<br /></div>';
      ?>
    </div>
    <div id="posts-container" class="top">    
    <?php
      $mysqli = new mysqli("127.0.0.1", "root", "", "kathy_blog");
      if ($mysqli->connect_errno) {
        echo "Failed";
      }
      // maybe implement infinite scrolling later
      function get_db($mysqli) {
        $query = "SELECT title, author, body, ID FROM articles ORDER BY ID DESC";
        if ($stmt = $mysqli->prepare($query)) {
          $stmt->execute();
          $stmt->store_result();
          $stmt->bind_result($a, $b, $c, $d);
          while ($stmt->fetch()) {
            echo '<article id="' . $d .'" class="entry">';
            echo '<table style="width:300px"><tr><td class="title">';
            echo '<h2><a href="article.php?id=' . $d . '">';
            echo $a . '</a></h2></td></tr><tr><td class="author">' . $b;
            echo '</td></tr><tr><td class="body">' . $c;
            echo '</td></tr></table><br />'; 
            echo '</article>';
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
