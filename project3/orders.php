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

        /* Lets grab all of the orders  */
        $sql = "SELECT * FROM orders ORDER BY order_date DESC";
        $orders_result = $conn->query($sql);

        /* Utilize https://phpdelusions.net/mysqli */
        function get_prod($conn, $id) {
                $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                return $stmt->get_result()->fetch_assoc();
        }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>All Orders</title>
</head>
<body>
        <h1>Customer Orders</h1>

        <?php
                /* Lets setup how we are going to display the orders that exist in our db */
                if ($orders_result->num_rows > 0) {
                        while ($order = $orders_result->fetch_assoc()) {
                                echo "<div style='border:1px solid #ccc; padding:10px; margin:10px 0'>";
                                echo "<strong>Order ID:</strong> " . $order['id'] . "<br>";
                                echo "<strong>Date:</strong> " . $order['order_date'] . "<br>";

                                $total = 0;

                                /* We loop through all of the products we have in our db and echo out the results */
                                for ($i = 1; $i <= 5; $i++) {
                                        $product_id = $order["item{$i}_id"];
                                        $qty = $order["item{$i}_qty"];

                                        if ($product_id && $qty) {
                                                $product = get_prod($conn, $product_id);
                                                $name = $product['name'];
                                                $price = $product['price'];
                                                $cost = $price * $qty;
                                                $total += $cost;

                                                echo "- $name (Qty: $qty) @ $$price = $" . number_format($cost, 2) . "<br>";
                                        }
                                }

                                echo "<strong>Total:</strong> $" . number_format($total, 2);
                                echo "</div>";
                        }
                } else { // REMINDER: No orders fam. Lets wipe our db and make sure we are correctly hitting this.
                        echo "<p>No orders found.</p>";
                }

                $conn->close();
        ?>
</body>
</html>