<?php
    session_start();
    $servername = "localhost";
    $sqlusername = "root";
    $sqlpassword = "";
    $dbname = "STORE";
    $conn = mysqli_connect($servername, $sqlusername, $sqlpassword, $dbname);
    $customerID = $_SESSION['customerID'];
    $cartTotal = $_SESSION['cartTotal'];
    $cartID = $_SESSION['cartID'];

    if($_POST) {
        $custName = $_POST['fullName'];
        $shipAddress = $_POST['shipAddress'];
        $emailAddress = $_POST['emailAddress'];
        $creditCardNo = $_POST['creditCardNo'];
        $CVV = $_POST['CVV'];
        $expiryDate = $_POST['expiryDate'];
        $sql1 = "INSERT INTO TRANSACTIONS(Price, Customer_name, Shipping_address, Email_address, Credit_card, CVV, Expiry_date)
                    VALUES('$cartTotal', '$custName', '$shipAddress', '$emailAddress', '$creditCardNo', '$CVV', '$expiryDate')";
        mysqli_query($conn, $sql1);

        $transactionID = mysqli_insert_id($conn);
        $sql2 = "INSERT INTO CART_TRANSACTION(Cart_ID, Transaction_ID)
                    VALUES ('$cartID', '$transactionID')";
        mysqli_query($conn, $sql2);

        $sql3 = "UPDATE CART
                    SET Paid_for = TRUE
                    WHERE Cart_ID = '$cartID'";
        mysqli_query($conn, $sql3);

        unset($_SESSION['cartID']);
        unset($_SESSION['cartTotal']);

        echo "<script>
                    alert('Successfully checked out.');
                    window.location.href = 'home.php';
                </script>";
        
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PrintAsia | Check Out</title>
        <link rel="stylesheet" href="/project/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>
    <body class="checkout">
        <div class="title-container">
            <h1 class="store-title">PrintAsia</h1>
        </div>
        <div class="links">
            <div class="link">
                <a href="home.php">Home</a>
            </div>
            <div class="link">
                <a href="catalog.php">Catalog</a>
            </div>
            <div class="link">
                <a href="cart.php">Cart</a>
            </div>
            <div class="link">
                <a href="myorders.php">My Orders</a>
            </div>
        </div>
        <h1>Check Out</h1>
        <div class="check-out-grid">
            <div class="check-out-info">
                <h1>Customer Info</h1>
                <form method="post" action="checkout.php">
                    Full Name: <br>
                    <input type="text" name="fullName" required><br><br>
                    Shipping Address: <br>
                    <input type="text" name="shipAddress" required><br><br>
                    Email Address: <br>
                    <input type="text" name="emailAddress" required><br><br>
                    Credit Card Number: <br>
                    <input type="text" name="creditCardNo" required><br><br>
                    CVV: <br>
                    <input type="text" name="CVV" required><br><br>
                    Expiry Date: <br>
                    <input type="text" name="expiryDate" required><br><br>
                    <button type="submit" class="button">Submit Order</button> 
                </form> 
            </div>
            <div class="check-out-items">
                <h1>Items</h1>
                <table class="check-out-items-table">
                    <tr>
                        <th>Name</th>
                        <th>Artist</th>
                        <th>Origin</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                <?php
                    $sql2 = "SELECT * FROM PRODUCT_IN WHERE Cart_ID = '$cartID'";
                    $result2 = mysqli_query($conn, $sql2);
                    if(mysqli_num_rows($result2)>0) {
                        while($row = mysqli_fetch_array($result2)) {
                            $productID = $row['Product_ID'];
                            $sql3 = "SELECT * FROM PRODUCT WHERE Product_ID = '$productID'";
                            $products = mysqli_query($conn, $sql3); 
                            if(mysqli_num_rows($products) > 0) {
                                while($product = mysqli_fetch_array($products)) {
                                    ?> 
                                    <tr>
                                        <td><h3><?php echo $product["Name"]; ?></h3></td>
                                        <td><?php echo $product["Artist"]; ?></td>
                                        <td><?php echo $product["Country"]; ?></td>
                                        <td>$<?php echo $row["Price"]; ?></td>
                                        <td><?php echo $row["Quantity"]; ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }                    
                    }
                ?>
                </table>
                <h3><?php echo "Total: $" . number_format($cartTotal, 2); ?></h3>
            </div>
        </div>    
        <div class="contact-info-container">
            <p class="contact-info-text">Phone: +1(201)-284-1234<br>Email: customerservice@printasia.com<br>
            © 2025 PrintAsia Inc. All rights reserved.</p>
        </div>
    </body>
</html>