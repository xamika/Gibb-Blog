<!DOCTYPE html>
<html lang="de">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Blog">
    <meta name="author" content="Tobias Egli">

    <title>Tobias Blog</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/blog-home.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<?php
session_start();
if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = "no";
}
// Navication Bar
include 'view/navigation.php';
// Message Box
include 'view/message.php';
// Page Content
if (count($_GET) > 0 && isset($_GET["page"])) {
    switch ($_GET["page"]) {
        case 'login':
            include 'view/login.php';
            break;
        case 'home':
            include 'view/home.php';
            break;
        case 'registrieren':
            include 'view/registrieren.php';
            break;
        case 'logout':
            include 'view/logout.php';
            break;
        case 'newPost':
            include 'view/newpost.php';
            break;
        case 'showpost':
            include 'view/showpost.php';
            break;
        case 'editPost':
            include 'view/editpost.php';
            break;
        case 'admin':
            include 'view/admin.php';
            break;
        default:
            include 'view/error.php';
    }
} else {
    include 'view/home.php';
}

include 'view/footer.html'
?>


<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
