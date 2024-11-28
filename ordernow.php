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
    <title>Order Now</title>
    <link rel="stylesheet" href="ordernow.css">
    <script src="ordernow.js" defer></script>
    <script src="https://kit.fontawesome.com/e6356ea24f.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="navbar">
        <div class="nav">
            <div class="logo-hamburger">
                <a href="index.php" class="logo">
                    <img src="./images/Sip__n_grind_logo.png" alt="SnG Logo">
                </a>
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
                        <li><a href="#" class="links disabled" aria-disabled="true">Merchandises</a></li>
                        <li><a href="#" class="links disabled" aria-disabled="true">Delivery</a></li>
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
    <div class="menu-area">
        
    <h2 id="cat-1">Brewed Coffee</h2>
    <div class="menu-container">
        <?php
        // Loop through the items and display them dynamically
        $current_item_id = null;
        $current_item_name = "";
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
                    echo "<div class='img-container'>";
                    echo "<img src='$image_path' alt='$current_item_name'>";
                    echo "</div>";
                    
                    echo "<div class='item-description'>";
                    echo "<div class='choose-size'>";
                    echo "<span>Choose a size:</span>";
                    echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
                    echo "</div>";
                    foreach ($sizes as $size) {
                        echo "<div class='size-container'>";
                        echo "<br><span class='size-name'>{$size['size']}</span>";
                        echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
                        echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "</div>";
                }

                // Reset for the new item
                $current_item_id = $item['item_id'];
                $current_item_name = $item['name'];
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

            echo "<div class='item-description'>";
                echo "<div class='choose-size'>";
                    echo "<span>Choose a size:</span>";
                    echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
                echo "</div>";
            foreach ($sizes as $size) {
                echo "<div class='size-container'>";
                echo "<br><span class='size-name'>{$size['size']}</span>";
                echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
                echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        }
        ?>
        </div>

        <h2 id="cat-2">Frappes</h2>
