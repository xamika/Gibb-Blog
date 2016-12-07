<?php

include(dirname(__DIR__) . "../controller/PostController.php");
$PostController = new PostController();
$result = $PostController->searchById($_GET['id']);

?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>Neuer Post</h2>

            <form role="form" method="post" action="controller/PostController.php">
                <div class="form-group">
                    <label for="email">Titel:</label>
                    <input name="titel" type="text" class="form-control" id="titel" placeholder="Titel"
                           value="<?php echo $result['titel'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Text:</label>
                    <textarea name="text" class="form-control" rows="7" id="text" placeholder="Text"
                              required><?php echo $result['text'] ?>
                    </textarea>
                </div>
                <button type="submit" name="editPost" value="<?php echo $_GET['id'] ?>" class="btn btn-success">
                    Speichern <span class="glyphicon glyphicon-floppy-disk"></span>
                </button>
            </form>
            <br>
            <a class="btn btn-danger" href="controller/PostController.php?deletePost=<?php echo $_GET['id'] ?>">
                Delete <span class="glyphicon glyphicon-trash"></span>
            </a>
        </div>
    </div>
</div>
