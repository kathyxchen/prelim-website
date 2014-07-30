<html>
<head>
<link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" href="../stylesheets/zoom.css"/>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" href="../stylesheets/general.css"/>
</head>
<body>
    
    <div id="menu"> 
      <?php
        $menu = array(
            'HOME'=>'../', 
            "POSTS"=>'../#posts-container',
            'SUBMISSION'=>'',
            "AUTHOR INDEX"=>'../authind');
            foreach ($menu as $tab => $link) {
                echo '<span class="tab">';
                echo '<a href="' . $link . '">' . $tab . '</a></span>';
            }
      ?>
    <div class="zoombtn">
        <i id="arrows" class="fa fa-arrows-alt fa-2x"></i>
    </div>
    </div>

    <div id="container">
    <div id="side">
        <img src="../images/cropped.jpg" id="sidebar" />
    </div>
    <div id="buffer">
    </div>
    <div id="entry">
    <div id="post">
    <?php
    
    include("../dbinfo.inc.php");
    $mysqli = new mysqli($host, $username, $password, $database);
    if ($mysqli->connect_errno) {
        echo "Failed";
    }
    
    function insert_auth($author, $email, $mysqli) {
        $found = "SELECT name FROM authors WHERE name='" . $author . "' AND email='" . $email . "'"; 
        if ($stmt = $mysqli->prepare($found)) {
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($i);
            $stmt->fetch();
            if ($i) {
                echo 'Adding new entry for existing author. <br />';
            }
            else {
                echo 'Creating new author. <br />';
                $query = "INSERT INTO authors (name, email) VALUES (?, ?)";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('ss', $author, $email);
                $stmt->execute();
            }
        }
        $stmt->close();
    }
    function insert_db($title, $author, $email, $body, $mysqli) {
        $found = "SELECT ID FROM authors WHERE name='" . $author . "' AND email='" . $email . "'"; 
        if ($stmt = $mysqli->prepare($found)) {
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($i);
            $stmt->fetch();
            $query = "INSERT INTO articles (title, author_id, body) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('sis', $title, $i, $body);
            $stmt->execute();
            $stmt->close();
        }
    }
    
    $info = new StdClass();
    if (!empty($_POST)) {
        if ($_POST['body']) {
            $info->body = $_POST['body'];
            $_POST['author'] && isset($_POST['author']) ? 
                $info->author = trim($_POST['author']) : $info->author = 'Anonymous';
            $_POST['title']  && isset($_POST['title']) ? 
                $info->title = trim($_POST['title']) : $info->title = 'untitled';
            $_POST['email'] && isset($_POST['email']) ? 
                $info->email = trim($_POST['email']) : $info->email = '';
            echo "Submitting '" . $info->title . "' for " . $info->author .
            '.<br />';
            insert_auth($info->author, $info->email, $mysqli);
            insert_db($info->title, $info->author, $info->email,
            $info->body, $mysqli);
        }
        else {
            echo "Invalid. Must include an entry for successful submission.";
        }
        $_POST = array();
    }
    ?>
    </div>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <p>Title: </p>
        <p>
        <input type="text" name="title" value="" size="45" maxlength="255" />
        </p> 

        <p>Name: </p>
        <p>
        <input type="text" name="author" value="" size="45" maxlength="255" />
        </p>

        <p>E-mail: </p>
        <p>
        <input type="email" name="email" value="" size="45" maxlength="255" />
        </p>
        
        <p>Entry: </p>
        <p>
        <textarea name="body" rows="15%" cols=40"></textarea>
        </p>
        <input type="submit" name="submit" value="Submit" />
    </form>
    </div>
    </div>

  <script type="text/javascript" src="../vendors/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="../scripts/layout.js"></script>
</body>
</html>