<div class="menu-container">
    <?php
    $query_frappes = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 2"; // Filter for Frappes category

    $stmt_frappes = $pdo->query($query_frappes);
    $frappes = $stmt_frappes->fetchAll(PDO::FETCH_ASSOC);

    $current_item_id = null;
    $current_item_name = "";
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

                echo "<div class='item-description'>";
                    echo "<div class='choose-size'>";
                        echo "<span>Choose a size:</span>";
                        echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
                    echo "</div>";
                foreach ($sizes as $size) {
                    echo "<div class='size-container'>";
                    echo "<br><span class='size-name'>{$size['size']}</span>";
                    echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
                    echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
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

        echo "<div class='item-description'>";
        echo "<div class='choose-size'>";
            echo "<span>Choose a size:</span>";
            echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
        echo "</div>";
        foreach ($sizes as $size) {
            echo "<div class='size-container'>";
            echo "<br><span class='size-name'>{$size['size']}</span>";
            echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
            echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>
    
<h2 id="cat-3">Espresso</h2>
<div class="menu-container">
    <?php
    $query_espressos = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 3";

    $stmt_espressos = $pdo->query($query_espressos);
    $espressos = $stmt_espressos->fetchAll(PDO::FETCH_ASSOC);

    $current_item_id = null;
    $current_item_name = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($espressos as $item) {
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item'>";
                echo "<div class='item-name'>$current_item_name</div>";

                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='$current_item_name'>";

                echo "<div class='item-description'>";
                echo "<div class='choose-size'>";
                    echo "<span>Choose a size:</span>";
                    echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
                echo "</div>";
                foreach ($sizes as $size) {
                    echo "<div class='size-container'>";
                    echo "<br><span class='size-name'>{$size['size']}</span>";
                    echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
                    echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            }

            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
            $current_item_image = $item['image'];
            $sizes = [];
        }

        $sizes[] = ['size' => $item['size'], 'price' => $item['price']];
    }

    if ($current_item_id !== null) {
        echo "<div class='menu-item'>";
        echo "<div class='item-name'>$current_item_name</div>";

        $image_path =  $current_item_image;
        echo "<img src='$image_path' alt='$current_item_name'>";

        echo "<div class='item-description'>";
        echo "<div class='choose-size'>";
            echo "<span>Choose a size:</span>";
            echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
        echo "</div>";
        foreach ($sizes as $size) {
            echo "<div class='size-container'>";
            echo "<br><span class='size-name'>{$size['size']}</span>";
            echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
            echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<h2 id="cat-4">Blended Beverages</h2>
<div class="menu-container">
    <?php
    $query_blendeds = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 4";

    $stmt_blendeds = $pdo->query($query_blendeds);
    $blendeds = $stmt_blendeds->fetchAll(PDO::FETCH_ASSOC);

    $current_item_id = null;
    $current_item_name = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($blendeds as $item) {
        // If the item_id changes, output the previous item and reset
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item'>";
                echo "<div class='item-name'>$current_item_name</div>";

                // Display the image
                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='$current_item_name'>";

                echo "<div class='item-description'>";
                echo "<div class='choose-size'>";
                    echo "<span>Choose a size:</span>";
                    echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
                echo "</div>";
                foreach ($sizes as $size) {
                    echo "<div class='size-container'>";
                    echo "<br><span class='size-name'>{$size['size']}</span>";
                    echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
                    echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
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

        echo "<div class='item-description'>";
        echo "<div class='choose-size'>";
            echo "<span>Choose a size:</span>";
            echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
        echo "</div>";
        foreach ($sizes as $size) {
            echo "<div class='size-container'>";
            echo "<br><span class='size-name'>{$size['size']}</span>";
            echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
            echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<h2 id="cat-5">Chocolate Beverages</h2>
<div class="menu-container">
    <?php
    $query_chocos = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 5";

    $stmt_chocos = $pdo->query($query_chocos);
    $chocos = $stmt_chocos->fetchAll(PDO::FETCH_ASSOC);

    $current_item_id = null;
    $current_item_name = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($chocos as $item) {
        // If the item_id changes, output the previous item and reset
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item'>";
                echo "<div class='item-name'>$current_item_name</div>";

                // Display the image
                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='$current_item_name'>";

                echo "<div class='item-description'>";
                echo "<div class='choose-size'>";
                    echo "<span>Choose a size:</span>";
                    echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
                echo "</div>";
                foreach ($sizes as $size) {
                    echo "<div class='size-container'>";
                    echo "<br><span class='size-name'>{$size['size']}</span>";
                    echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
                    echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
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

        echo "<div class='item-description'>";
        echo "<div class='choose-size'>";
            echo "<span>Choose a size:</span>";
            echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
        echo "</div>";
        foreach ($sizes as $size) {
            echo "<div class='size-container'>";
            echo "<br><span class='size-name'>{$size['size']}</span>";
            echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
            echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<h2 id="cat-6">Seasonal Beverages</h2>
<div class="menu-container">
    <?php
    $query_seasonals = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 6";

    $stmt_seasonals = $pdo->query($query_seasonals);
    $seasonals = $stmt_seasonals->fetchAll(PDO::FETCH_ASSOC);

    $current_item_id = null;
    $current_item_name = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($seasonals as $item) {
        // If the item_id changes, output the previous item and reset
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item'>";
                echo "<div class='item-name'>$current_item_name</div>";

                // Display the image
                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='$current_item_name'>";

                echo "<div class='item-description'>";
                echo "<div class='choose-size'>";
                    echo "<span>Choose a size:</span>";
                    echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
                echo "</div>";
                foreach ($sizes as $size) {
                    echo "<div class='size-container'>";
                    echo "<br><span class='size-name'>{$size['size']}</span>";
                    echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
                    echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
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

        echo "<div class='item-description'>";
        echo "<div class='choose-size'>";
            echo "<span>Choose a size:</span>";
            echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
        echo "</div>";
        foreach ($sizes as $size) {
            echo "<div class='size-container'>";
            echo "<br><span class='size-name'>{$size['size']}</span>";
            echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
            echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<h2 id="cat-7">Tea Beverages</h2>
<div class="menu-container">
    <?php
    $query_teas = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 7";

    $stmt_teas = $pdo->query($query_teas);
    $teas = $stmt_teas->fetchAll(PDO::FETCH_ASSOC);

    $current_item_id = null;
    $current_item_name = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($teas as $item) {
        // If the item_id changes, output the previous item and reset
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item'>";
                echo "<div class='item-name'>$current_item_name</div>";

                // Display the image
                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='$current_item_name'>";

                echo "<div class='item-description'>";
                echo "<div class='choose-size'>";
                    echo "<span>Choose a size:</span>";
                    echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
                echo "</div>";
                foreach ($sizes as $size) {
                    echo "<div class='size-container'>";
                    echo "<br><span class='size-name'>{$size['size']}</span>";
                    echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
                    echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
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

        echo "<div class='item-description'>";
        echo "<div class='choose-size'>";
            echo "<span>Choose a size:</span>";
            echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
        echo "</div>";
        foreach ($sizes as $size) {
            echo "<div class='size-container'>";
            echo "<br><span class='size-name'>{$size['size']}</span>";
            echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
            echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<h2 id="cat-8">Pastries</h2>
<div class="menu-container">
    <?php
    $query_pastries = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 8";

    $stmt_pastries = $pdo->query($query_pastries);
    $pastries = $stmt_pastries->fetchAll(PDO::FETCH_ASSOC);

    $current_item_id = null;
    $current_item_name = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($pastries as $item) {
        // If the item_id changes, output the previous item and reset
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item'>";
                echo "<div class='item-name'>$current_item_name</div>";

                // Display the image
                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='$current_item_name'>";

                echo "<div class='item-description'>";
                foreach ($sizes as $size) {
                    echo "<div class='size-container'>";
                    echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
                    echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
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

        echo "<div class='item-description'>";
        foreach ($sizes as $size) {
            echo "<div class='size-container'>";
            echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
            echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<h2 id="cat-9">Tumblers</h2>
<div class="menu-container">
    <?php
    $query_tumblers = "SELECT m.item_id, m.name, m.description, m.image, i.size, i.price 
                      FROM menu_items m
                      JOIN item_sizes i ON m.item_id = i.item_id
                      WHERE m.category_id = 9";

    $stmt_tumblers = $pdo->query($query_tumblers);
    $tumblers = $stmt_tumblers->fetchAll(PDO::FETCH_ASSOC);

    $current_item_id = null;
    $current_item_name = "";
    $current_item_image = "";
    $sizes = [];

    foreach ($tumblers as $item) {
        // If the item_id changes, output the previous item and reset
        if ($current_item_id != $item['item_id']) {
            if ($current_item_id !== null) {
                // Display the previous item
                echo "<div class='menu-item' data-id='{$current_item_id}' data-name='{$current_item_name}' data-image='{$current_item_image}'>";
                echo "<div class='item-name'>{$current_item_name}</div>";

                // Display the image
                $image_path =  $current_item_image;
                echo "<img src='$image_path' alt='{$current_item_name}'>";

                echo "<div class='item-description'>";
                echo "<div class='choose-size'>";
                    echo "<span>Option:</span>";
                    echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
                echo "</div>";
                foreach ($sizes as $size) {
                    echo "<div class='size-container'>";
                    echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
                    echo "<button class='add-to-cart'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            }

            // Reset for the new item
            $current_item_id = $item['item_id'];
            $current_item_name = $item['name'];
            $current_item_image = $item['image'];
            $sizes = [];
        }

        // Add the size and price to the array
        $sizes[] = ['size' => $item['size'], 'price' => $item['price']];
    }

    // Output the last item
    if ($current_item_id !== null) {
        echo "<div class='menu-item' data-id='{$current_item_id}' data-name='{$current_item_name}' data-image='{$current_item_image}'>";
        echo "<div class='item-name'>$current_item_name</div>";

        // Display the image
        $image_path =  $current_item_image;
        echo "<img src='$image_path' alt='$current_item_name'>";

        echo "<div class='item-description'>";
        echo "<div class='choose-size'>";
            echo "<span>Option:</span>";
            echo "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
        echo "</div>";
        foreach ($sizes as $size) {
            echo "<div class='size-container'>";
            echo "<span class='size-price'>₱" . number_format($size['price'], 2) . "</span>";
            "<button class='info-button'>i<span class='tooltip'>Customize at checkout</span></button>";
            echo "<button class='add-to-cart tisteng-ba'  data-id='$current_item_id' data-name='$current_item_name' data-size='{$size['size']}' data-price='{$size['price']}'>Add to cart</button>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

</div>
<div class="cart-area">
    <div class="cart-container">
        <div class="basket">
            <h1 class="header">Your Cart</h1>
            <!-- Scrollable container for the items -->
            <div class="basket-items-container" id="basket-items">Your cart is empty.</div>
            <!-- Sticky total and checkout section -->
            <div class="footer">
                <div class="total">
                    <p>Total: <strong>₱<span id="total-price">0</span></strong></p>
                </div>
                <button id="checkout-button">Checkout</button>
            </div>
        </div>
    </div>
</div>
</div>
<footer>
        <div class="foot">
            <div class="about" id="about-dropdown">
                <span>About</span>
                <div class="about-content foot-content" id="about-dropdown-menu">
                    <a href="aboutus.php">Our Coffee</a>
                    <a href="aboutus.php">Our Company</a>
                    <a href="aboutus.php">Service</a>
                </div>
            </div>
            <div class="order" id="order-dropdown">
                <span>Order & Pickup</span>
                <div class="order-content foot-content" id="order-dropdown-menu">
                    <a href="ordernow.php">Order on the Web</a>
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

