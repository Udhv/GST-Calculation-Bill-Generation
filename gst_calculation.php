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
        <li><a href="user.php">User</a></li>
    </ul>
    <br>
  <?php
    if(isset($_POST['submit'])){
      $price = ($_POST['itemq']*$_POST['price']);
      $tax_rate = $_POST['tax_rate'];
      
      // Calculate GST amount
      $gst_amount = ($price * $tax_rate) / 100;
      
      // Calculate total price including GST
      $total_price = $price + $gst_amount;
      
      // Display the results
      echo "<h2>GST Calculation</h2>";
      echo "<p>Price: $price</p>";
      echo "<p>Tax Rate: $tax_rate%</p>";
      echo "<p>GST Amount: $gst_amount</p>";
      echo "<p>Total Price (including GST): $total_price</p>";
    }
  ?>
  
  <form method="post" action="">
    <label for="itemName">Item Name </label>
    <input type="text" name="itemname" id="itemname" required><br><br>
    <label for="itemq">Item Quantity </label>
    <input type="text" name="itemq" id="itemq" required><br><br>

    <label for="price">Price:</label>
    <input type="text" name="price" id="price" required><br><br>
    
    <label for="tax_rate">Tax Rate:</label>
    <input type="text" name="tax_rate" id="tax_rate" required><br><br>
    
    <input type="submit" name="submit" value="Calculate">
  </form>
</body>
</html>
