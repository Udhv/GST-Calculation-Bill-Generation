<?php
                $conn = mysqli_connect("localhost", "root", "", "project");
                if (!$conn) {
                    die("Connect failed: " . mysqli_connect_error());
                } else {
                    $email = $name = $password = $panno = "";

                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        if (isset($_POST["email"])) $email = $_POST["email"];
                        if (isset($_POST["name"])) $name = $_POST["name"];
                        if (isset($_POST["password"])) $password = $_POST["password"];
                        if (isset($_POST["panno"])) $panno = $_POST["panno"];

                        mysqli_select_db($conn, "project");

                        // Sanitize the input values
                        $email = mysqli_real_escape_string($conn, $email);
                        $name = mysqli_real_escape_string($conn, $name);
                        $password = mysqli_real_escape_string($conn, $password);
                        $panno = mysqli_real_escape_string($conn, $panno);

                        $input = "INSERT INTO account (email, name, password, panno) VALUES ('$email', '$name', '$password', '$panno')";
                        if (mysqli_query($conn, $input)) {
                            echo '<body><div class="container"> <div class="message-box"> <div class="message">Account is Created.';
                            echo '<br><a href="index.php" class="button">Login </a></div></div> </div></body>';
                        } 
                        else{
                            echo '<body><div class="container"> <div class="message-box"> <div class="message">Error ';
                            echo '<br><a href="signup.php" class="button">Sign up</a></div></div> </div></body>';
                        }

                        mysqli_close($conn);
                    }
                }
                ?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
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

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
</body>
</html>
