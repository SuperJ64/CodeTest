<?php
require_once 'init/init.php';
//check if they're logged in, if not send them back to login page.
if (!Session::exists('user')) {
    header("Location: login.php");
}

$user = new User();

if (isset($_POST['street'])) {
    $address = new Address();

    $id = $address->getID($_POST['street'], $_POST['city'], $_POST['state']);

    if (!is_null($id)) {
        $user->addAddress($id);
    }
}

$addresses = $user->addresses();

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
                echo "Weclome " . Session::get('user')->first_name . " " . Session::get('user')->last_name . "!";
                ?>
            </a>
            <a class="pull-right" href="logout.php">Logout</a>
        </div>

    </div>
</nav>

<div class="mx-auto">
    <div class="card text-center">
        <div class="card-header">Validate Address</div>
        <div class="card-body">
            <form method="post">

                <label for="street">Street</label>
                <input type="text" name="street" required>

                <label for="city">City</label>
                <input type="text" name="city" required>

                <label for="state">State</label>
                <input type="text" name="state" required>

                <input type="submit" value="Validate">
            </form>

        </div>
    </div>

    <div class="card text-center">
        <div class="card-header">Validated Addresses</div>
        <div class="card-body">
            <ul>
                <?php
                foreach ($addresses as $address) {
                    echo '<li>';
                    echo $address->street.", ".$address->city.", ".$address->state;
                    echo '</li>';
                }

                ?>
            </ul>
        </div>
    </div>
</div>

<?php include 'partials/footer.php' ?>

</body>
</html>