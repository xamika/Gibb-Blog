<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php?page=home">Home</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php if ($_SESSION['login'] == "admin" || $_SESSION['login'] == "user") { ?>
                    <li>
                        <a href="index.php?page=newPost">Neuer Post</a>
                    </li>
                    <li>
                        <a href="index.php?page=logout">Logout</a>
                    </li>
                <?php } else { ?>
                    <li>
                        <a href="index.php?page=login">Login</a>
                    </li>
                    <li>
                        <a href="index.php?page=registrieren">Registrieren</a>
                    </li>
                <?php
                }
                if ($_SESSION['login'] == "admin") { ?>
                    <li>
                        <a href="index.php?page=admin">admin</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>