<?php
include(dirname(__DIR__) . "../controller/PostController.php");
include(dirname(__DIR__) . "../controller/UserController.php");
$PostController = new PostController();
$UserController = new UserController();
$users = $UserController->getAll();
$posts = null;
if (isset($_GET['user']) && $_GET['user'] != "alle" && isset($_GET['searchtext'])) {
    $posts = $PostController->searchByUserIdAndTitel($_GET['user'], $_GET['searchtext']);
} elseif (isset($_GET['user']) && $_GET['user'] != "alle") {
    $posts = $PostController->searchByUserId($_GET['user']);
} elseif (isset($_GET['searchtext'])) {
    $posts = $PostController->searchByTitel($_GET['searchtext']);
} else {
    $posts = $PostController->getAll();
}

?>
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                Tobias Blog
                <small>Willkommen auf meinem Blog</small>
            </h1>
            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Filter <span class="glyphicon glyphicon-filter"></span>
            </a>
            <div class="collapse" id="collapseExample">
                <div class="well">
                    <div class="input-group">
                        <form role="form" method="get" action="index.php?page=home">
                            <p>Suche nach Titel:</p>
                            <input name="searchtext" type="text" class="form-control">
                            <p>Blogger:</p>
                            <select name="user" class="form-control" id="user">
                                <option>alle</option>
                                <?php while ($row = $users->fetchArray()) { ?>
                                    <option
                                        value="<?php echo $row['id'] ?>"><?php echo $row['vorname'] . " " . $row['name'] ?></option>
                                <?php } ?>
                            </select>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                Suche <span class="glyphicon glyphicon-search"></span>
                            </button>
                            <a href="index.php" class="btn btn-info" role="button">Reset</a>
                        </span>
                        </form>
                    </div>
                </div>
            </div>
            <?php

            while ($row = $posts->fetchArray()) {

                ?>
                <h2>
                    <a href="index.php?page=showpost&id=<?php echo $row['postid'] ?>"><?php echo $row['titel']; ?></a>
                </h2>

                <p class="lead">
                    by <a href="index.php"><?php echo $row['vorname'] . " " . $row['name']; ?></a>
                </p>

                <p><span class="glyphicon glyphicon-time"></span> <?php echo $row['date']; ?></p>
                <hr>
                <p><?php echo substr(str_replace("\n", "<br>", $row['text']),0,300); ?></p>
                <a class="btn btn-primary" href="index.php?page=showpost&id=<?php echo $row['postid'] ?>">
                    Mehr <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
                <?php if (isset($_SESSION['userId']) && ($_SESSION['userId'] == $row['userid'] || $_SESSION['login'] == "admin")) { ?>
                    <a class="btn btn-primary" href="index.php?page=editPost&id=<?php echo $row['postid'] ?>">
                        edit <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                <?php } ?>
                <hr>
                <?php
            } //end while
            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-4">

            <!-- Blog Search Well -->
            <div class="well">
                <h4>Blog Search</h4>

                <div class="input-group">
                    <form role="form" method="get" action="index.php?page=home">
                        <input name="searchtext" type="text" class="form-control">
                        <label for="user">Blogger:</label>
                        <select name="user" class="form-control" id="user">
                            <option>alle</option>
                            <?php while ($row = $users->fetchArray()) { ?>
                                <option
                                    value="<?php echo $row['id'] ?>"><?php echo $row['vorname'] . " " . $row['name'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                            <a href="index.php" class="btn btn-info" role="button">Reset</a>
                        </span>
                    </form>
                </div>
                <!-- /.input-group -->
            </div>
        </div>

    </div>

</div>