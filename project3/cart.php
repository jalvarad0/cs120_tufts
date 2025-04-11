<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <title>Your Cart</title>
        <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
        <h1>🧢 T-Shirt Central</h1>
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
                // DB Connection
                $server = "localhost";
                $userid = "uptxoagcom2z8";
                $pw = "qd#j@41&1G1J";
                $db = "dbs4nnkn5augyi";

                $conn = new mysqli($server, $userid, $pw, $db);
                if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                }

                // Grab products from DB
                $sql = "SELECT * FROM products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                        echo "<label>";
                        echo "<input type='checkbox' name='product_ids[]' value='" . $row["id"] . "'>";
                        echo $row["name"] . " - $" . $row["price"];
                        echo " Quantity: <input type='number' name='quantities[" . $row["id"] . "]' min='1' max='10' value='1'>";
                        echo "</label><br>";
                }
                } else {
                        echo "No products found.";
                }

                $conn->close();
        ?>
        <br>
        <input type="submit" value="Check Out">
        </form>
</main>

<hr>
<footer>
        <p>&copy; 2025 T-Shirt Central</p>
</footer>
</body>
</html>