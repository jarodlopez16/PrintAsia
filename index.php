<?php
    session_start();

    $servername = "localhost";
    $sqlusername = "root";
    $sqlpassword = "";
    $dbname = "STORE";
    $conn2 = mysqli_connect($servername, $sqlusername, $sqlpassword, $dbname);

    $sql2 = "CREATE TABLE IF NOT EXISTS CUSTOMER(
        Customer_ID INT(6) UNSIGNED AUTO_INCREMENT,
        Username VARCHAR(20) NOT NULL,
        Fname VARCHAR(20) NOT NULL,
        Lname VARCHAR(20) NOT NULL,
        Email_address VARCHAR(50) NOT NULL,
        Password VARCHAR(25) NOT NULL,
        UNIQUE(Username),
        PRIMARY KEY (Customer_ID))";
    mysqli_query($conn2, $sql2);

    $sql3 = "CREATE TABLE IF NOT EXISTS PRODUCT(
        Product_ID INT(6) UNSIGNED AUTO_INCREMENT,
        Name VARCHAR(50) UNIQUE NOT NULL,
        Artist VARCHAR(50) NOT NULL,
        Country VARCHAR(20) NOT NULL,
        Years VARCHAR(25) NOT NULL,
        Price FLOAT NOT NULL,
        Image_URL VARCHAR(60) NOT NULL,
        Quantity INT NOT NULL,
        PRIMARY KEY (Product_ID))";
    mysqli_query($conn2, $sql3);

    $sql4 = "CREATE TABLE IF NOT EXISTS CART(
        Cart_ID INT(6) UNSIGNED AUTO_INCREMENT,
        Total_items INT NOT NULL,
        Price FLOAT NOT NULL,
        Paid_for BOOLEAN NOT NULL,
        PRIMARY KEY (Cart_ID))";    
    mysqli_query($conn2, $sql4);

    $sql5 = "CREATE TABLE IF NOT EXISTS CUSTOMER_CART(
        Cart_ID INT(6) UNSIGNED,
        Customer_ID INT(6) UNSIGNED NOT NULL,
        PRIMARY KEY (Cart_ID, Customer_ID),
        FOREIGN KEY (Cart_ID) REFERENCES CART(Cart_ID),
        FOREIGN KEY (Customer_ID) REFERENCES CUSTOMER(Customer_ID))";
    mysqli_query($conn2, $sql5);

    $sql6 = "CREATE TABLE IF NOT EXISTS PRODUCT_IN(
        Cart_ID INT(6) UNSIGNED NOT NULL,
        Product_ID INT(6) UNSIGNED NOT NULL,
        Quantity INT NOT NULL,
        Price FLOAT NOT NULL,
        PRIMARY KEY (Cart_ID, Product_ID),
        FOREIGN KEY (Cart_ID) REFERENCES CART(Cart_ID),
        FOREIGN KEY (Product_ID) REFERENCES PRODUCT(Product_ID))";
    mysqli_query($conn2, $sql6);

    $sql7 = "CREATE TABLE IF NOT EXISTS TRANSACTIONS(
        Transaction_ID INT(6) UNSIGNED AUTO_INCREMENT,
        Price FLOAT NOT NULL,
        Customer_name VARCHAR(35) NOT NULL,
        Shipping_address VARCHAR(100) NOT NULL,
        Email_address VARCHAR(50) NOT NULL,
        Credit_card CHAR(16) NOT NULL,
        CVV VARCHAR(4) NOT NULL,
        Expiry_date CHAR(7) NOT NULL,
        PRIMARY KEY (Transaction_ID))";
    mysqli_query($conn2, $sql7);

    $sql8 = "CREATE TABLE IF NOT EXISTS CART_TRANSACTION(
        Cart_ID INT(6) UNSIGNED,
        Transaction_ID INT(6) UNSIGNED NOT NULL,
        PRIMARY KEY (Cart_ID, Transaction_ID),
        FOREIGN KEY (Cart_ID) REFERENCES CART(Cart_ID),
        FOREIGN KEY (Transaction_ID) REFERENCES TRANSACTIONS(Transaction_ID))";
    mysqli_query($conn2, $sql8);

    mysqli_close($conn2);

    $error = "";

    if (!isset($_POST['username']) && !isset($_POST['password'])) {
        session_destroy();
    }  

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $dbname = "4630481_store";
        $conn = mysqli_connect($servername, $sqlusername, $sqlpassword, $dbname);

        $sql = "SELECT * FROM CUSTOMER
                WHERE Username = '$username' AND Password = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $_SESSION['loggedin'] = true;
            $_SESSION['customerID'] = $row['Customer_ID'];
            header("Location: home.php");
            exit();
        } else {
            $error = "Username or password is incorrect";
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>PrintAsia | Login</title>
        <link rel="stylesheet" href="/project/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>
    <body class="index">
        <div class="title-container">
            <h1 class="store-title">PrintAsia</h1>
        </div>
        <div class="login-box">
            <h1>Log In</h1>
            <form method="post" action="index.php">
                Username: <br>
                <input type="text" name="username" required><br><br>
                Password: <br>
                <input type="password" name="password" required><br><br>
                <input type="submit" value="Login" class="button"><br><br>
                <p id="unsuccessful"><strong><?php echo "$error" ?></strong></p>
            </form>
            <form method="post" action="register.php">
                <button type="submit" class="button">Create an Account</button> 
            </form>
        </div>
        <div class="contact-info-container">
            <p class="contact-info-text">Phone: +1(201)-284-1234<br>Email: customerservice@printasia.com<br>
            © 2025 PrintAsia Inc. All rights reserved.</p>
        </div>
    </body>
</html>