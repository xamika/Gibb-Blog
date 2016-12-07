<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
                if (isset($_GET['error'])) {
                ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error: </strong>
                    <?php echo replaceUrlString($_GET['error']) ?>
                </div>
                <?php
                } // end if
                if (isset($_GET['success'])) {
                ?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success: </strong>
                    <?php echo replaceUrlString($_GET['success']) ?>
                </div>
                <?php
                }
            ?>
        </div>
    </div>
</div>

<?php
    function replaceUrlString($string) {
        $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D', '+', '%F6', '%FC');
        $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]", " ", "&ouml", "&uuml");
        return str_replace($entities, $replacements, urlencode($string));
    }

?>