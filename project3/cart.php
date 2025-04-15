<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <title>Your Cart</title>
        <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
        <h1>T-Shirt Central</h1>
        <nav>
                <a href="products.php">Products</a> |
                <a href="cart.php">Cart</a> |
                <a href="orders.php">Orders</a>
        </nav>
        <hr>
</header>

<main>
        <h2>Your Shopping Cart</h2>

        <form action="thankyou.php" method="POST">
        <?php
                /* Lets see if our products page sent us anything! */
                $product_ids = $_POST['product_ids'] ?? [];
                $quantities = $_POST['quantities'] ?? [];

                
                if (empty($product_ids)) { // Case where nothing was added.
                        echo "<p>You haven't added anything to your cart yet.</p>";
                } else {
                        /* Step 1: Establish communication with aliens -- Going delusional */
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
                        
                        /* So for each product, we want to calculate total cost and display to user + package submit form. Goodluck Juan :)*/
                        foreach ($product_ids as $id) {
                                
                                // Lets first build out the query
                                $qty = intval($quantities[$id] ?? 1);
                                $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                // With the query results, lets do the stuff if product exists
                                if ($result->num_rows > 0) {
                                        // Lets extact the data and make it variables for insertion
                                        $product = $result->fetch_assoc();
                                        $name = htmlspecialchars($product['name']);
                                        $price = number_format($product['price'], 2);
                                        $cost = number_format($product['price'] * $qty, 2);

                                        // Insert the stuff and we should be happy
                                        echo "<div>";
                                        echo "<input type='hidden' name='product_ids[]' value='$id'>";
                                        echo "<input type='hidden' name='quantities[$id]' value='$qty'>";
                                        echo "<strong>$name</strong> - $qty x $$price = $$cost";
                                        echo "</div>";
                                }
                        }
                        
                        // Goodbye db
                        $conn->close();
                        echo "<br><input type='submit' value='Check Out'>";
                }
        ?>
        </form>
</main>

<hr>
<footer>
        <p>&copy; 2025 T-Shirt Central</p>
</footer>
</body>
</html>