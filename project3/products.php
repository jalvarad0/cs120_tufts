<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" href="css/style.css">
        <style>
                .product {
                        border: 1px solid #ccc;
                        padding: 15px;
                        margin: 15px 0;
                        display: flex;
                        align-items: center;
                }
                .product img {
                        width: 150px;
                        height: 150px;
                        margin-right: 15px;
                        object-fit: cover;
                }
                .product-info {
                        flex: 1;
                }
                .description {
                        display: none;
                        margin-top: 10px;
                        font-style: italic;
                }
        </style>
</head>
<body>

<header>
        <h1> T-Shirt Central</h1>
        <nav>
                <a href="products.php">Products</a> |
                <a href="cart.php">Cart</a> |
                <a href="orders.php">Orders</a>
        </nav>
        <hr>
</header>

<main>
        <h2>Our T-Shirts</h2>

        <form action="cart.php" method="POST">
        <?php
                /* Lets setup the information we will use to setup our db connection */
                $server = "localhost";
                $userid = "uptxoagcom2z8";
                $pw = "qd#j@41&1G1J";
                $db = "dbs4nnkn5augyi";

                /* Connect to the db! Please work :) */
                $conn = new mysqli($server, $userid, $pw, $db);
                if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                }

                /* More sql YAY! */
                $sql = "SELECT * FROM products";
                $result = $conn->query($sql);

                /* Please let there be products! If there is lets process them here */
                if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                        // Lets extract the individual pieces of info first
                        $id = $row['id'];
                        $name = htmlspecialchars($row['name']);
                        $price = number_format($row['price'], 2);
                        $image = htmlspecialchars($row['image_url']);
                        $desc = htmlspecialchars($row['description']);
                        //echo"$id"; // DEBUG
                        //echo"$name"; // DEBUG
                        //echo"$image"; // DEBUG
                        //echo"$desc"; // DEBUG

                        // Alright lets now present the data
                        echo "<div class='product'>";
                        //echo "<p>DEBUG: " . $image . "</p>"; //DEBUG
                        echo "<img src='$image' alt='$name'>";
                        echo "<div class='product-info'>";
                        echo "<strong>$name</strong><br>";
                        echo "<span>\$$price</span><br>";
                        echo "Qty: <select name='quantities[$id]'>";
                        for ($i = 1; $i <= 5; $i++) {
                                echo "<option value='$i'>$i</option>";
                        }
                        echo "</select><br>";
                        echo "<input type='checkbox' name='product_ids[]' value='$id'> Add to cart";
                        echo "<button type='button' onclick=\"toggle_description('desc$id')\">More</button>";
                        echo "<div id='desc$id' class='description'>$desc</div>";
                        echo "</div></div>";
                        }
                } else {
                        echo "<p>No products available.</p>";
                }

                $conn->close();
        ?>
                <input type="submit" value="Go to Cart">
    </form>
</main>

<hr>
<footer>
        <p>&copy; 2025 T-Shirt Central</p>
</footer>

<script>
        // Helper function that will allow us to toggle the description of the product as asked in spec
        function toggle_description(id) {
                const desc = document.getElementById(id);
                if (desc.style.display === "none" || desc.style.display === "") {
                        desc.style.display = "block";
                } else {
                        desc.style.display = "none";
                }
        }
</script>

</body>
</html>