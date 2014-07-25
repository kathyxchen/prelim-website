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
  $articles[] = artic_create('Cats', 'Fish', 'fish@mail.com', 'Very good. If I added a lot of lines here, what would happen? Does it go on forever? I really do not like fish it is so much work to eat.');
  $articles[] = artic_create('Title', 'Author', 'author@mail.com', 'Content here.');
  $articles[] = artic_create('Cake', 'Baker', '', 'Frosting. So much frosting.');
  
  $mysqli = new mysqli("127.0.0.1", "root", "", "kathy_blog");
  if ($mysqli->connect_errno) {
    echo "Failed";
  }
  $create = "CREATE TABLE authors (ID int(11) AUTO_INCREMENT, name varchar(255), email varchar(255), PRIMARY KEY (ID))";
  $drop = "ALTER TABLE articles DROP COLUMN author";
  $add = "ALTER TABLE articles ADD COLUMN author_id int(11)";
  $cmds = array($create, $drop, $add);
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

