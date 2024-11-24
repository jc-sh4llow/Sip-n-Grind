<?php 

$conn = new mysqli('localhost', 'root', '', 'sipngrind');

try {
  $pdo = new PDO('mysql:host=localhost;dbname=sipngrind', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$query = "SELECT m.name AS odname, m.image AS odimage,
          MAX(CASE WHEN i.size = 'Small' THEN i.price END) as small_price,
          MAX(CASE WHEN i.size = 'Medium' THEN i.price END) as medium_price,
          MAX(CASE WHEN i.size = 'Large' THEN i.price END) as large_price
          FROM menu_items m
          JOIN item_sizes i ON m.item_id = i.item_id
          GROUP BY  m.item_id";
$result_od = $conn->query($query);

$odName = "No product available.";
$odImage = "default_image.jpg";
$odPriceSmall = "0";
$odPriceMedium = "0";
$odPriceLarge = "0";

if ($result_od && $result_od->num_rows > 0){
  $row = $result_od->fetch_assoc();
  $odName = $row['odname'];
  $odImage = $row['odimage'] ? $row['odimage'] : 'default_image.jpg';
  $odPriceSmall = $row['small_price'];
  $odPriceMedium = $row['medium_price'];
  $odPriceLarge = $row['large_price'];
}
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Page</title>
  <link rel="stylesheet" href="orderpage.css">
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <div class="nav">
        <div class="logo-hamburger">
            <div class="logo">
                <img src="./Images/Sip__n_grind_logo.png" alt="SnG Logo">
            </div>
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
                <div class="navbar-right">
                    <div class="search-bar">
                        <div class="outer-search">
                            <div class="search">
                                <div class="search-icon">
                                    <img src="./images/searchicon.png" alt="Search">
                                </div>
                                <div class="search-text">
                                    <input type="text" name="search" id="" placeholder="Search">
                                </div>
                                <div class="location-icon">
                                    <img src="./images/locationicon.svg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  <!-- Main Content -->
  <div class="main-container">
    <!-- Menu Section -->
    <div class="menu">
      <h1 class="header">Our Menu</h1>
      <div class="menu-grid">
        <!-- Products -->
        <div class="menu-item" data-name="<?php echo $odName; ?>" data-small-price="<?php echo $odPriceSmall; ?>"
          data-medium-price="<?php echo $odPriceMedium; ?>"
          data-large-price="<?php echo $odPriceLarge; ?>"
          data-price="<?php echo $odPriceSmall; ?>">
          <img src="<?php echo $odImage; ?>" alt="Product Image">
          <h3><?php echo $odName; ?></h3>
          <select id="size-selector">
              <option value="small" selected>Small</option>
              <option value="medium">Medium</option>
              <option value="large">Large</option>
          </select>
          <p>₱<span id="price"><?php echo number_format($odPriceSmall, 2); ?></span></p>
          <button class="add-to-cart">Add to Basket</button>
        </div>
        <div class="menu-item" data-name="Apple Chia Black Tea" data-price="120">
          <img src="./Images/banana_bread.png" alt="Apple Chia Black Tea">
          <h3>Apple Chia Black Tea</h3>
          <p>₱120</p>
          <button class="add-to-cart">Add to Basket</button>
        </div>
        <div class="menu-item" data-name="Bacon Pesto Pasta" data-price="200">
          <img src="./Images/coffeesplash.png" alt="Bacon Pesto Pasta">
          <h3>Bacon Pesto Pasta</h3>
          <p>₱200</p>
          <button class="add-to-cart">Add to Basket</button>
        </div>
        <div class="menu-item" data-name="Ice Caramel Latte" data-price="180">
          <img src="./Images/icedame.png" alt="Ice Caramel Latte">
          <h3>Ice Caramel Latte</h3>
          <p>₱180</p>
          <button class="add-to-cart">Add to Basket</button>
        </div>
        <div class="menu-item" data-name="Americano" data-price="180">
            <img src="./Images/icedame.png" alt="Americano">
            <h3>Americano</h3>
            <p>₱180</p>
            <button class="add-to-cart">Add to Basket</button>
          </div>
          <div class="menu-item" data-name="Vanilla Frappe" data-price="180">
            <img src="./Images/icedame.png" alt="Vanilla Frappe">
            <h3>Vanilla Frappe</h3>
            <p>₱180</p>
            <button class="add-to-cart">Add to Basket</button>
          </div>
      </div>
    </div>

    <!-- Basket Section -->
    <div class="basket">
      <h1 class="header">Your Basket</h1>
      <div id="basket-items" class="basket-items-container">Your basket is empty.</div>
      <div class="total">
        <p>Total: <strong>₱<span id="total-price">0</span></strong></p>
      </div>
      <button id="checkout">Checkout</button>
    </div>
  </div>

  <script src="orderpage.js"></script>
</body>
</html>
