<?php

include_once "php/init.php";

if($_SESSION["signed_in"] == 0)
{
    header("Location: index.php");
    die();
}

if(isset($_GET["post_content"]))
{
    $content = htmlspecialchars($_GET["post_content"], ENT_QUOTES, "UTF-8");

    if($content == "")
    {
        header("Location: dashboard.php?error=You must input a value!");
        die();
    }

    $stmt = $conn->prepare("INSERT INTO posts (creator_id, content, time_created)
                            VALUES (?, ?, NOW())");

    if($stmt)
    {
        $stmt->bind_param('ss', $_SESSION["user_id"], $content);
        $stmt->execute();
    }
    else
    {
        header("Location: dashboard.php?error=Error creating your account");
        die();
    }

    header("Location: dashboard.php");
}
else
{
    header("Location: dashboard.php?error=You must input a value!");
}

?>