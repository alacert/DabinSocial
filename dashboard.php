<?php

include_once "php/init.php";

if($_SESSION['signed_in'] == 0)
{
    header('Location: index.php');
    die();
}

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit']))
{
    $_SESSION['signed_in'] = 0;
    session_start();
    header('Location: index.php');
    die();
}

if(isset($_GET["error"]))
{
    echo htmlspecialchars($_GET["error"], ENT_QUOTES, "UTF-8");
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>

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
                <h1 class="display-3">Dashboard</h1>
                <p class="lead">
                    Welcome, <?php echo htmlspecialchars($_SESSION["username"], ENT_QUOTES, "UTF-8"); ?>
                    <form method="post" class="form-inline" autocomplete="off">
                        <button name="submit" type="submit" class="btn btn-default submit-btn">Logout</button>
                    </form>
                </p>
            </div>
            <a href="index.php" class="btn btn-secondary btn-lg btn-block active" role="button" aria-pressed="true">Home</a>
            <form name="createpost" action="createpost.php" method="get" autocomplete="off" onsubmit="return validateForm()">
                <label for="post_content">New Post:</label>
                <textarea name="post_content" class="form-control" rows="5" id="post_content" required></textarea>
                <button name="create" type="create" class="btn btn-default submit-btn">Create</button>
            </form>

            <p>
                <?php
                $result = $conn->query("SELECT * FROM posts ORDER BY post_id DESC", MYSQLI_USE_RESULT);
                while($row = $result->fetch_assoc())
                {
                    $content = $row["content"];
                    $creator_id = $row["creator_id"];
                    $username = "";
                    
                    /*$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
                    $stmt->bind_param("s", $creator_id);
                    $result2 = $stmt->get_result();

                    while($row2 = $result2->fetch_assoc())
                    {
                        $username = $row2["username"];
                    }*/
                    echo htmlspecialchars($creator_id, ENT_QUOTES, "UTF-8") . "<br/>" . $content . "<br/>";
                }
                ?>
            </p>
        </div>

        <footer>
            Copyright &copy; <?php echo date('Y') ?> DabinSocial
        </footer>
    </body>
</html>

<script>

function validateForm()
{
    var x = document.forms["createpost"]["post_content"].value;
    if(x == "")
    {
        alert("You must enter some post content!");
        return false;
    }
}

</script>