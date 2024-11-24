<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'sipngrind');

// Fetch the "About Us" data from the database
$aboutQuery = "SELECT * FROM about_us WHERE id = 1"; // Assuming there's only one entry for "About Us"
$aboutResult = $conn->query($aboutQuery);
$aboutData = $aboutResult ? $aboutResult->fetch_assoc() : [];
$aboutText = $aboutData['about_text'] ?? 'Default about us text.';
$imageUrl = $aboutData['image_url'] ?? './images/default_image.jpg'; // Use default if no image found

// Fetch team members from the database (excluding deleted ones)
$query = "SELECT * FROM team_members WHERE is_deleted = 0";
$result = $conn->query($query);

// Check if the query was successful and return data
if ($result) {
    $teamMembers = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
} else {
    // If query fails, return an empty array and log the error
    error_log("Error with query: " . $conn->error);
    $teamMembers = [];
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Our Team Section</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet"/>
    <!-- Stylesheet -->
    <link rel="stylesheet" href="aboutus.css" />
    <script src="aboutus.js"></script>
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
                    <li><a href="index.php" class="links">Home</a></li>
                        <li><a href="menu.php" class="links">Menu</a></li>
                        <li><a href="#" class="links">Merchandises</a></li>
                        <li><a href="#" class="links">Delivery</a></li>
                        <li><a href="aboutus.php" class="links" active>About Us</a></li>
                        <li><a href="login.php" class="links">Login</a></li>
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

<section class="about-us">
  <div class="about-us-content">
      <h2>About Us</h2>
      <!-- Display the About Us text from the database -->
      <p><?php echo nl2br(htmlspecialchars($aboutText)); ?></p>
      <a href="#" class="learn-more">Discover Our Story</a>
  </div>
  <div class="about-us-image">
      <!-- Display the About Us image from the database -->
      <img src="<?php echo $imageUrl; ?>" alt="Coffee Story" />
  </div>
</section>


<?php
// Fetch team members from the database (excluding deleted ones)
$conn = new mysqli('localhost', 'root', '', 'sipngrind');
$query = "SELECT * FROM team_members WHERE is_deleted = 0";
$result = $conn->query($query);

// Loop through the results and display each team member
$teamMembers = $result && $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<section>
    <div class="row">
        <h1>Our Team</h1>
    </div>
    <?php 
    $membersPerRow = 3; // Number of team members per row
    $count = 0; // Counter to track team members
    ?>
    <div class="row centered">
    <?php foreach ($teamMembers as $member): ?>
        <?php if ($count > 0 && $count % $membersPerRow === 0): ?>
            </div>
            <div class="row centered">
        <?php endif; ?>
        <div class="column">
            <div class="card">
                <div class="img-container">
                    <img src="<?php echo $member['image_url']; ?>" alt="<?php echo htmlspecialchars($member['name']); ?>" />
                </div>
                <h3><?php echo htmlspecialchars($member['name']); ?></h3>
                <p><?php echo htmlspecialchars($member['description']); ?></p>
                <div class="icons">
                    <a href="<?php echo $member['twitter_link']; ?>"><i class="fab fa-twitter"></i></a>
                    <a href="<?php echo $member['facebook_link']; ?>"><i class="fab fa-facebook"></i></a>
                    <a href="<?php echo $member['instagram_link']; ?>"><i class="fab fa-instagram"></i></a>
                    <a href="mailto:<?php echo $member['email_link']; ?>"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </div>
        <?php $count++; ?>
    <?php endforeach; ?>
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