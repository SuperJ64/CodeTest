<?php
session_start();
//check if they're logged in, if not send them back to login page.
if(!isset($_SESSION['id'])) {
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include 'partials/header.php' ?>

<body>
<div class="mx-auto">
    <div class="card text-center">
        <div class="card-header">
            <a href="logout.php">Logout</a>
        </div>
        <div class="card-body">
            <form>

            </form>
        </div>
        <div class="card-footer text-muted">
            Or Register new account
        </div>
    </div>
</div>

<?php include 'partials/footer.php' ?>

</body>
</html>