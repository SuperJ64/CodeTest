<?php
require_once 'init/init.php';

if (isset($_POST['email'])) {

    $user = new User();
    if ($user->login($_POST['email'], $_POST['password'])) {
        header("Location: dash.php");
    } else {
        $badLogin = "Incorrect email or password, try again";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<?php include 'partials/header.php' ?>

<body>
<div class="mx-auto">
    <div class="card text-center">
        <div class="card-header">
            Log In
        </div>
        <div class="card-body">
            <form method="post">

                <?php
                if (isset($badLogin)) {
                    echo '<span class="error">'.$badLogin.'</span>';
                }

                ?>

                <label for="email">Email</label>
                <input type="email" name="email" required>

                <label for="password">Password</label>
                <input type="password" name="password">

                <input type="submit" value="Login">
            </form>
        </div>
        <div class="card-footer text-muted">
            <a href="index.php">Or Register new account</a>
        </div>
    </div>
</div>

<?php include 'partials/footer.php' ?>

</body>
</html>