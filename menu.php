<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Page</title>
    <style>
        body {
            font-family: Georgia, serif;
            background-image: url('Rectangle7.png'); /* Set the background image */
            background-size: cover; /* Ensure the image covers the entire viewport */
            background-position: center; /* Center the image */
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #ECE0D1;
        }

        .navbar {
            background-color: #f5f5f5;
            padding: 10px;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-hamburger {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            width: 100px; 
        }

        h1 {
            font-family: 'Georgia', serif;
            font-weight: bold;
            color: #A52A2A;
        }
        h2 {
            font-family: 'Georgia', serif;
            font-weight: bold;
            color: #A52A2A;
            }
        
        .order-now-btn {
            background-color: #A52A2A;
            color: white;
            font-size: 18px;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
            text-decoration: none;
            display: inline-block;
        }

      .menu-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }

        .menu-item {
            padding: 15px;
            margin: 10px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
            color: #A52A2A;
            font-family: Lora, serif;
        }

        .menu-item img {
            width: 200px;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .menu-item:hover {
            background-color: #ECE0D1;
        }

        .item-name {
            font-size: 1.5em;
            font-weight: bold;
        }

        .item-description {
            font-size: 1.1em;
            margin-top: 5px;
        }
        @media (max-width: 768px) {
            .menu-container {
                flex-direction: column;
                align-items: center;
            }

            .menu-item {
                width: 80%;
            }
          footer{
    background: #634832;
}
footer span{
    font-family: 'Inter', sans-serif;
    font-weight: 300;
    opacity: .7;
    margin-bottom: 40px;
    cursor:pointer;
    transition: .2s;
}
footer span:hover{
    opacity: 1;
}
.foot{
    display: grid;
    grid-template-columns: 10% repeat(5, 1fr) ;
    color: #fff;
    
}
.about{
    grid-column-start: 2;
}
.about, .order, .location, .social{
    display: flex;
    flex-direction: column;
}
.about span, .order span, .location span, .social span{
    font-size: 24px;
    font-weight: 400
    margin-bottom: 40px;
    margin-top: 50px;;
    opacity: 1;
}

.about a, .order a, .location a, .social a{
    font-size: 20px;
    font-family: 'Inter', sans-serif;
    text-decoration: none;
    margin-bottom: 10px;
    color: #ffffff9d;
}
.language{
    display: flex;
    flex-direction: column;
    /* align-items: center; */
}
.language span{
    font-size: 24px;
    margin-bottom: 40px;
    font-weight: 400;
    margin-top: 50px;
    opacity: 1;
}
.language-picker select, .language-picker option{
    font-family: 'Inter', sans-serif;
}



@media(max-width: 768px){
    .about, .order, .location, .social{
        padding-left: 10px;
        padding-right: 10px;
    }
}

@media(max-width: 480px){
    footer .foot{
        grid-template-columns: 1fr;  /* Stack all sections in a single column */
        padding: 0 10px;  /* Optional: Add padding for better spacing */
    }

    .about{
        grid-column-start: 1;
    }
    
    .about, .order, .location, .social, .language{
        width: 100%;  /* Ensure they take up full width */
        margin-bottom: 20px;  /* Add some spacing between sections */
    }

    .about span, .order span, .location span, .social span, .language span{
        font-size: 20px;  /* Adjust font size for smaller screens */
        margin-bottom: 20px;  /* Adjust spacing for better readability */
    }

    .about a, .order a, .location a, .social a{
        font-size: 18px;
        margin-bottom: 8px;
    }

    .language-picker{
        margin-bottom: 55px;
    }

    .language-picker select{
        width: 100%;  /* Ensure the language picker is full width */
    }
}
}
    </style>
</head>
<body>

    <div class="navbar">
        <div class="nav">
            <div class="logo-hamburger">
                <div class="logo">
                    <img src="Sip__n_grind_logo.png" alt="SnG Logo" width="150" height="80">
                </div>
            </div>
        </div>
    </div>

    <h1>In-store Menu</h1>

    <a href="https://your-order-link.com">
        <button class="order-now-btn">Order Now</button>
    </a>

    <h2>Brewed Coffee</h2>

    <div class="menu-container">
        <div class="menu-item">
            <div class="item-name">Steamy Sips</div>
            <img src="./images/Steamy Sips.png" alt="Steamy Sips">
            <div class="item-description">A classic hot brewed coffee, perfect for those seeking warmth and traditional flavor to start their day.
            <br>Small(₱60) | Medium(₱80) | Large(₱100)</div>
        </div>

        
        <div class="menu-item">
            <div class="item-name">Chill Brew</div>
            <img src="./images/Chill Brew.png" alt="Chill Brew">
            <div class="item-description">A cold brew coffee steeped to perfection. Ideal for those who prefer a refreshing start to their day.
            <br>Small(₱70) | Medium(₱95) | Large(₱110)</div>
        </div>
        
        <div class="menu-item">
            <div class="item-name">Sweet Vanilla Dream</div>
            <img src="./images/Sweet Vanilla Dream.png" alt="Sweet Vanilla Dream">
            <div class="item-description">A smooth blend of vanilla sweet cream and brewed coffee, a perfect balance of sweetness and bitterness.
            <br>Small(₱75) | Medium(₱95) | Large(₱115)</div>
        </div>

        <div class="menu-item">
            <div class="item-name">Midnight Caramel Delight</div>
            <img src="./images/Midnight Caramel Delight.png" alt="Midnight Caramel Delight">
            <div class="item-description">Rich brewed coffee combined with dark caramel syrup for a luscious treat.
            <br>Small(₱75) | Medium(₱95) | Large(₱100)</div>
        </div>

        <div class="menu-item">
            <div class="item-name">Barako Punch</div>
            <img src="./images/Barako Punch.png" alt="Barako Punch">
            <div class="item-description">Authentic Batangueno barako coffee, known for its strong and robust flavor; perfect for true coffee lovers.
            <br>Small(₱65) | Medium(₱85) | Large(₱105)</div>
        </div>
    </div>
    <h2>Frappes</h2>
    <div class="menu-container">
    <div class="menu-item">
        <div class="item-name">Berry Frost Frappe</div>
        <img src="./images/BerryFrostFrappe.png" alt="Berry Frost Frappe">
        <div class="item-description">A refreshing strawberry-flavored frappe. Light and sweet, perfect for berry lovers.
        <br>Small(₱90) | Medium(₱110) | Large(₱130)</div>
    </div>
    
    <div class="menu-item">
        <div class="item-name">Mocha Freeze Frappe</div>
        <img src="./images/Mocha Freeze Frappe.png" alt="Mocha Freeze Frappe">
        <div class="item-description">Rich chocolate espresso blended into an icy beverage. A perfect balance of coffee and chocolate.
        <br>Small(₱85) | Medium(₱90) | Large(₱100)</div>
    </div>
    
    <div class="menu-item">
        <div class="item-name">Nutty Bliss Frappe</div>
        <img src="./images/Nutty Bliss Frappe.png" alt="Nutty Bliss Frappe">
        <div class="item-description">Creamy macadamia flavor blended into a frozen, nutty beverage.
        <br>Small(₱100) | Medium(₱120) | Large(₱140)</div>
    </div>
    
    <div class="menu-item">
        <div class="item-name">Cookie Crunch Frappe</div>
        <img src="./images/Cookie Crunch Frappe.png" alt="Cookie Crunch Frappe">
        <div class="item-description">A blend of chocolate cookies with a hint of coffee, a sweet treat for chocolate lovers.
        <br>Small(₱95) | Medium(₱115) | Large(₱135)</div>
    </div>
    
    <div class="menu-item">
        <div class="item-name">Purple Frost Frappe</div>
        <img src="./images/Purple Frost Frappe.png" alt="Purple Frost Frappe">
        <div class="item-description">A vibrant ube frappe that brings both sweetness and nutty flavor.
        <br>Small(₱90) | Medium(₱110) | Large(₱130)</div>
    </div>
</div>
<h2>Espresso</h2>
<div class="menu-container">
    <div class="menu-item">
        <div class="item-name">Espresso-shot</div>
        <img src="./images/Espress-shot.png" alt="Espresso-shot">
        <div class="item-description">A strong shot of espresso for those who need an instant boost of energy.
        <br>Single Shot(₱80) | Double Shot(₱70)  | Triple Shot(₱90)</div>
    </div>
    
    <div class="menu-item">
        <div class="item-name">Silky smooth flat white</div>
        <img src="./images/Silky smooth flat white.png" alt="Silky smooth flat white">
        <div class="item-description">Velvety espresso topped with microfoam; a simple, silky, and satisfying espresso.
        <br>Small(₱80) | Medium(₱100) | Large(₱120)</div>
    </div>
    
    <div class="menu-item">
        <div class="item-name">Foamy Cappuccino</div>
        <img src="./images/Foamy Cappuccino .png" alt="Foamy Cappuccino">
        <div class="item-description">A classic cappuccino with a rich espresso base topped with thick, creamy foam.
        <br>Small(₱85) | Medium(₱105) | Large(₱125)</div>
    </div>
    
    <div class="menu-item">
        <div class="item-name">Iced Americano</div>
        <img src="./images/Iced Americano.png" alt="Iced Americano">
        <div class="item-description">A cold, refreshing take on the traditional Americano.
        <br>Small(₱75) | Medium(₱95) | Large(₱100)</div>
    </div>
    
    <div class="menu-item">
        <div class="item-name">Frosted Latte</div>
        <img src="./images/Frosted Latte.png" alt="Frosted Latte">
        <div class="item-description">A chilled version of espresso mixed with cold milk and ice, offering a refreshing way of enjoying coffee.
        <br>Small(₱85) | Medium(₱105) | Large(₱125)</div>
    </div>
</div>

<h2>Blended Beverages</h2>
<div class="menu-container">
    <div class="menu-item">
        <div class="item-name">Tropical Mango Delight</div>
        <img src="./images/Tropical Mango Delight.png" alt="Tropical Mango Delight">
        <div class="item-description">Tropical mangoes blended with graham crackers, finished with whipped cream and graham sprinkles. Perfect for the hot weather.
        <br>Small(₱95) | Medium(₱115) | Large(₱135)</div>
    </div>
    
    <div class="menu-item">
        <div class="item-name">Creamy Avocado Shake</div>
        <img src="./images/Creamy Avocado Shake.png" alt="Creamy Avocado Shake">
        <div class="item-description">Creamy avocado in a refreshing shake, perfect drink that will give you the thrill of sweetness.
        <br>Small(₱100) | Medium(₱120) | Large(₱140)</div>
    </div>
    
    <div class="menu-item">
        <div class="item-name">Caramel Banana Swirl</div>
        <img src="./images/Caramel Banana Swirl.png" alt="Caramel Banana Swirl">
        <div class="item-description">A blend of sweet bananas and rich caramel sauce, topped with creamy whipped cream.
        <br>Small(₱90) | Medium(₱110) | Large(₱130)</div>
    </div>
    
   <div class="menu-item">
        <div class="item-name">Strawberry Cream Shake</div>
        <img src="./images/Strawberry Cream Shake.png" alt="Choco-banana Delight">
        <div class="item-description">A swirl of strawberries and creamy goodness touched with elegance. 
        <br>Small(₱95) | Medium(₱115) | Large(₱135)</div>
    </div>
    <div class="menu-item">
        <div class="item-name">Choco-banana Delight</div>
        <img src= "./images/Choco-banana Delight.png" alt="Choco-banana Delight">
        <div class="item-description">Classic chocolate meets sweet banana, perfect for chocoholics. 
        <br>Small(₱100) | Medium(₱120) | Large(₱140)</div>
    </div>
</div>
    <h2>Chocolate Beverages</h2>
<div class="menu-container">
    <div class="menu-item">
        <div class="item-name">Cocoa Magic</div>
        <img src="./images/Cocoa Magic.png" alt="Cocoa Magic">
        <div class="item-description">Rich and velvety hot chocolate drink that will keep you warm and cozy.
        <br>Small(₱70) | Medium(₱90) | Large(₱110)</div>
    </div>
    
    <div class="menu-item">
        <div class="item-name">Icy Choco Magic</div>
        <img src="./images/Icy Choco Magic .png" alt="Icy Choco Magic">
        <div class="item-description">A chilled chocolate drink that will keep you cool.
        <br>Small(₱75) | Medium(₱95) | Large(₱115)</div>
    </div>
</div>

<h2>Seasonal Beverages</h2>
<div class="menu-container">
    <div class="menu-item">
        <div class="item-name">Buko Pandan Latte</div>
        <img src="./images/Buko Pandan Latte.png" alt="Buko Pandan Latte">
        <div class="item-description">A tropical twist to your latte, featuring the sweet, fragrant flavors of buko pandan.
        <br>Small(₱85) | Medium(₱105) | Large(₱125)</div>
    </div>
    
    <div class="menu-item">
        <div class="item-name">Purple Taro Latte</div>
        <img src="./images/Purple Taro Latte.png" alt="Purple Taro Latte">
        <div class="item-description">A creamy, smooth latte infused with the earthy sweetness of taro, giving a unique and colorful spin to a traditional latte.
        <br>Small(₱85) | Medium(₱105) | Large(₱125)</div>
    </div>
    
    <div class="menu-item">
        <div class="item-name">Halo-Halo Delight</div>
        <img src="./images/Halo-Halo Delight.png" alt="Halo-Halo Delight">
        <div class="item-description">Inspired by a Filipino classic, this frappe brings the sweetness of halo-halo ingredients into a refreshing icy drink.
        <br>Small(₱95) | Medium(₱115) | Large(₱135)</div>
    </div>
    
    <div class="menu-item">
        <div class="item-name">Salted Caramel Latte</div>
        <img src="./images/Salted Caramel Latte.png" alt="Salted Caramel Latte">
        <div class="item-description">A sweet and salty caramel flavor on the latte, combining the creamy milk with rich espresso.
        <br>Small(₱90) | Medium(₱110) | Large(₱130)</div>
    </div>
</div>
<h2>Tea Beverages</h2>
<div class="menu-container">
    <div class="menu-item">
        <div class="item-name">Zesty Calamansi Tea</div>
        <img src=" ./images/Zesty Calamansi Tea.png" alt="Zesty Calamansi Tea">
        <div class="item-description">A refreshing citrus tea with a zesty kick of calamansi, perfect for a cool, quick sip.
        <br>Small(₱50) | Medium(₱70) | Large(₱90)</div>
    </div>

    <div class="menu-item">
        <div class="item-name">Matcha Frostea</div>
        <img src="./images/Matcha Frostea.png" alt="Matcha Frostea">
        <div class="item-description">A frosty blend of matcha and milk, offering an energizing green tea experience.
        <br>Small(₱90) | Medium(₱110) | Large(₱130)</div>
    </div>

    <div class="menu-item">
        <div class="item-name">Sweet Brown Sugar Rush</div>
        <img src="./images/Sweet Brown Sugar Rush.png" alt="Sweet Brown Sugar Rush">
        <div class="item-description">Classic milk tea with rich, caramelized brown sugar.
        <br>Small(₱85) | Medium(₱105) | Large(₱125)</div>
    </div>

    <div class="menu-item">
        <div class="item-name">Matcha Wave</div>
        <img src="./images/Matcha Wave.png" alt="Matcha Wave">
        <div class="item-description">A refreshing blend of Japanese green tea and creamy frappe for a harmonious blend.
        <br>Small(₱95) | Medium(₱115) | Large(₱135)</div>
    </div>

    <div class="menu-item">
        <div class="item-name">Wintermelon Creme</div>
        <img src="./images/Wintermelon Creme.png" alt="Wintermelon Creme">
        <div class="item-description">A sweet and creamy milk tea with a distinct flavor of wintermelon.
        <br>Small(₱85) | Medium(₱105) | Large(₱125)</div>
    </div>
</div>
<h2>Pastries</h2>
<div class="menu-container">
    <div class="menu-item">
        <div class="item-name">Choco Chip Treat</div>
        <img src="./images/Choco Chip Treat.png" alt="Choco Chip Treat">
        <div class="item-description">A classic chocolate chip cookie with gooey chocolate in every bite, a perfect match for every drink.
        <br>₱40</div>
    </div>

    <div class="menu-item">
        <div class="item-name">Banana Loaf</div>
        <img src="./images/Banana Loaf.png" alt="Banana Loaf">
        <div class="item-description">Moist and sweet banana bread, perfect for a light snack to pair with your beverage.
        <br>₱50</div>
    </div>

    <div class="menu-item">
        <div class="item-name">Cinnamon Swirl</div>
        <img src="./images/Cinnamon Swirl.png" alt="Cinnamon Swirl">
        <div class="item-description">A soft and fluffy cinnamon roll with a sweet glaze, delivering warmth in every bite.
        <br>₱60</div>
    </div>

    <div class="menu-item">
        <div class="item-name">Blueberry Burst Muffin</div>
        <img src="./images/Blueberry Burst Muffin.png" alt="Blueberry Burst Muffin">
        <div class="item-description">A soft muffin bursting with sweet blueberries in every bite.
        <br>₱65</div>
    </div>

    <div class="menu-item">
        <div class="item-name">Apple Crumble Pie</div>
        <img src="./images/Apple Crumble Pie.png" alt="Apple Crumble Pie">
        <div class="item-description">Sweet apple filling encased in a flaky crust topped with a crunchy crumble, pure comfort in every slice.
        <br>₱70</div>
    </div>
</div>
<h2>Tumblers</h2>

<div class="menu-container">
    <div class="menu-item">
        <div class="item-name">The Classic Grind Tumbler</div>
        <img src="./images/The Classic Grind Tumbler.png" alt="The Classic Grind Tumbler">
        <div class="item-description">A minimalist tumbler with a sleek design of Sip ‘n Grind’s logo, perfect for those who adore simplicity.
        <br>₱250</div>
    </div>

    <div class="menu-item">
        <div class="item-name">The Eco-Sip Tumbler</div>
        <img src="./images/The Eco-Sip Tumbler.png" alt="The Eco-Sip Tumbler">
        <div class="item-description">Made from eco-friendly bamboo and stainless steel, featuring a nature-inspired design and Sip ‘n Grind’s logo.
        <br>₱230</div>
    </div>
</div>
<a href="https://your-order-link.com">
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
                <div class="social">

                </div>
            </div>
        </div>
    </footer>
</body>
</html>

