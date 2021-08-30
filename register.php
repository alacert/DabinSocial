<?php
include_once "php/init.php";

if($_SESSION["signed_in"] == 1)
{
    header('Location: dashboard.php');
    die();
}

if(isset($_POST['email']) && isset($_POST['pwd']) && isset($_POST['username']))
{
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $username = $_POST['username'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if($stmt)
    {
        $stmt->bind_param('s', $email);

        $stmt->execute();

        $result = $stmt->get_result();

        if(!$result)
        {
            echo "Error creating your account, account with that email already exists";
        }
        else
        {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            if($stmt)
            {
                $stmt->bind_param('s', $username);

                $stmt->execute();

                $result = $stmt->get_result();

                if(!$result)
                {
                    echo "Error creating your account, account with that username already exists";
                }
                else
                {
                    $stmt = $conn->prepare("INSERT INTO users (email, username, password)
                                            VALUES (?, ?, ?)");
                    if($stmt)
                    {
                        

                        $hashedpass = password_hash($pwd, PASSWORD_DEFAULT);
                        $stmt->bind_param('sss', $email, $username, $hashedpass);
                        $stmt->execute();

                        echo "Success creating your account!";
                    }
                    else
                    {
                        echo "Error creating account!";
                    }
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Register to DabinSocial</title>

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
                <h1 class="display-3">Register</h1>
            </div>
            <a href="index.php" class="btn btn-secondary btn-lg btn-block active" role="button" aria-pressed="true">Home</a>

            <form method="post" autocomplete="off">
                <div class="form-group form-inline">
                <label for="email">Email address:</label>
                    <input type="email" name="email" class="form-control" id="email" autocomplete="off" required>
                    <label for="username">Username:</label>
                    <input type="username" name="username" class="form-control" id="username" autocomplete="off" requried>
                    <label for="pwd">Password:</label>
                    <input type="password" name="pwd" class="form-control" id="pwd" autocomplete="off" required>
                </div>
                <!--<div class="checkbox">
                    <label><input type="checkbox"> Remember me</label>
                </div>-->
                <button type="submit" class="btn btn-default submit-btn">Submit</button>
            </form>
            
            <p>Already have an account?</p>
            <a href="login.php" class="btn btn-secondary btn-lg btn-block active" role="button" aria-pressed="true">Login</a>
        </div>

        <footer>
            Copyright &copy; <?php echo date('Y') ?> DabinSocial
        </footer>
    </body>
</html>