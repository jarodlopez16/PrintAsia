<?php
    session_start();
    $servername = "localhost";
    $sqlusername = "root";
    $sqlpassword = "";
    $dbname = "STORE";
    $conn = mysqli_connect($servername, $sqlusername, $sqlpassword, $dbname);
    $customerID = $_SESSION['customerID'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PrintAsia | My Orders</title>
        <link rel="stylesheet" href="/project/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>
    <body class="myorders">
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
        <h2>My Orders</h2>
        <div class="orders-info">
            <?php
                $sql1 = "SELECT T.Transaction_ID, T.Price, T.Customer_name, T.Shipping_address, T.Email_address FROM TRANSACTIONS T
                            JOIN CART_TRANSACTION CT ON T.Transaction_ID = CT.Transaction_ID
                            JOIN CUSTOMER_CART CC ON CC.Cart_ID = CT.Cart_ID
                            WHERE CC.Customer_ID = '$customerID'";
                $result1 = mysqli_query($conn, $sql1);
                if (mysqli_num_rows($result1) > 0) {
                    while($row = mysqli_fetch_array($result1)) {
                        ?>
                        <h3>Transaction #<?php echo $row["Transaction_ID"]; ?></h3>
                        <p><?php echo "Total: $" . number_format($row["Price"], 2); ?></p>
                        <p>Customer Name: <?php echo $row["Customer_name"]; ?></p>
                        <p>Shipping Address: <?php echo $row["Shipping_address"]; ?></p>
                        <p>Email Address: <?php echo $row["Email_address"]; ?></p>
                        <hr>
                        <?php
                    }
                }    
            ?>             
        </div>
        <div class="contact-info-container">
            <p class="contact-info-text">Phone: +1(201)-284-1234<br>Email: customerservice@printasia.com<br>
            © 2025 PrintAsia Inc. All rights reserved.</p>
        </div>
    </body>
</html>