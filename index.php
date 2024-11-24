<?php
// Database connection details
$host = "localhost";
$user = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$database = "sipngrind"; // Replace with your database name

// Create connection
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT m.name AS new_name, m.description AS new_description, m.image AS new_image, i.price AS new_price 
          FROM menu_items m
          JOIN item_sizes i ON m.item_id = i.item_id
          WHERE m.is_newest_drink = 1 AND i.size = 'Small' LIMIT 1";

$result_new = $conn->query($query);

$newName = "No newest drink available";
$newDescription = "Please update the database.";
$newImage = "default_image.jpg";
$newPrice = "0";

if ($result_new && $result_new->num_rows > 0) {
    $row = $result_new->fetch_assoc();
    $newName = $row['new_name'];
    $newDescription = $row['new_description'];
    $newImage = $row['new_image'] ? $row['new_image'] : 'default_image.jpg';
    $newPrice = $row['new_price'];
}

$query_popular = "SELECT m.name AS popular_name, m.description AS popular_description, m.image AS popular_image, i.price AS popular_price
        FROM menu_items m
        JOIN item_sizes i ON m.item_id = i.item_id
        WHERE m.is_popular = 1 AND i.size = 'Small' LIMIT 3";

$result_popular = $conn->query($query_popular);

$popularName = "No popular drink available";
$popularDescription = "No description available";
$popularImage = "default_image.jpg";
$popularPrice = "0";

$popularDrinks = array();

