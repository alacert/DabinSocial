<?php
include_once "php/init.php";

if($_SESSION['signed_in'] == 1)
{
    header('Location: dashboard.php');
    die();
}

function get_values_from_db($result)
{
    while($row = $result->fetch_assoc())
    {
        $password_from_db = $row['password'];
        $username = $row['username'];
        $id = $row['id'];
    }

    $values = array($password_from_db, $username, $id);

    return $values;
}

function login_was_successful($values, $email)
{
    $_SESSION['user_id'] = $values[2];
    $_SESSION['signed_in'] = 1;
    $_SESSION['username'] = $values[1];
    $_SESSION['email'] = $email;

    header("Location: dashboard.php");
    die();
}

function login_was_not_successful()
{
    echo "Incorrect email/password";
}

function stmt_was_valid($stmt, $email, $pwd)
{
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();

    $values = get_values_from_db($result);

    if(password_verify($pwd, $values[0]))
    {
        login_was_successful($values, $email);
    }
    else
    {
        login_was_not_successful();
    }
}

if(isset($_POST['email']) && isset($_POST['pwd']))
{
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");

    if($stmt)
    {
        stmt_was_valid($stmt, $email, $pwd);
    }
    else
    {
        login_was_not_successful();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login to DabinSocial</title>

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
                <h1 class="display-3">Login</h1>
            </div>
            <a href="index.php" class="btn btn-secondary btn-lg btn-block active" role="button" aria-pressed="true">Home</a>

            <form method="post" class="form-inline" autocomplete="off">
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" name="email" class="form-control" id="email" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" name="pwd" class="form-control" id="pwd" autocomplete="off" required>
                </div>
                <!--<div class="checkbox">
                    <label><input type="checkbox"> Remember me</label>
                </div>-->
                <button type="submit" class="btn btn-default submit-btn">Submit</button>
            </form>
            
            <p>Don't have an account?</p>
            <a href="register.php" class="btn btn-secondary btn-lg btn-block active" role="button" aria-pressed="true">Register</a>
        </div>

        <footer>
            Copyright &copy; <?php echo date('Y') ?> DabinSocial
        </footer>
    </body>
</html>