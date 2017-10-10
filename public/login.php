<?php
session_start();
if (isset($_POST['email'])) {
    include 'partials/datalogin.php';

    $stmt = $conn->prepare('SELECT id, email, First_Name, Last_Name, password FROM users WHERE email=?');
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $stmt->bind_result($id, $email, $fname, $lname, $pass);
    $stmt->fetch();

    $stmt->close();

    $conn->close();

    if (password_verify($_POST['password'], $pass)) {
        //set session data for later use;
        $_SESSION['id'] = $id;
        $_SESSION['fname'] = $fname;
        $_SESSION['lname'] = $lname;
        $_SESSION['email'] = $email;

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