if ($result_popular && $result_popular->num_rows > 0) {
    while($row = $result_popular->fetch_assoc()){
        $popularDrinks[] = array(
            'name' => $row['popular_name'],
            'description' => $row['popular_description'],
            'image' => !empty($row['popular_image']) ? $row['popular_image'] : 'default_image.jpg',
            'price' => !empty($row['popular_price']) ? $row['popular_price'] : '0'
        );
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Website</title>
    <link rel="stylesheet" href="SnG-main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="sng.js"></script>
    <script src="https://kit.fontawesome.com/e6356ea24f.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="navbar">
        <div class="nav">
            <div class="logo-hamburger">
                <div class="logo">
                    <img src="./images/Sip__n_grind_logo.png" alt="SnG Logo">
                </div>
                <button class="hamburger" id="hamburger-btn">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>
            </div>
            <div class="navbar-items">
                <div class="text-menu">
                    <ul class="list">
                        <li><a href="#" class="links">Home</a></li>
                        <li><a href="#" class="links">Menu</a></li>
                        <li><a href="#" class="links">Merchandises</a></li>
                        <li><a href="#" class="links">Delivery</a></li>
                        <li><a href="#" class="links">About Us</a></li>
                    </ul>
                </div>
                <div class="navbar-right">
                    <div class="search-icon-container">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <div>
                        <div class="location-icon">
                            <img src="./images/locationicon.svg" alt="">
                        </div>
                    </div>
                </div>
                <div class="search-bar">
                    <div class="outer-search">
                        <div class="search">
                            <div class="search-icon">
                                <img src="./images/searchicon.png" alt="Search">
                            </div>
                            <div class="search-text">
                                <input type="text" name="search" id="" placeholder="Search">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="reader">
        <div class="rectangle-2">
            <div class="text-area">
                <div class="text-area-2">
                    <h2>Where every GRIND</h2>
                    <h1>leads to a perfect SIP</h1>
                    <p class="line">“The world begins to change through the eyes of a cup of coffee.”—Donna Favors</p>
                    <div class="price-button">
                        <div class="price">Order Now!</div>
                        <a href="#" class="brew-button">
                            <p class="brew">Brew</p>
                        </a>
                        
                    </div>
                </div>
            </div>
            <div class="image-area">
                <div class="image-1">
                    <img class="img-2" src="./images/drinkingcoffee.avif" alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="reader-2">
        <div class="reader-2-image">
            <img src="<?php echo $newImage; ?>" alt="Product Image">
        </div>
        <div class="reader-2-text">
            <div class="reader-2-text-area">
                <h1>Try Our Newest Drink!</h1>
                <h2><?php echo $newName; ?></h2>
                <p class="line">"<?php echo $newDescription; ?>"</p>
                <div class="reader-2-text-price-button">
                    <div class="price">Starts at P<?php echo number_format($newPrice, 2); ?></div>
                    <div class="brew-button">
                        <p class="brew">Brew</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr>

    <section class="reader-3">
        <div class="heading">
            <h1>Popular</h1>
            <p>Try our Best-Seller Drinks
                while grindin</p>
        </div>
        <div class="menu">
            <?php if (!empty($popularDrinks)): ?>
                <?php foreach ($popularDrinks as $index => $popular): ?>
                    <div class="menu-<?php echo $index + 1; ?>">
                        <div class="inner-menu-<?php echo $index + 1; ?>">
                            <img src="<?php echo $popular['image']; ?>" alt="">
                            <div class="menu-desc">
                                <h1><?php echo $popular['name']; ?></h1>
                                <p class="line-2"><?php echo $popular['description']; ?></p>
                            </div>
                            <div class="menu-button">
                                <div class="price">P<?php echo number_format($popular['price'], 2); ?></div>
                                <div class="brew-button">
                                    <p class="brew">Brew</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No popular drinks available.</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="reader-4">
        <div class="reader-4-rectangle">
            <div class="reader-4-text-area">
                <h3>Order now and Grind!</h3>
                <p class="reader-4-line">We provide a wide variety of beverages freshly grinded and pastries 
                from the oven that will guarantee motivation for your daily grind.
                </p>
                <div class="reader-4-button">
                    <p class="learn">Order</p>
                </div>
            </div>
            <div class="reader-4-image-area">
                <img src="./images/ordercoffee.png" alt="">
            </div>
        </div>
    </section>

    <section class="section-reader-5">
        <div class="section-reader-5-heading">
            <h1>Gifts and Merchandises</h1>
            <p class="section-reader-5-line">Try our reusable tumblers, straws, and order a membership card!</p>
        </div>
        <div class="section-reader-5-rectangle section-reader-5-rectangle-1">
            <div class="image-area">
                <img src="./images/membershipcard.webp" alt="Membership Card">
            </div>
            <div class="text-area">
                <h2>Membership Card</h2>
                <p class="section-reader-5-line">Buy our membership card and get discounts, freebies, and vouchers!</p>
                <div class="button">
                    <p class="pick">Buy</p>
                </div>
            </div>
        </div>
        <div class="section-reader-5-rectangle section-reader-5-rectangle-2">
            <div class="text-area">
                <h2>Merchandises</h2>
                <p class="section-reader-5-line">Save our environment and buy reusable products to avoid the use of plastics in your order!</p>
                <div class="button">
                    <p class="pick">Shop</p>
                </div>
            </div>
            <div class="image-area">
                <img src="./images/merch.webp" alt="Merchandise">
            </div>
        </div>
    </section>
    

    <section class="reader-6">
        <div class="reader-6-rectangle">
            <div class="image-area">
                <img src="images/aboutus.jpeg" alt="">
            </div>
            <div class="text-area">
                <h3>About us</h3>
                <p class="reader-6-line">
                At Sip N Grind, we craft experiences, turning every sip into an adventure. From the aroma of freshly ground beans to the warmth of a perfect brew, we bring coffee closer to you. Our space fosters connection and creativity, celebrating flavor, passion, and community.
                </p>
                <div class="button">
                    <p class="learn">Discover</p>
                </div>
            </div>
        </div>
    </section>
    
    

    <section class="reader-7">
        <div class="reader-7-rectangle">
            <div class="text-area">
                <h3>Free Delivery</h3>
                <p class="reader-7-line">Enjoy free delivery within 5km radius </p>
                <div class="button">
                    <p class="learn">Shop</p>
                </div>
                <p class="delivery-charge">*P25 delivery charge per extra 2km </p>
            </div>
            <div class="image-area">
                <img src="./images/deliveryicon-removebg-preview.png" alt="">
            </div>
        </div>
    </section>


    <footer>
        <div class="foot">
            <div class="about" id="about-dropdown">
                <span>About</span>
                <div class="about-content foot-content" id="about-dropdown-menu">
                    <a href="#">Our Coffee</a>
                    <a href="#">Our Company</a>
                    <a href="#">Service</a>
                </div>
            </div>
            <div class="order" id="order-dropdown">
                <span>Order & Pickup</span>
                <div class="order-content foot-content" id="order-dropdown-menu">
                    <a href="#">Order on the Web</a>
                    <a href="#">Delivery</a>
                    <a href="#">Return Policy</a>
                    <a href="#">Bulk Order</a>
                </div>
            </div>
            <div class="location" id="location-dropdown">
                <span>Location</span>
                <div class="location-content foot-content" id="location-dropdown-menu">
                    <a href="#">Quezon City</a>
                    <a href="#">Rizal</a>
                    <a href="#">Metro Manila</a>
                    <a href="#">Marikina City</a>
                </div>
            </div>
            <div class="social" id="social-dropdown">
                <span>Social Impact</span>
                <div class="social-content foot-content" id="social-dropdown-menu">
                    <a href="#">People</a>
                    <a href="#">Planet</a>
                    <a href="#">Environment</a>
                </div>
            </div>
            <div class="language">
                <span>Language</span>
                <div class="language-picker">
                    <select name="language" id="language">
                        <option value="english">English</option>
                        <option value="coming-soon" disabled>Coming Soon</option>
                    </select>
                </div>
            </div>
        </div>
    </footer>
    
</body>

</html>