<?php
require_once 'init/init.php';
//check if they're logged in, if not send them back to login page.
if (!Session::exists('id')) {
    header("Location: login.php");
}

//get all the addresses validated by this user
include 'partials/datalogin.php';

//cache them

//set session flag so I know i already cached the addresses.


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
                    echo "Weclome ".$_SESSION['fname']." ".$_SESSION['lname']."!";
                ?>
            </a>
            <a class="pull-right" href="logout.php">Logout</a>
        </div>

    </div>
</nav>

<div class="mx-auto">
    <div class="card text-center">
        <div class="card-header">

        </div>
        <div class="card-body">
            <form>

            </form>
        </div>
    </div>
</div>

<?php include 'partials/footer.php' ?>

</body>
</html>