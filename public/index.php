<?php
require_once 'init/init.php';

    if (isset($_POST['fname'])) {

        $user = new User();
        $found = $user->find($_POST['email']);

        if ($found) {
            $emailErr = "This email is already being used";
        } else {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];

            //encrypt password
            $pass = password_hash($password, PASSWORD_BCRYPT);

            $user->create([$email, $pass, $fname, $lname]);
            $user->login($email, $password);

            header("Location: dash.php");

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
            Register New Account
        </div>
        <div class="card-body">
            <form method="post">

                <label for="fname">First Name</label>
                <input type="text" name="fname" required>

                <label for="lname">Last Name</label>
                <input type="text" name="lname" required>

                <label for="email">Email</label>
                <input type="email" name="email" required>
                <?php
                    if (isset($emailErr)) {
                        echo '<span class="error">'.$emailErr.'</span>';
                    }

                ?>

                <label for="password">Password</label>
                <input type="password" name="password" required>

                <input type="submit" value="Register">

            </form>
        </div>
        <div class="card-footer text-muted">
            <a href="login.php">Or Log in</a>
        </div>
    </div>
</div>

<?php include 'partials/footer.php' ?>

</body>
</html>