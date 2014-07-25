<?php
  // later, separate data and article loading
  // i.e. create CSV, loop through and obtain the articles
  // place into an array of stdClass objects? 
  $articles = array();
  function artic_create($title, $author, $body) { 
    $one = new stdClass();
    $one->title = $title;
    $one->author = $author;
    $one->body = $body;
    return $one;
  }
  $articles[] = artic_create('Cats', 'Fish', 'Very good. If I added a lot of lines here, what would happen? Does it go on forever? I really do not like fish it is so much work to eat.');
  $articles[] = artic_create('Title', 'Author', 'Content here.');
  $articles[] = artic_create('Cake', 'Baker', 'Frosting. So much frosting.');
  
  $mysqli = new mysqli("127.0.0.1", "root", "", "kathy_blog");
  if ($mysqli->connect_errno) {
    echo "Failed";
  }
  
  // USED TO INSERT INTO DB BEFOREHAND. 
  function insert_db($title, $author, $body, $mysqli) {
    $query = "INSERT INTO articles (title, author, body) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sss', $title, $author, $body);
    $stmt->execute();
    $stmt->close();
  }
  foreach ($articles as $o) {
    insert_db($o->title,$o->author,$o->body, $mysqli);
  }
?>

