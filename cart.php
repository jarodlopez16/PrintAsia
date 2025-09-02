<?php
    session_start();
    $servername = "localhost";
    $sqlusername = "root";
    $sqlpassword = "";
    $dbname = "STORE";
    $conn = mysqli_connect($servername, $sqlusername, $sqlpassword, $dbname);
    $total = 0;
    $customerID = $_SESSION['customerID'];
    if (empty($_SESSION['cartID'])) {
        $sql2 = "INSERT INTO CART(Total_items, Price, Paid_For)
                        VALUES (0, 0, FALSE)";
        mysqli_query($conn, $sql2);
        $cartID = mysqli_insert_id($conn);
        $_SESSION['cartID'] = $cartID;
        $sql3 = "INSERT INTO CUSTOMER_CART(Cart_ID, Customer_ID)
                    VALUES ('$cartID', '$customerID')";
        mysqli_query($conn, $sql3);
    } else {
        $cartID = $_SESSION['cartID'];
    }

    $sql1 = "SELECT Cart_ID, Price, Paid_for FROM CART
                WHERE Cart_ID = '$cartID'";
    $result1 = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($result1) == 1) {
        $row = mysqli_fetch_array($result1);
        if ($row["Paid_for"] == FALSE) {
            $total = $row['Price'];
            $_SESSION['cartTotal'] = $total;
        }
    }

    if ($_POST) {
        $prodID = $_POST["product_id"];
        $sql2 = "SELECT Quantity, Price FROM PRODUCT_IN
                    WHERE Product_ID = '$prodID' AND Cart_ID = '$cartID'";
        $result2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result2) == 1) {
            $row2 = mysqli_fetch_array($result2);
            $quantity = $row2["Quantity"];
            $price = $row2["Price"];

            $sql3 = "DELETE FROM PRODUCT_IN
                    WHERE Product_ID = $prodID AND Cart_ID = $cartID";
            mysqli_query($conn, $sql3);

            $sql4 = "UPDATE CART
                        SET Total_items = Total_items - $quantity,
                        Price = Price - $price
                        WHERE Cart_ID = '$cartID'";
            mysqli_query($conn, $sql4);

            $sql5 = "UPDATE PRODUCT
                        SET Quantity = Quantity + $quantity
                        WHERE Product_ID = '$prodID'";
            mysqli_query($conn, $sql5);
        }
        $sql6 = "SELECT Price FROM CART 
                    WHERE Cart_ID = '$cartID'";
        $result3 = mysqli_query($conn, $sql6);
        if (mysqli_num_rows($result3) == 1) {
            $row = mysqli_fetch_array($result3);
            $total = $row['Price'];
            $_SESSION['cartTotal'] = $total;
        }
        
    }                
        
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PrintAsia | Cart</title>
        <link rel="stylesheet" href="/project/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>
    <body class="cart">
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
        <h2>Shopping Cart</h2>
        <div class="shopping-cart">
            <table class="cart-table">
                <tr>
                    <th colspan="2">Product</th>
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
                                    <td>
                                        <div class="print-divider">
                                            <div class="image-background">
                                                <img src="<?php echo $product["Image_URL"]; ?>">
                                            </div>
                                        </div>
                                    </td>
                                    <td><h3><?php echo $product["Name"]; ?></h3> by <?php echo $product["Artist"]; ?><br><?php echo $product["Country"]; ?><br><br>
                                        <form action="cart.php" method="post">
                                            <input type="hidden" name="product_id" value="<?php echo $product["Product_ID"] ?>">
                                            <button type="submit" class="button">Remove From Cart</button> 
                                        </form>
                                    </td>
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
            <h2><?php echo "Total: $" . number_format($total, 2); ?></h2>
            <form action="checkout.php" method="post">
                <button type="submit" class="button">Check Out</button> 
            </form>           
        </div>
        <div class="contact-info-container">
            <p class="contact-info-text">Phone: +1(201)-284-1234<br>Email: customerservice@printasia.com<br>
            © 2025 PrintAsia Inc. All rights reserved.</p>
        </div>
    </body>
</html>