<?php
require_once 'init/init.php';
//check if they're logged in, if not send them back to login page.
if (!Session::exists('user')) {
    header("Location: login.php");
}

$user = new User();

if (isset($_POST['token'])) {
    if (Token::check($_POST['token'])) {
        $address = new Address();

        $id = $address->getID($_POST['street'], $_POST['city'], $_POST['state']);

        if (!is_null($id)) {
            $user->addAddress($id);
        } else {
            $invalid = "This address is either incomplete or invalid, please try again.";
        }
    }
}

$addresses = $user->addresses();

?>

<!DOCTYPE html>
<html lang="en">
<?php include 'partials/header.php' ?>

<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dash.php">
            <?php
            echo "Weclome " . Session::get('user')->first_name . " " . Session::get('user')->last_name . "!";
            ?>
        </a>
        <a class="pull-right text-white" href="logout.php">Logout</a>
    </div>
</nav>

<div class="container">
    <div class="card address-form-card">
        <div class="card-header">Validate Address</div>
        <div class="card-body">
            <form class="form-inline" method="post">


                        <label class="sr-only" for="street">Street</label>
                        <input class="form-control mb-2 mr-2" type="text" name="street" placeholder="Street" required>


                        <label class="sr-only" for="city">City</label>
                        <input class="form-control mb-2 mr-2" type="text" name="city" placeholder="City" required>


                        <label class="sr-only" for="state">State</label>
                        <input class="form-control mb-2 mr-2" type="text" name="state" placeholder="State" required>

                         <input type="hidden" name="token" value="<?php echo Token::generate()?>">

                        <input class="btn btn-primary mb-2" type="submit" value="Validate">

            </form>
            <?php
            if (isset($invalid)) {
                echo '<div class="alert-danger" role="alert">'.$invalid.'</div>';
            }

            ?>

        </div>
    </div>

    <div class="card address-form-card">
        <div class="card-header">Validated Addresses</div>
        <div class="card-body">
            <ul class="list-group">
                <?php
                foreach ($addresses as $address) {
                    echo '<li class="list-group-item">';
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