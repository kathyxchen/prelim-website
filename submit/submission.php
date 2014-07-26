<?php
    $mysqli = new mysqli("127.0.0.1", "root", "test54321", "kathy_blog");
    if ($mysqli->connect_errno) {
        echo "Failed";
    } else {
        echo "Accessed";
    }
    
    function insert_auth($author, $email, $mysqli) {
        $found = "SELECT name FROM authors WHERE name='" . $author . "' AND email='" . $email . "'"; 
        if ($stmt = $mysqli->prepare($found)) {
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($i);
            $stmt->fetch();
            if (!$i) {
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
            echo $i;
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
            $_POST['author'] ? $info->author = $_POST['author'] : $info->author = 'Anonymous';
            $_POST['title'] ? $info->title = $_POST['title'] : $info->title = 'untitled';
            $_POST['email'] ? $info->email = $_POST['email'] : $info->email = '';
        }
        else {
            echo "Invalid. Must include an entry for successful submission.";
        }
        echo 'Submitting ' . $info->title . ' for ' . $info->author;
    }
?>
