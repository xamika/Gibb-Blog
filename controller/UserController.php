<?php
require_once(dirname(__DIR__) . "../model/database.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
new UserController();

class UserController
{
    private static $database;

    public function __construct()
    {
        self::$database = new Database();
        if (isset($_REQUEST['regist'])) {
            $this->create($_POST);
        } elseif (isset($_REQUEST['login'])) {
            $this->login($_POST);
        } elseif (isset($_REQUEST['delete'])) {
            $this->delete($_GET['delete']);
        } elseif (isset($_REQUEST['setAdmin'])) {
            $this->setAdmin($_GET['setAdmin']);
        }
    }

    function create($postparams)
    {

        $vorname = $postparams['vorname'];
        $name = $postparams['name'];
        $email = $postparams['email'];
        $sex = $postparams['sex'];
        $password = $postparams['password'];
        $maskulin = 0;
        if ($sex == 'M') {
            $maskulin = 1;
        }
        $valid = $this->validation($postparams);
        $valid2 = $this->validationRegistrierung($postparams);
        $validation = $valid . $valid2;
        if ($validation == "") {
            $query = "INSERT INTO User (vorname, name, email, password, maskulin) VALUES ('" . $vorname . "','" . $name . "','" . $email . "','" . md5($password) . "','". $maskulin ."')";
            $dbReturn = self::$database->insert($query);
            if ($dbReturn == "success") {
                header("Location: ../index.php?page=login&success=User+erfolgreich+erstellt");
            } else {
                echo $dbReturn;
            }
        } else {
            $url = '../index.php?page=registrieren&error=' . $validation .
                '&vorname=' . $postparams['vorname'] .
                '&name=' . $postparams['name'] .
                '&email=' . $postparams['email'];
            header("Location: " . $url);
        }
    }

    function validationRegistrierung($postparams) {
        $returnString = "";
        if (isset($postparams['email'])) {
            $query = "SELECT * FROM USER WHERE email = '" . $postparams['email'] ."'";
            $result = self::$database->showOne($query);
            if ($result['email'] != "") {
                $returnString = $returnString . " Die Emailadresse ist bereits vergeben.";
            }
        }
        return $returnString;
    }

    function validation($postparams)
    {
        $returnString = "";
        if (isset($postparams['vorname']) && $postparams['vorname'] == "") {
            $returnString = $returnString . "Bitte geben Sie einen Vornamen ein. ";
        }
        if (isset($postparams['name']) && $postparams['name'] == "") {
            $returnString = $returnString . "Bitte geben Sie einen Namen ein. ";
        }
        if (isset($postparams['email']) && $postparams['email'] == "") {
            $returnString = $returnString . "Bitte geben Sie eine Emailadresse ein. ";
        }
        if (isset($postparams['password']) && $postparams['password'] == "") {
            $returnString = $returnString . "Bitte geben Sie ein Passwort ein. ";
        }
        if (isset($postparams['passwordReply']) && $postparams['password'] != $postparams['passwordReply']) {
            $returnString = $returnString . "Die Passwörter stimmen nicht überein. ";
        }
        return $returnString;
    }

    function login($postparams)
    {
        $valid = false;
        $results = self::$database->showOne("SELECT * FROM User WHERE email LIKE '" . $postparams['email'] . "' AND
            password LIKE '" . md5($postparams['password']) . "'");
        $validation = $this->validation($postparams);
        if ($validation == "") {
            $valid = true;
        } else {
            $url = '../index.php?page=login&error=' . $validation;
            header("Location: " . $url);
        }
        if ($results["email"] != "" && $valid) {
            $message = "Hallo " . $results["vorname"] . " du hast die erfolgreich angemeldet";
            $url = '../index.php?page=home&success=' . $message;
            if ($results['admin'] == 1) {
                $_SESSION['login'] = "admin";
            } else {
                $_SESSION['login'] = "user";
            }
            $_SESSION['userId'] = $results["id"];
            header("Location: " . $url);
        } elseif ($valid) {
            $url = '../index.php?page=login&error=' . " Deine Emailadresse oder das Passwort ist falsch.";
            header("Location: " . $url);
        }
    }

    function delete($userId) {
        if ($_SESSION['login'] == "admin") {
            $query = "DELETE FROM User WHERE id =" . $userId;
            $dbReturn = self::$database->execute($query);
            if ($dbReturn == "success") {
                header("Location: ../index.php?page=admin&success=User+erfolgreich+gelöst");
            } else {
                header("Location: ../index.php?page=admin&error=" . $dbReturn);
            }
        } else {
            header("Location: ../index.php?page=home&error=" . "Sie sind nicht Berechtigt diesen User zu löschen");
        }
    }

    function getAll()
    {
        $query = "SELECT id, name, vorname, email, maskulin, admin FROM User";
        return self::$database->showMany($query);
    }

    function  setAdmin($userId) {
        $query = "UPDATE User SET admin= 1 WHERE id = " . $userId;
        $dbReturn = self::$database->insert($query);
        if ($dbReturn == "success") {
            header("Location: ../index.php?page=admin&success=User+erfolgreich+bearbeitet");
        } else {
            header("Location: ../index.php?page=admin&error=" . $dbReturn);
        }
    }
}
