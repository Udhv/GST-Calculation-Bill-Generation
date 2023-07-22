<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        body {
            text-align: center;
            background-image: url("img3.jpg"); /* Set the background image URL */
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

        .form-container {
            background-color: #eeeeee;
            width: 300px;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 0px;
        }

        .form-container legend {
            background-color: gray;
            color: white;
            padding: 5px 10px;
        }

        .form-container input {
            margin: 5px;
        }

        .form-container .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 7.5px 20px;
            text-align: center;
            color: black;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .form-container .button:hover {
            background-color: #45a049;
        }

        .decoration-image {
            width: 75px;
            height: 75px;
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="form-container">
            <form method="POST" action="insert.php">
            <fieldset>
                <legend>
                    <img src="img1_1.png" alt="Decorative Image" class="decoration-image">
                </legend>
                <legend>Sign Up</legend>
                    <input type="text" name="name" placeholder="Name" required><br>
                    <input type="email" name="email" placeholder="Email" required><br>
                    <input type="password" name="password" placeholder="Password" required><br>
                    <input type="text" name="panno" placeholder="Pan NO :" required><br>
                    <input type="submit" value="Sign Up" name="submit" class="button">
                
            </fieldset>
            </form>
        </div>
    </div>
</body>
</html>
