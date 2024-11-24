<?php
$conn = new mysqli('localhost', 'root', '', 'sipngrind');

try {
  $pdo = new PDO('mysql:host=localhost;dbname=sipngrind', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

// Query to get menu items with their sizes
$query = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
        FROM menu_items m
        JOIN item_sizes i ON m.item_id = i.item_id
        WHERE m.category_id = 1"; // Filter for Brewed Coffee category

$stmt = $pdo->query($query);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Page</title>
    <link rel="stylesheet" href="menu.css">
    <script src="menu.js"></script>
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
                        <li><a href="menu.php" class="links active">Menu</a></li>
                        <li><a href="#" class="links">Merchandises</a></li>
                        <li><a href="#" class="links">Delivery</a></li>
                        <li><a href="aboutus.php" class="links">About Us</a></li>
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
<div class="mainbodycontent">
    
    <h1>In-store Menu</h1>

    <a href="orderpage.html">
        <button class="order-now-btn">Order Now</button>
    </a>
    <h2>Brewed Coffee</h2>
    <div class="menu-container">
        <?php
        // Loop through the items and display them dynamically
        $current_item_id = null;
        $current_item_name = "";
        $current_item_description = "";
        $current_item_image = "";
        $sizes = [];

        foreach ($items as $item) {
            // If the item_id changes, output the previous item and reset
            if ($current_item_id != $item['item_id']) {
                if ($current_item_id !== null) {
                    // Display the previous item
                    echo "<div class='menu-item'>";
                    echo "<div class='item-name'>$current_item_name</div>";

                    // Debugging the image path output
                    $image_path =  $current_item_image;
                    echo "<img src='$image_path' alt='$current_item_name'>";

                    echo "<div class='item-description'>$current_item_description";
                    foreach ($sizes as $size) {
                        echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
                    }
                    echo "</div>";
                    echo "</div>";
                }

                // Reset for the new item
                $current_item_id = $item['item_id'];
                $current_item_name = $item['name'];
                $current_item_description = $item['description'];
                $current_item_image = $item['image'];
                $sizes = [];
            }

            // Add the size and price to the array
            $sizes[] = ['size' => $item['size'], 'price' => $item['price']];
        }

        // Output the last item
        if ($current_item_id !== null) {
            echo "<div class='menu-item'>";
            echo "<div class='item-name'>$current_item_name</div>";

            // Debugging the image path output
            $image_path =  $current_item_image;
            echo "<img src='$image_path' alt='$current_item_name'>";

            echo "<div class='item-description'>$current_item_description";
            foreach ($sizes as $size) {
                echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
            }
            echo "</div>";
            echo "</div>";
        }
        ?>
        </div>

        <h2>Frappes</h2>
<div class="menu-container">
    <?php
    // Query to get items for Frappes (Category 2)
    $query_frappes = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 2"; // Filter for Frappes category

    $stmt_frappes = $pdo->query($query_frappes);
    $frappes = $stmt_frappes->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the Frappes items and display them dynamically
    $current_item_id = null;
    $current_item_name = "";
    $current_item_description = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($frappes as $item) {
        // If the item_id changes, output the previous item and reset
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item'>";
                echo "<div class='item-name'>$current_item_name</div>";

                // Display the image
                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='$current_item_name'>";

                echo "<div class='item-description'>$current_item_description";
                foreach ($sizes as $size) {
                    echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
            $current_item_description = $item['description'];
            $current_item_image = $item['image'];
            $sizes = [];
        }

        // Add the size and price to the array
        $sizes[] = ['size' => $item['size'], 'price' => $item['price']];
    }

    // Output the last item
    if ($current_item_id !== null) {
        echo "<div class='menu-item'>";
        echo "<div class='item-name'>$current_item_name</div>";

        // Display the image
        $image_path =  $current_item_image;
        echo "<img src='$image_path' alt='$current_item_name'>";

        echo "<div class='item-description'>$current_item_description";
        foreach ($sizes as $size) {
            echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>
    
<h2>Espresso</h2>
<div class="menu-container">
    <?php
    // Query to get items for Frappes (Category 2)
    $query_frappes = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 3"; // Filter for Frappes category

    $stmt_frappes = $pdo->query($query_frappes);
    $frappes = $stmt_frappes->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the Frappes items and display them dynamically
    $current_item_id = null;
    $current_item_name = "";
    $current_item_description = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($frappes as $item) {
        // If the item_id changes, output the previous item and reset
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item'>";
                echo "<div class='item-name'>$current_item_name</div>";

                // Display the image
                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='$current_item_name'>";

                echo "<div class='item-description'>$current_item_description";
                foreach ($sizes as $size) {
                    echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
            $current_item_description = $item['description'];
            $current_item_image = $item['image'];
            $sizes = [];
        }

        // Add the size and price to the array
        $sizes[] = ['size' => $item['size'], 'price' => $item['price']];
    }

    // Output the last item
    if ($current_item_id !== null) {
        echo "<div class='menu-item'>";
        echo "<div class='item-name'>$current_item_name</div>";

        // Display the image
        $image_path =  $current_item_image;
        echo "<img src='$image_path' alt='$current_item_name'>";

        echo "<div class='item-description'>$current_item_description";
        foreach ($sizes as $size) {
            echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<h2>Blended Beverages</h2>
<div class="menu-container">
    <?php
    // Query to get items for Frappes (Category 2)
    $query_frappes = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 4"; // Filter for Frappes category

    $stmt_frappes = $pdo->query($query_frappes);
    $frappes = $stmt_frappes->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the Frappes items and display them dynamically
    $current_item_id = null;
    $current_item_name = "";
    $current_item_description = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($frappes as $item) {
        // If the item_id changes, output the previous item and reset
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item'>";
                echo "<div class='item-name'>$current_item_name</div>";

                // Display the image
                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='$current_item_name'>";

                echo "<div class='item-description'>$current_item_description";
                foreach ($sizes as $size) {
                    echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
            $current_item_description = $item['description'];
            $current_item_image = $item['image'];
            $sizes = [];
        }

        // Add the size and price to the array
        $sizes[] = ['size' => $item['size'], 'price' => $item['price']];
    }

    // Output the last item
    if ($current_item_id !== null) {
        echo "<div class='menu-item'>";
        echo "<div class='item-name'>$current_item_name</div>";

        // Display the image
        $image_path =  $current_item_image;
        echo "<img src='$image_path' alt='$current_item_name'>";

        echo "<div class='item-description'>$current_item_description";
        foreach ($sizes as $size) {
            echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<h2>Chocolate Beverages</h2>
<div class="menu-container">
    <?php
    // Query to get items for Frappes (Category 2)
    $query_frappes = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 5"; // Filter for Frappes category

    $stmt_frappes = $pdo->query($query_frappes);
    $frappes = $stmt_frappes->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the Frappes items and display them dynamically
    $current_item_id = null;
    $current_item_name = "";
    $current_item_description = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($frappes as $item) {
        // If the item_id changes, output the previous item and reset
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item'>";
                echo "<div class='item-name'>$current_item_name</div>";

                // Display the image
                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='$current_item_name'>";

                echo "<div class='item-description'>$current_item_description";
                foreach ($sizes as $size) {
                    echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
            $current_item_description = $item['description'];
            $current_item_image = $item['image'];
            $sizes = [];
        }

        // Add the size and price to the array
        $sizes[] = ['size' => $item['size'], 'price' => $item['price']];
    }

    // Output the last item
    if ($current_item_id !== null) {
        echo "<div class='menu-item'>";
        echo "<div class='item-name'>$current_item_name</div>";

        // Display the image
        $image_path =  $current_item_image;
        echo "<img src='$image_path' alt='$current_item_name'>";

        echo "<div class='item-description'>$current_item_description";
        foreach ($sizes as $size) {
            echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<h2>Seasonal Beverages</h2>
<div class="menu-container">
    <?php
    // Query to get items for Frappes (Category 2)
    $query_frappes = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 6"; // Filter for Frappes category

    $stmt_frappes = $pdo->query($query_frappes);
    $frappes = $stmt_frappes->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the Frappes items and display them dynamically
    $current_item_id = null;
    $current_item_name = "";
    $current_item_description = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($frappes as $item) {
        // If the item_id changes, output the previous item and reset
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item'>";
                echo "<div class='item-name'>$current_item_name</div>";

                // Display the image
                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='$current_item_name'>";

                echo "<div class='item-description'>$current_item_description";
                foreach ($sizes as $size) {
                    echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
            $current_item_description = $item['description'];
            $current_item_image = $item['image'];
            $sizes = [];
        }

        // Add the size and price to the array
        $sizes[] = ['size' => $item['size'], 'price' => $item['price']];
    }

    // Output the last item
    if ($current_item_id !== null) {
        echo "<div class='menu-item'>";
        echo "<div class='item-name'>$current_item_name</div>";

        // Display the image
        $image_path =  $current_item_image;
        echo "<img src='$image_path' alt='$current_item_name'>";

        echo "<div class='item-description'>$current_item_description";
        foreach ($sizes as $size) {
            echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<h2>Tea Beverages</h2>
<div class="menu-container">
    <?php
    // Query to get items for Frappes (Category 2)
    $query_frappes = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 7"; // Filter for Frappes category

    $stmt_frappes = $pdo->query($query_frappes);
    $frappes = $stmt_frappes->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the Frappes items and display them dynamically
    $current_item_id = null;
    $current_item_name = "";
    $current_item_description = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($frappes as $item) {
        // If the item_id changes, output the previous item and reset
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item'>";
                echo "<div class='item-name'>$current_item_name</div>";

                // Display the image
                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='$current_item_name'>";

                echo "<div class='item-description'>$current_item_description";
                foreach ($sizes as $size) {
                    echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
            $current_item_description = $item['description'];
            $current_item_image = $item['image'];
            $sizes = [];
        }

        // Add the size and price to the array
        $sizes[] = ['size' => $item['size'], 'price' => $item['price']];
    }

    // Output the last item
    if ($current_item_id !== null) {
        echo "<div class='menu-item'>";
        echo "<div class='item-name'>$current_item_name</div>";

        // Display the image
        $image_path =  $current_item_image;
        echo "<img src='$image_path' alt='$current_item_name'>";

        echo "<div class='item-description'>$current_item_description";
        foreach ($sizes as $size) {
            echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<h2>Pastries</h2>
<div class="menu-container">
    <?php
    // Query to get items for Frappes (Category 2)
    $query_frappes = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 8"; // Filter for Frappes category

    $stmt_frappes = $pdo->query($query_frappes);
    $frappes = $stmt_frappes->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the Frappes items and display them dynamically
    $current_item_id = null;
    $current_item_name = "";
    $current_item_description = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($frappes as $item) {
        // If the item_id changes, output the previous item and reset
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item'>";
                echo "<div class='item-name'>$current_item_name</div>";

                // Display the image
                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='$current_item_name'>";

                echo "<div class='item-description'>$current_item_description";
                foreach ($sizes as $size) {
                    echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
            $current_item_description = $item['description'];
            $current_item_image = $item['image'];
            $sizes = [];
        }

        // Add the size and price to the array
        $sizes[] = ['size' => $item['size'], 'price' => $item['price']];
    }

    // Output the last item
    if ($current_item_id !== null) {
        echo "<div class='menu-item'>";
        echo "<div class='item-name'>$current_item_name</div>";

        // Display the image
        $image_path =  $current_item_image;
        echo "<img src='$image_path' alt='$current_item_name'>";

        echo "<div class='item-description'>$current_item_description";
        foreach ($sizes as $size) {
            echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<h2>Tumblers</h2>
<div class="menu-container">
    <?php
    // Query to get items for Frappes (Category 2)
    $query_frappes = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 9"; // Filter for Frappes category

    $stmt_frappes = $pdo->query($query_frappes);
    $frappes = $stmt_frappes->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the Frappes items and display them dynamically
    $current_item_id = null;
    $current_item_name = "";
    $current_item_description = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($frappes as $item) {
        // If the item_id changes, output the previous item and reset
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item'>";
                echo "<div class='item-name'>$current_item_name</div>";

                // Display the image
                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='$current_item_name'>";

                echo "<div class='item-description'>$current_item_description";
                foreach ($sizes as $size) {
                    echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
            $current_item_description = $item['description'];
            $current_item_image = $item['image'];
            $sizes = [];
        }

        // Add the size and price to the array
        $sizes[] = ['size' => $item['size'], 'price' => $item['price']];
    }

    // Output the last item
    if ($current_item_id !== null) {
        echo "<div class='menu-item'>";
        echo "<div class='item-name'>$current_item_name</div>";

        // Display the image
        $image_path =  $current_item_image;
        echo "<img src='$image_path' alt='$current_item_name'>";

        echo "<div class='item-description'>$current_item_description";
        foreach ($sizes as $size) {
            echo "<br>{$size['size']} (₱" . number_format($size['price'], 2) . ")";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<a href="orderpage.html">
        <button class="order-now-btn">Order Now</button>
    </a>
    <footer>
        <div class="foot">
            <div class="about">
                <span>About</span>
                <a href="#">Our Coffee</a>
                <a href="#">Our Company</a>
                <a href="#">Service</a>
            </div>
            <div class="order">
                <span>Order & Pickup</span>
                <a href="#">Order on the Web</a>
                <a href="#">Delivery</a>
                <a href="#">Return Policy</a>
                <a href="#">Bulk Order</a>
            </div>
            <div class="location">
                <span>Location</span>
                <a href="#">Quezon City</a>
                <a href="#">Rizal</a>
                <a href="#">Metro Manila</a>
                <a href="#">Marikina City</a>
            </div>
            <div class="social">
                <span>Social Impact</span>
                <a href="#">People</a>
                <a href="#">Planet</a>
                <a href="#">Environment</a>
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
        </div>
    </footer>
</body>
</html>

