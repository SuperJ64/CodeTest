<?php
require_once 'init/init.php';

if (isset($_POST['email'])) {

    $user = DB::getInstance()->get('SELECT id, email, first_name, last_name, password FROM users WHERE email=?', [$_POST['email']])->first();
    $pass = $user->password;

    if (password_verify($_POST['password'], $pass)) {

        //set session data for later use;
        Session::put('id', $user->id);
        Session::put('fname', $user->first_name);
        Session::put('lname', $user->last_name);
        Session::put('email', $user->email);

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