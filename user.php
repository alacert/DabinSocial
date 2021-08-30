<?php

include_once "php/init.php";

$is_user_found = false;
$user_id = "";
$user_name = "";

if(isset($_GET["id"]))
{
    global $is_user_found;
    global $user_id;
    global $user_name;

    $user_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    if($stmt)
    {
        $stmt->bind_param('s', $user_id);
        $stmt->execute();

        $result = $stmt->get_result();
        
        if($result->num_rows == 0)
        {
            $is_user_found = false;
        }
        else
        {
            $is_user_found = true;

            while($row = $result->fetch_assoc())
            {
                $user_name = $row['username'];
            }
        }
    }
}
else
{
    header("Location: dashboard.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>User</title>

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
                <h1 class="display-3">User</h1>
                <?php if($is_user_found) : ?>
                    <p class="lead">
                        Viewing User: <?php echo $user_name; ?>
                    </p>
                <?php else : ?>
                    <p class="lead">
                        404 - User not found
                    </p>
                <?php endif; ?>
            </div>
            <a href="index.php" class="btn btn-secondary btn-lg btn-block active" role="button" aria-pressed="true">Home</a>
        </div>

        <footer>
            Copyright &copy; <?php echo date('Y') ?> DabinSocial
        </footer>
    </body>
</html>