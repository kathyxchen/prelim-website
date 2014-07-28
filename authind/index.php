<html>
<head>
  <link rel="stylesheet" href="style.css"/>
  <link rel="stylesheet" href="../general.css"/>
  <title>groundwork.</title>
</head>
<body>
    <div id="menu"> 
        <?php
            $menu = array(
            'HOME'=>'../', 
            "POSTS"=>'../#posts-container',
            'SUBMISSION'=>'../submit',
            "AUTHOR INDEX"=>'');
            foreach ($menu as $tab => $link) {
                echo '<span class="tab">';
                echo '<a href="' . $link . '">' . $tab . '</a></span>';
            }
        ?>
    </div>
    <div id="container">
    <div id="side">
        <img src="../cropped.jpg" id="sidebar" />
    </div>
    <div id="buffer">
    </div>
    <div id="authindex">
      <h2><br />The Authors</h2>
      <div id="index">
      <?php
        include("../dbinfo.inc.php");
        $mysqli = new mysqli($host, $username, $password, $database);
        if ($mysqli->connect_errno) {
          echo "Failed";
        }
       
       function check($email) {
          if (!$email || $email == '') {
            return '';
          }
          else {
            return '<span class="mail"> (' . '<a class="mlink" href="mailto:' . $email . '">contact' . '</a>) </span>';
          }
       }

        function convertTime($d) {
          $ts = strtotime($d);
          return date("F d, Y", $ts);
        }

        function match_title($ia, $mysqli) {
          $query = "SELECT title, post_time, ID FROM articles WHERE author_id=" . $ia . " ORDER BY post_time DESC";
          if ($stmt = $mysqli->prepare($query)) {
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($t, $pt, $it);
            while ($stmt->fetch()) {
              echo '<ul class="title"><a href="../article.php?id=' . $it . '">' . $t . ' (' . convertTime($pt) . ')</a></ul>';
            }
          }
        }

        $found = "SELECT name, email, ID FROM authors ORDER BY name"; 
        if ($stmt = $mysqli->prepare($found)) {
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($n, $e, $ia);
            while ($stmt->fetch()) {
              echo '<div class="auth">' . $n;
              echo check($e);
              match_title($ia, $mysqli);
              echo '</div>';
            }
        }
      ?>
      </div>
    </div>
    </div>
</body>
</html>
