<?php
if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $conn = mysqli_connect("localhost", "root", "", "project");
    if (!$conn) {
        die("Connect failed: " . mysqli_connect_error());
    } else {
        mysqli_select_db($conn, "project");

        $query = "SELECT email FROM account WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 1) {
            
            setcookie('email', $email, time() + (86400 * 30), "/"); // Cookie lasts for 30 days


            // Redirect to the user profile page
            echo '<body><div class="container"> <div class="message-box"> <div class="message">'."|| Welcome ||";
            echo '<br><a href="menu.php" class="button">Home </a></div></div> </div></body>';
        } else {
            echo '<body><div class="container"> <div class="message-box"> <div class="message">'."Account doesn't exist!";
            echo '<br><a href="signup.php" class="button">Sign up </a></div></div> </div></body>';
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            background-image: url("img3.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .message-box {
            background-color: #eeeeee;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .message {
            font-size: 18px;
            margin-top: 10px;
        }

        .button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

           
