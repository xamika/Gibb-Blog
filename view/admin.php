<?php
include(dirname(__DIR__) . "../controller/UserController.php");
$UserController = new UserController();
$users = $UserController->getAll();
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>
                Edit User
            </h2>

            <hr>
            <table  class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Vorname</th>
                    <th>Name</th>
                    <th>Admin</th>
                    <th>Maskulin</th>
                    <th colspan="2"></th>
                </tr>
                <?php while ($user = $users->fetchArray()) { ?>
                    <tr>
                        <td><?php echo $user['id'] ?></td>
                        <td><?php echo $user['email'] ?></td>
                        <td><?php echo $user['vorname'] ?></td>
                        <td><?php echo $user['name'] ?></td>
                        <td><?php echo $user['admin'] ?></td>
                        <td><?php echo $user['maskulin'] ?></td>
                        <td><a href="controller/UserController.php?delete=<?php echo $user['id'] ?>">Delete</a></td>
                        <td><a href="controller/UserController.php?setAdmin=<?php echo $user['id'] ?>">Set Admin</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
