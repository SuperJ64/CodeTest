<?php
require_once 'init/init.php';

if (isset($_POST['token'])) {
    if (Token::check($_POST['token'])) {

        $user = new User();
        if ($user->login($_POST['email'], $_POST['password'])) {
            header("Location: dash.php");
        } else {
            $badLogin = "Incorrect email or password, try again";
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<?php include 'partials/header.php' ?>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card login-card">
                <div class="card-header text-center">Log In</div>

                <div class="card-body">
                    <form method="post">


                        <div class="form-group text-center">
                            <?php
                            if (isset($badLogin)) {
                                echo '<div class="alert-danger">' . $badLogin . '</div>';
                            }

                            ?>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" type="password" name="password">
                        </div>

                        <input type="hidden" name="token" value="<?php echo Token::generate() ?>">

                        <input class="btn btn-primary" type="submit" value="Login">
                    </form>
                </div>

                <div class="card-footer text-center">
                    <a href="index.php">Or Register new account</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php' ?>

</body>
</html>