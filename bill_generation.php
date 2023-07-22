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

if (isset($_POST['submit'])) {
    $panno = $_POST['panno'];
    $itemNames = $_POST['item_name'];
    $itemQuantities = $_POST['item_quantity'];
    $itemPrices = $_POST['item_price'];
    $gst_rate = 30; // Default GST rate of 30%

    // Validate input
    if (count($itemNames) !== count($itemQuantities) || count($itemNames) !== count($itemPrices)) {
        echo "Error: Invalid input.";
        exit;
    }

    // Calculate GST amount for each item
    $gst_amounts = [];
    foreach ($itemPrices as $price) {
        $gst_amounts[] = ($price * $gst_rate) / 100;
    }

    // Insert the bill information into the database
    $sql = "INSERT INTO bills (date, panno, item_name, item_quantity, item_price, gst_rate, gst_amount)
            VALUES (CURDATE(), ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Error: " . $conn->error;
        exit;
    }

    // Bind parameters and execute the statement for each item
    $stmt->bind_param("ssiddi", $panno, $itemName, $itemQuantity, $itemPrice, $gst_rate, $gstAmount);

    for ($i = 0; $i < count($itemNames); $i++) {
        $itemName = $itemNames[$i];
        $itemQuantity = $itemQuantities[$i];
        $itemPrice = $itemPrices[$i];
        $gstAmount = $gst_amounts[$i];

        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            exit;
        }
    }

    // Close the statement
    $stmt->close();

    // Generate HTML
    echo '<h1>Bill Information:</h1>';
    $totalAmount = 0;
    echo '<p>PAN Number: ' . $panno . '</p>';
    echo '<table>';
    echo '<tr><th>Item Name</th><th>Item Quantity</th><th>Item Price</th><th>GST Rate</th><th>GST Amount</th><th>Amount</th></tr>';
    for ($i = 0; $i < count($itemNames); $i++) {
        echo '<tr>';
        echo '<td>' . $itemNames[$i] . '</td>';
        echo '<td>' . $itemQuantities[$i] . '</td>';
        echo '<td>$' . $itemPrices[$i] . '</td>';
        echo '<td>' . $gst_rate . '%</td>';
        echo '<td>$' . $gst_amounts[$i] . '</td>';
        $amount = $gst_amounts[$i] + $itemPrices[$i];
        echo '<td>$' . $amount . '</td>';
        echo '</tr>';
        $totalAmount += $amount;
    }
    echo '</table>';
    echo '<p>Total Amount: $' . $totalAmount . '</p>';

    $conn->close();

    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>GST Calculation</title>
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
      width: 190px;
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
    </ul><br>

<form method="post" action="" enctype="multipart/form-data" id="bill_form">
    <label for="panno">PAN Number:</label>
    <input type="text" name="panno" id="panno" required>

    <h2>Items:</h2>

    <div id="items_container">
        <div class="item">
            <label>Item Name:</label>
            <input type="text" name="item_name[]" required>

            <label>Item Quantity:</label>
            <input type="number" name="item_quantity[]" required>

            <label>Item Price:</label>
            <input type="number" step="0.01" name="item_price[]" required>
        </div>
    </div>

    <button type="button" onclick="addItem()">Add Item</button>

    <input type="submit" name="submit" value="Generate Bill">
</form>

<script>
    function addItem() {
        var container = document.getElementById("items_container");
        var itemDiv = document.createElement("div");
        itemDiv.classList.add("item");

        var itemNameLabel = document.createElement("label");
        itemNameLabel.textContent = "Item Name:";
        itemDiv.appendChild(itemNameLabel);

        var itemNameInput = document.createElement("input");
        itemNameInput.type = "text";
        itemNameInput.name = "item_name[]";
        itemNameInput.required = true;
        itemDiv.appendChild(itemNameInput);

        var itemQuantityLabel = document.createElement("label");
        itemQuantityLabel.textContent = "Item Quantity:";
        itemDiv.appendChild(itemQuantityLabel);

        var itemQuantityInput = document.createElement("input");
        itemQuantityInput.type = "number";
        itemQuantityInput.name = "item_quantity[]";
        itemQuantityInput.required = true;
        itemDiv.appendChild(itemQuantityInput);

        var itemPriceLabel = document.createElement("label");
        itemPriceLabel.textContent = "Item Price:";
        itemDiv.appendChild(itemPriceLabel);

        var itemPriceInput = document.createElement("input");
        itemPriceInput.type = "number";
        itemPriceInput.step = "0.01";
        itemPriceInput.name = "item_price[]";
        itemPriceInput.required = true;
        itemDiv.appendChild(itemPriceInput);

        container.appendChild(itemDiv);
    }
</script>
</body>
</html>
