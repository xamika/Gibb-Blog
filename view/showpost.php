<?php
include(dirname(__DIR__) . "../controller/PostController.php");
include(dirname(__DIR__) . "../controller/CommentController.php");
$PostController = new PostController();
$CommentController = new CommentController();
$postId = $_GET['id'];
$post = $PostController->searchById($postId);
$comments = $CommentController->searchByPostId($postId);

?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>
                <a href="index.php?page=showpost&id=<?php echo $post['postid'] ?>"><?php echo $post['titel']; ?></a>
            </h2>

            <p class="lead">
                by <a href="index.php"><?php echo $post['vorname'] . " " . $post['name']; ?></a>
            </p>

            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post['date']; ?></p>
            <hr>
            <p><?php echo str_replace("\n", "<br>", $post['text']); ?></p>
            <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == $post['userid']) { ?>
                <a class="btn btn-primary" href="index.php?page=editPost&id=<?php echo $post['postid']; ?>">
                    edit <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            <?php } ?>
            <hr>
            <h3>Kommentare:</h3>
            <?php while ($comment = $comments->fetchArray()) { ?>
                <b><?php echo $comment['titel']; ?></b>
                <p><?php echo str_replace("\n", "<br>", $comment['text']); ?></p>
                <?php if (isset($_SESSION['userId']) && $post['userid'] == $_SESSION['userId']) { ?>
                    <a class="btn btn-danger btn-xs"
                       href="controller/CommentController.php?deleteComment=<?php echo $comment['id']; ?>&postId=<?php echo $postId; ?>">
                        Delete <span class="glyphicon glyphicon-trash"></span>
                    </a>
                <?php } ?>
                <hr>
            <?php }
            if (isset($_SESSION['userId']) && $post['userid'] != $_SESSION['userId']) { ?>
                <h2>Neuer Kommentar</h2>

                <form role="form" method="post" action="controller/CommentController.php">
                    <div class="form-group">
                        <label for="email">Titel:</label>
                        <input name="titel" type="text" class="form-control" id="titel" placeholder="Titel" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Text:</label>
                    <textarea name="text" class="form-control" rows="7" id="text" placeholder="Text"
                              required></textarea>
                    </div>
                    <button type="submit" name="newComment" value="<?php echo $postId; ?>" class="btn btn-success">
                        Kommentieren <span
                            class="glyphicon glyphicon-comment"></span></button>
                </form>
            <?php } ?>
        </div>
    </div>
</div>
