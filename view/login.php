<div class="container">
    <div class="row">
        <h2>Login</h2>

        <form role="form" method="post" action="controller/UserController.php">
            <div class="form-group">
                <label for="email">Email:</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input name="password" type="password" class="form-control" id="pwd" placeholder="Enter password">
            </div>
            <div class="checkbox">
                <label><input type="checkbox"> Remember me</label>
            </div>
            <button type="submit" name="login" value="login" class="btn btn-default">Login</button>
        </form>
    </div>
</div>