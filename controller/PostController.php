<?php
require_once(dirname(__DIR__) . "../model/database.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
new PostController();

class PostController
{
    private static $database;

    public function __construct()
    {
        self::$database = new Database();
        if (isset($_REQUEST['newPost'])) {
            $this->create($_POST);
        } elseif (isset($_REQUEST['editPost'])) {
            $this->edit($_POST);
        } elseif (isset($_GET['deletePost'])) {
            $this->delete($_GET['deletePost']);
        }
    }

    function create($postparams)
    {

        $titel = $postparams['titel'];
        $text = $postparams['text'];
        $userId = $_SESSION['userId'];
        $valid = $this->validation($postparams);
        if ($valid == "") {
            $my_date = date("Y-m-d H:i:s");
            $query = "INSERT INTO Post (titel, text, userid, date) VALUES ('" . $titel . "','" . $text . "'," . $userId . ",'" . $my_date . "')";
            $dbReturn = self::$database->insert($query);
            if ($dbReturn == "success") {
                header("Location: ../index.php?page=home&success=Post+erfolgreich+erstellt");
            } else {
                echo $dbReturn;
            }
        } else {
            $url = '../index.php?page=newPost&error=' . $valid .
                '&titel=' . $postparams['titel'] .
                '&text=' . $postparams['text'];
            header("Location: " . $url);
        }
    }

    function delete($postId) {
        if ($this->authorize($postId)) {
            $query = "DELETE FROM Post WHERE id =" . $postId;
            $dbReturn = self::$database->execute($query);
            $query = "DELETE FROM Comment WHERE postid =" . $postId;
            $dbReturn = $dbReturn . self::$database->execute($query);
            if ($dbReturn == "successsuccess") {
                header("Location: ../index.php?page=home&success=Post+erfolgreich+gelöst");
            } else {
                header("Location: ../index.php?page=home&error=" . $dbReturn);
            }
        } else {
            header("Location: ../index.php?page=home&error=" . "Sie sind nicht Berechtigt diesen Post zu löschen");
        }

    }

    function  edit($postparams)
    {
        $postId = $postparams['editPost'];
        if ($this->authorize($postId)) {
            $titel = $postparams['titel'];
            $text = $postparams['text'];
            $valid = $this->validation($postparams);
            if ($valid == "") {
                $query = "UPDATE Post SET titel='" . addslashes($titel) . "', text='" . addslashes($text) . "' WHERE id = " . $postId;
                $dbReturn = self::$database->insert($query);
                if ($dbReturn == "success") {
                    header("Location: ../index.php?page=home&success=Post+erfolgreich+bearbeitet");
                } else {
                    header("Location: ../index.php?page=home&error=" . $dbReturn . " Bitte verwenden sie nur Buchstaben von a-z und Zahlen");
                }
            }
        } else {
            header("Location: ../index.php?page=home&error=" . "Sie sind nicht berechtigt diesen Post zu bearbeiten.");
        }
    }

    function validation($postparams)
    {
        $returnString = "";
        if (!isset($postparams['titel']) || $postparams['titel'] == "") {
            $returnString = $returnString . "Sie müssen einen Titel definieren. ";
        }
        if (!isset($postparams['text']) || $postparams['text'] == "") {
            $returnString = $returnString . "Sie müssen einen Text definieren. ";
        }
        return $returnString;
    }

    function  getAll()
    {
        $query = "SELECT p.id as postid,  u.id as userid, p.titel, p.text, p.date, u.name, u.vorname FROM Post AS p JOIN User AS u WHERE p.userid = u.id ORDER BY p.id DESC ";
        return self::$database->showMany($query);
    }

    function searchByTitel($searchString)
    {
        $query = "SELECT p.id as postid,  u.id as userid, p.titel, p.text, p.date, u.name, u.vorname FROM Post AS p JOIN User AS u WHERE p.userid = u.id AND p.titel LIKE '%" . addslashes($searchString) . "%' ORDER BY p.id DESC";
        return self::$database->showMany($query);
    }

    function searchByUserIdAndTitel($userid, $titel)
    {
        $query = "SELECT p.id as postid,  u.id as userid, p.titel, p.text, p.date, u.name, u.vorname FROM Post AS p JOIN User AS u WHERE p.userid = u.id AND p.titel LIKE '%" . addslashes($titel) . "%' AND u.id = " . $userid . " ORDER BY p.id DESC";
        return self::$database->showMany($query);
    }

    function searchByUserId($userid)
    {
        $query = "SELECT p.id as postid,  u.id as userid, p.titel, p.text, p.date, u.name, u.vorname FROM Post AS p JOIN User AS u WHERE p.userid = u.id AND u.id = " . $userid;
        return self::$database->showMany($query);
    }

    function searchById($id)
    {
        $query = "SELECT p.id as postid,  u.id as userid, p.titel, p.text, p.date, u.name, u.vorname FROM Post AS p JOIN User AS u WHERE p.userid = u.id AND p.id LIKE " . $id;
        return self::$database->showOne($query);
    }

    function authorize($postId) {
        if ($_SESSION['login'] == "admin") {
            return true;
        }
        $userId = $_SESSION['userId'];
        $query = "SELECT userid  FROM Post WHERE id =" . $postId;
        $result = self::$database->showOne($query);
        if ($result['userid'] == $userId) {
            return true;
        } else {
            return false;
        }
    }
}
