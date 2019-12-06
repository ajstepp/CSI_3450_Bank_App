<?php
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username == 'user' && $password == 'secret')
    {
        session_start();
        $_SESSION['login'] = $username;
        $goto = "Location: bank_manager.php";  //This is our landing page
    } else {
    $ref = getenv("HTTP_REFERER");
    $goto = "Location: " . $ref;
    }
    header($goto);
?>