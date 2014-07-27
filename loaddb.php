<?php
  // later, separate data and article loading
  // i.e. create CSV, loop through and obtain the articles
  // place into an array of stdClass objects? 
  $articles = array();
  function artic_create($title, $author, $email, $body) { 
    $one = new stdClass();
    $one->title = $title;
    $one->author = $author;
    $one->email = $email;
    $one->body = $body;
    return $one;
  }
  /*
  $articles[] = artic_create('Cats', 'Fish', 'fish@mail.com', 'Very good. If I added a lot of lines here, what would happen? Does it go on forever? I really do not like fish it is so much work to eat.');
  $articles[] = artic_create('Title', 'Author', 'author@mail.com', 'Content here.');
  $articles[] = artic_create('Cake', 'Baker', '', 'Frosting. So much frosting.');

  $articles[] = artic_create('Going on', 'First Last', 'first@mail.com', 'Mark territory give attitude streeeeetch shake same spot. Hide when guests come. All of sudden cat goes crazy destroys iPod screen chew iPad power cord. Missing until dinner. Destroy couch claw draps flop over.');
  $articles[] = artic_create('Last', 'Tired Names', 'tired@mail.com', 'Food is great. Test text all around here.');  
  */

$longtxt = "Sweet beast under the bed throwup on your pillow. Leave dead animals as gifts all of a sudden cat goes crazy but inspect anything brought into the house. Chase mice chew iPad power cord. Give attitude. Leave dead animals as gifts streeeeeeetch and burrow under covers and throwup on your pillow and chew foot yet burrow under covers but intrigued by the shower. Claw drapes need to chase tail and intrigued by the shower chew iPad power cord and nap all day run in circles. Cat snacks sun bathe but intently sniff hand and destroy couch so sweet beast for stare at ceiling. Make muffins play time and hide when guests come over for flop over or sun bathe. 

Claw drapes. Hunt anything that moves. Destroy couch intently sniff hand. Chew foot need to chase tail chase mice streeeeeeetch behind the couch. Lick butt intently sniff hand. Sleep on keyboard. Attack feet shake treat bag. 

Missing until dinner time chase imaginary bugs yet throwup on your pillow, sweet beast chew iPad power cord so streeeeeeetch or hide when guests come over. Climb leg play time so missing until dinner time, make muffins. Rub face on everything stare at ceiling flop over inspect anything brought into the house. Play time. Stand in front of the computer screen shake treat bag intently sniff hand yet hopped up on catnip, hate dog but nap all day. Hopped up on catnip behind the couch, yet behind the couch chase mice chase imaginary bugs, hate dog for swat at dog. Attack feet flop over, rub face on everything whos the baby. Hunt anything that moves inspect anything brought into the house. Play time hide when guests come over under the bed need to chase tail yet shake treat bag and leave hair everywhere.";
  $articles[] = artic_create('Long Talks', 'Your Name', 'name@mail.com',
  $longtxt);

  include("dbinfo.inc.php");
  $mysqli = new mysqli($host, $username, $password, $database);
  if ($mysqli->connect_errno) {
    echo "Failed";
  }

/*  $create = "CREATE TABLE authors (ID int(11) AUTO_INCREMENT, name varchar(255), email varchar(255), PRIMARY KEY (ID))";
  */
  /*
  $create = "CREATE TABLE authors (ID int(11) AUTO_INCREMENT, name varchar(255), email varchar(255), PRIMARY KEY (ID))";
  $drop = "ALTER TABLE articles DROP COLUMN author";
  $addauth = "ALTER TABLE articles ADD COLUMN author_id int(11)";
  */
  $addtime = "ALTER TABLE articles ADD COLUMN post_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
  //$cmds = array($create, $drop, $addauth, $addtime);
  $cmds = array($addtime);
  foreach ($cmds as $cmd) {
    if (mysqli_query($mysqli,$cmd)) {
      echo "Successful";
    }
    else {
      echo "Failed";
    }
  }
  // THESE TWO FUNCTIONS CAN BE GENERALIZED LATER. 
  function insert_auth($author, $email, $mysqli) {
    $query = "INSERT INTO authors (name, email) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ss', $author, $email);
    $stmt->execute();
    $stmt->close();
  }
  // USED TO INSERT INTO DB BEFOREHAND. 
  function insert_db($title, $author, $email, $body, $mysqli) {
    $found = "SELECT ID FROM authors WHERE name='" . $author . "' AND email='" . $email . "'"; 
    if ($stmt = $mysqli->prepare($found)) {
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($i);
      $stmt->fetch();
      echo $i;
      $query = "INSERT INTO articles (title, author_id, body) VALUES (?, ?, ?)";
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('sis', $title, $i, $body);
      $stmt->execute();
      $stmt->close();
    }
  }
  foreach ($articles as $o) {
    insert_auth($o->author,$o->email,$mysqli);
    insert_db($o->title,$o->author,$o->email,$o->body, $mysqli);
  }
?>

