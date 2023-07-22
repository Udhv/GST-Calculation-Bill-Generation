<!DOCTYPE html>
<html>
<head>
  <title></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    
    h2 {
      color: #333;
      margin-bottom: 10px;
    }
    
    label {
      display: inline-block;
      width: 120px;
      margin-bottom: 5px;
    }
    
    input[type="text"],
    input[type="number"] {
      width: 200px;
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }
    
    input[type="submit"] {
      padding: 8px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    
    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
    }
    
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    
    th {
      background-color: #4CAF50;
      color: white;
    }
    
    p {
      margin: 5px 0;
    }

    ul.menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            background-color: #333;
            text-align: left;
        }

        ul.menu li {
            display: inline-block;
        }

        ul.menu li a {
            display: block;
            color: #fff;
            text-align: center;
            padding: 16px 50px;
            text-decoration: none;
        }

        ul.menu li a:hover {
            background-color: #111;
        }



  </style>
</head>
<body>
<ul class="menu">
        <li><a href="menu.php">Home</a></li>
        <li><a href="gst_calculation.php">GST Calculation</a></li>
        <li><a href="bill_generation.php">Bill Generation</a></li>
        <li><a href="history.php">History</a></li>
</ul>
<?php
// Establish the database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if email is available in the cookie
if (isset($_COOKIE['email'])) {
    $email = $_COOKIE['email'];

    // Prepare and execute the subquery to retrieve PAN number based on email from the 'account' table
    $stmt = $conn->prepare("SELECT panno FROM account WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    // Check if any results are found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $panno = $row['panno'];

        // Use the retrieved PAN number to display history from the 'bills' table
        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM bills WHERE panno = ?");
        $stmt->bind_param("s", $panno);
        $stmt->execute();

        $result = $stmt->get_result();

        // Check if any results are found
        if ($result->num_rows > 0) {
            echo "<h1>Bill Information:</h1>";
            echo '<table>';
            echo '<tr><th>Purchase Date</th><th>Pan No.</th><th>Item Name</th><th>Item Quantity</th><th>Item Price</th><th>GST Rate</th><th>GST Amount</th><th>Amount</th></tr>';
    
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo "<td>Date: " . $row['date'] . "</td>";
                echo "<td>PAN Number: " . $row['panno'] . "</td>";
                echo "<td>Item Name: " . $row['item_name'] . "</td>";
                echo "<td>Item Quantity: " . $row['item_quantity'] . "</td>";
                echo "<td>Item Price rupees: " . $row['item_price'] . "</td>";
                echo "<td>GST Rate rupees: " . $row['gst_rate'] . "%</td>";
                echo "<td>GST Amount rupees: " . $row['gst_amount'] . "</td>";
                echo "<td>Total Amount rupess: " . ($row['item_price'] + $row['gst_amount']) . "</td>";
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo "No results found for PAN Number: " . $panno;
        }

        $stmt->close();
    } else {
        echo "No PAN Number found for the provided email: " . $email;
    }
} else {
    echo "No email found in the cookie.";
}

$conn->close();
?>
</body>
</html>
