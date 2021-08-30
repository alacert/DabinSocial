<?php

include_once "php/init.php";

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome to DabinSocial</title>

        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <div class="main">
            <div class="jumbotron">
                <h1 class="display-3">Welcome to DabinSocial!</h1>
                <p class="lead">Please either:</p>
            </div>
            <a href="login.php" class="btn btn-secondary btn-lg btn-block active" role="button" aria-pressed="true">Login</a>
            <a href="register.php" class="btn btn-secondary btn-lg btn-block active" role="button" aria-pressed="true">Register</a>
        </div>

        <footer>
            Copyright &copy; <?php echo date('Y') ?> DabinSocial
        </footer>
    </body>
</html>