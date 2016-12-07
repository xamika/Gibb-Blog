<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>Neuer Post</h2>

            <form role="form" method="post" action="controller/PostController.php">
                <div class="form-group">
                    <label for="email">Titel:</label>
                    <input name="titel" type="text" class="form-control" id="titel" placeholder="Titel" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Text:</label>
                    <textarea name="text" class="form-control" rows="7" id="text" placeholder="Text"
                              required></textarea>
                </div>
                <button type="submit" name="newPost" value="newPost" class="btn btn-success">Absenden <span
                        class="glyphicon glyphicon-floppy-disk"></span></button>
            </form>
        </div>
    </div>
</div>
