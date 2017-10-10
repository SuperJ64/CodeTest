<?php
require_once 'init/init.php';

    if (isset($_POST['fname'])) {

        $user = DB::getInstance()->get('SELECT email FROM users WHERE email=?', [$_POST['email']]);

        if ($user->count() > 0) {
            $emailErr = "This email is already being used";
        } else {
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];

            //encrypt password
            $pass = password_hash($pass, PASSWORD_BCRYPT);

            $user = DB::getInstance()->insert('INSERT INTO users (email, password, First_Name, Last_name) VALUES (?,?,?,?)',
                [$email, $pass, $fname, $lname]);


            //set session data for later use;
            $_SESSION['id'] = $user->id();
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['email'] = $email;

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