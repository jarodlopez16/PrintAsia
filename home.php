<?php
    session_start();
    if(!isset($_SESSION['loggedin'])||$_SESSION['loggedin']==false){
        header("location:index.php");
    }

    $servername = "localhost";
    $sqlusername = "root";
    $sqlpassword = "";
    $dbname = "STORE";

    $conn = mysqli_connect($servername, $sqlusername, $sqlpassword, $dbname);

    $sql1 = "INSERT IGNORE INTO PRODUCT (Name, Artist, Country, Years, Price, Image_URL, Quantity)
            VALUES ('Two eagles', 'Bada Shanren', 'China', '1702', 10.00, 'Two Eagles.jpeg', 10),
                    ('Tiger Family', 'Unknown', 'Korea', 'Late 18th Century', 10.00, 'Tiger Family.jpeg', 10), 
                    ('Fishing by Torchlight in Kai Province', 'Hokusai', 'Japan', '1832 - 1834', 10.00, 'Fishing by Torchlight in Kai Province.jpeg', 10),
                    ('Marina', 'Félix Resurrección Hidalgo', 'Philippines', '1855-1913', 10.00, 'Marina.jpeg', 10),
                    ('Vietnamese Ladies', 'Nguyen Gia Tri', 'Vietnam', '1909 - 1993', 10.00, 'Vietnamese Ladies.jpeg', 10),
                    ('Flowers and Insects', 'Ma Quan', 'China', '1752', 10.0, 'Flowers and Insects.webp', 10),
                    ('Fruit pickers under the Mango Tree', 'Fernando Amorsolo', 'Philippines', '1892 - 1972', 10.00, 'Fruit pickers under the Mango Tree.jpeg', 10),
                    ('Painting of Flowers and Birds', 'Unknown', 'Korea', 'Unknown', 10.00, 'Painting of Flowers and Birds.webp', 10),
                    ('Two women and a child', 'Tô Ngoc Vân', 'Vietnam', '1994', 10.00, 'Two women and a child.webp', 10),
                    ('Painting of Cats and Sparrows', 'Byeon Sang-byeok', 'Korea', 'Late 17th Century', 10.00, 'Painting of Cats and Sparrows.jpeg', 10),
                    ('Listening Quietly to Soughing Pines', 'Ma Lin', 'China', '13th Century before 1246', 10.00, 'Listening Quietly to Soughing Pines.jpeg', 10),
                    ('A woman ghost appeared from a well', 'Hokusai', 'Japan', '1831', 10.00, 'A woman ghost appeared from a well.jpeg', 10),
                    ('Nhớ một chiều Tây Bắc', 'Phan Kế An', 'Vietnam', '1950', 10.00, 'Nho mot chieu Tay Bac.jpeg', 10),
                    ('Kawaguchi Lake', 'Hiroshi Yoshida', 'Japan', '1926', 10.00, 'Kawaguchi Lake.jpeg', 10),
                    ('Barrio Market', 'Fernando Amorsolo', 'Philippines', '1892 – 1972', 10.00, 'Barrio Market.jpeg', 10)"; 
    mysqli_query($conn, $sql1);

    mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PrintAsia | Home</title>
        <link rel="stylesheet" href="/project/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>
    <body class="home">
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
        <h2>About Us</h2>
        <div class="about-us-text">
            <img src="about-us.jpg">
            <p><i>Planting Rice</i> by Fernando Amorsolo</p>
            <p>Growing up Asian American, our founder learned that one of the most immersive ways to learn about 
                his home continent's history while abroad was through its artwork. Through examination of the different 
                art styles of various Asian cultures, one may identify the different societal values and philosophies that influenced 
                civilizations of the past, some of which are still present in modern day society. PrintAsia was founded as a way to 
                appreciate Asian cultures and educate people of the Asian disapora about their roots. We hope that despite the distances 
                separating us, we can foster a sense of unity among all Asian communities.
            </p>
        </div>
        <div class="contact-info-container">
            <p class="contact-info-text">Phone: +1(201)-284-1234<br>Email: customerservice@printasia.com<br>
            © 2025 PrintAsia Inc. All rights reserved.</p>
        </div>
    </body>
</html>