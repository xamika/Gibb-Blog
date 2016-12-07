<?php
$vorname = (isset($_GET['vorname']) ? $_GET['vorname'] : "");
$name = (isset($_GET['name']) ? $_GET['name'] : "");
$email = (isset($_GET['email']) ? $_GET['email'] : "");
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>Login</h2>
            <form role="form" method="post" action="controller/UserController.php">
                <div class="form-group">
                    <label for="text">Vorname:</label>
                    <input name="vorname" type="text" class="form-control" id="text" placeholder="Vorname eingeben" value="<?php echo $vorname ?>" required>
                </div>
                <div class="form-group">
                    <label for="text">Name:</label>
                    <input name="name" type="text" class="form-control" id="text" placeholder="Name eingeben" value="<?php echo $name ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="Enter email" value="<?php echo $email ?>" required>
                </div>
                <div class="radio">
                    <label><input value="M" type="radio" name="sex" required>M&auml;nnlich</label>
                </div>
                <div class="radio">
                    <label><input value="W" type="radio" name="sex" required>Weiblich</label>
                </div>
                <div class="form-group">
                    <label for="pwd">Passwort:</label>
                    <input name="password" type="password" class="form-control" id="pwd" placeholder="Enter password" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Passwort Wiederholen:</label>
                    <input name="passwordReply" type="password" class="form-control" id="pwd" placeholder="Enter password" required>
                </div>

                <button type="submit" name="regist" value="regist" class="btn btn-default">Registrieren</button>
            </form>
            <br />
            <br />
        </div>
    <div>
</div>