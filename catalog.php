<?php
    session_start();
    if (!isset($_SESSION['customerID'])) {
        die("Error: customerID not set in session.");
    }    
    $servername = "localhost";
    $sqlusername = "root";
    $sqlpassword = "";
    $dbname = "STORE";
    $conn = mysqli_connect($servername, $sqlusername, $sqlpassword, $dbname);

    if ($_POST) {
        $customerID = $_SESSION['customerID'];
        $sql1 = "SELECT C.Cart_ID, C.Price FROM CART C
                    JOIN CUSTOMER_CART CC ON CC.Cart_ID = C.Cart_ID
                    WHERE CC.Customer_ID = '$customerID' AND C.Paid_for = FALSE";
        $result1 = mysqli_query($conn, $sql1);
        if(mysqli_num_rows($result1) == 1) {
            $row = mysqli_fetch_array($result1);
            $cartID = $row['Cart_ID'];
            $_SESSION['cartID'] = $cartID;
        } else {
            $sql2 = "INSERT INTO CART(Total_items, Price, Paid_For)
                        VALUES (0, 0, FALSE)";
            mysqli_query($conn, $sql2);
            $cartID = mysqli_insert_id($conn);
            $_SESSION['cartID'] = $cartID;
            $sql3 = "INSERT INTO CUSTOMER_CART(Cart_ID, Customer_ID)
                        VALUES ('$cartID', '$customerID')";
            mysqli_query($conn, $sql3);
        }
            
        $prodID = $_POST["product_id"];
        $quantity = $_POST["quantity"];
        $price = $_POST["price"];
        $total = $quantity * $price;
        $sql4 = "INSERT INTO PRODUCT_IN(Cart_ID, Product_ID, Quantity, Price)
                    VALUES('$cartID', '$prodID', '$quantity', '$total')";
        mysqli_query($conn, $sql4);

        $sql5 = "UPDATE CART
                    SET Total_items = Total_items + $quantity,
                    Price = Price + $total
                    WHERE Cart_ID = '$cartID'";
        mysqli_query($conn, $sql5);

        $sql6 = "UPDATE PRODUCT
                    SET Quantity = Quantity - $quantity
                    WHERE Product_ID = '$prodID'";
        mysqli_query($conn, $sql6);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PrintAsia | Catalog</title>
        <link rel="stylesheet" href="/project/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>
    <body class="catalog">
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
        <h2>Catalog</h2>
        <div class="grid">
            <?php 
                $sql = "SELECT * FROM PRODUCT ORDER BY Product_ID ASC";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result)>0) {
                    while($row = mysqli_fetch_array($result)) { 
                        ?> 
                            <div class="print-divider">
                                <div class="image-background">
                                    <img src="<?php echo $row["Image_URL"]; ?>">
                                </div>
                                <h3><?php echo $row["Name"]; ?></h3>
                                <p>By <?php echo $row["Artist"]; ?></p>
                                <p><?php echo $row["Country"]; ?></p>
                                <p>$<?php echo $row["Price"]; ?></p>
                                <form action="catalog.php" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $row["Product_ID"] ?>">
                                    <input type="hidden" name="price" value="<?php echo $row["Price"] ?>">
                                    Quantity: <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $row["Quantity"] ?>" class="quantity" required>&#9;<button type="submit" class="button">Add to Cart</button> 
                                </form>
                            </div>
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