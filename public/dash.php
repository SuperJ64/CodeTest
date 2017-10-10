<?php
require_once 'init/init.php';
//check if they're logged in, if not send them back to login page.
if (!Session::exists('user')) {
    header("Location: login.php");
}

if (isset($_POST['street'])) {
    $address = new Address();

    $id = $address->getID($_POST['street'], $_POST['city'], $_POST['state']);
    echo $id;
}

//cache them
$cache = Cache::getInstance();



?>

<!DOCTYPE html>
<html lang="en">
<?php include 'partials/header.php' ?>

<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <a class="navbar-brand" href="dash.php">
                <?php
                    echo "Weclome ".Session::get('user')->first_name." ".Session::get('user')->last_name."!";
                ?>
            </a>
            <a class="pull-right" href="logout.php">Logout</a>
        </div>

    </div>
</nav>

<div class="mx-auto">
    <div class="card text-center">
        <div class="card-header">Validated Address</div>
            <form method="post">

                <label for="street">Street</label>
                <input type="text" name="street" required>

                <label for="city">City</label>
                <input type="text" name="city" required>

                <label for="state">State</label>
                <input type="text" name="state" required>

                <input type="submit" value="Validate">
            </form>
        <div class="card-body">
        </div>
    </div>
</div>

<?php include 'partials/footer.php' ?>

</body>
</html>