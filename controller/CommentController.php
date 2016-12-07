<?php
require_once(dirname(__DIR__) . "../model/database.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
new CommentController();

class CommentController
{
    private static $database;

    public function __construct()
    {
        self::$database = new Database();
        if (isset($_REQUEST['newComment'])) {
            $this->create($_POST);
        } elseif (isset($_GET['deleteComment'])) {
            $this->delete($_GET['deleteComment'], $_GET['postId']);
        }
    }

    function create($postparams)
    {
        $titel = $postparams['titel'];
        $text = $postparams['text'];
        $userId = $_SESSION['userId'];
        $postId = $postparams['newComment'];
        $valid = $this->validation($postparams);
        if ($valid == "") {
            $my_date = date("Y-m-d H:i:s");
            $query = "INSERT INTO Comment (titel, text, userid, date, postid) VALUES ('" . $titel . "','" . $text . "'," . $userId . ",'" . $my_date . "'," . $postId . ")";
            $dbReturn = self::$database->insert($query);
            if ($dbReturn == "success") {
                header("Location: ../index.php?page=showpost&success=Kommentar+erfolgreich+erstellt&id=" . $postId);
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

    function delete($commentId, $postId)
    {
        if ($this->authorize($postId)) {
            $query = "DELETE FROM Comment WHERE id =" . $commentId;
            $dbReturn = self::$database->execute($query);
            if ($dbReturn == "success") {
                header("Location: ../index.php?page=showpost&success=Kommentar+erfolgreich+gelöst&id=" . $postId);
            } else {
                header("Location: ../index.php?page=home&error=" . $dbReturn);
            }
        } else {
            header("Location: ../index.php?page=home&error=" . "Sie sind nicht Berechtigt diesen Kommentar zu löschen");
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

    function searchByPostId($postId)
    {
        $query = "SELECT id, titel, text, date, userid, postid FROM Comment WHERE postid = ".$postId ." ORDER BY id DESC";
        return self::$database->showMany($query);
    }

    function authorize($postId)
    {
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
