<?php
require_once 'init/init.php';

if (isset($_POST['token'])) {
    if (Token::check($_POST['token'])) {

        $user = new User();
        $found = $user->find($_POST['email']);

        $email = $_POST['email'];
        $password = $_POST['password'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];

        if ($found) {
            $emailErr = "This email is already being used";
        } else {

            //encrypt password
            $pass = password_hash($password, PASSWORD_BCRYPT);

            $user->create([$email, $pass, $fname, $lname]);
            $user->login($email, $password);

            header("Location: dash.php");

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
                <div class="card-header text-center">Register New Account</div>

                <div class="card-body">
                    <form method="post">

                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input class="form-control" type="text" name="fname" required
                                <?php if (isset($fname)) echo 'value=' . $fname ?>
                            >
                        </div>


                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input class="form-control" type="text" name="lname" required
                                <?php if (isset($lname)) echo 'value=' . $lname ?>
                            >
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email" required
                                <?php if (isset($email)) echo 'value=' . $email ?>
                            >
                            <?php
                            if (isset($emailErr)) {
                                echo '<div class="text-danger">' . $emailErr . '</div>';
                            }

                            ?>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" type="password" name="password" required>
                        </div>

                        <input type="hidden" name="token" value="<?php echo Token::generate() ?>">

                        <input class="btn btn-primary" type="submit" value="Register">

                    </form>
                </div>

                <div class="card-footer text-center">
                    <a href="login.php">Or Log in</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php' ?>

</body>
</html>