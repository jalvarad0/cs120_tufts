<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You</title>
</head>
<body>
<h1>Thank You for Your Order!</h1>

<?php
        $product_ids = $_POST['product_ids'] ?? [];
        $quantities = $_POST['quantities'] ?? [];

        if (empty($product_ids)) {
                echo "<p>No products selected.</p>";
                exit;
        }

        // DB connection
        $server = "localhost";
        $userid = "uptxoagcom2z8";
        $pw = "qd#j@41&1G1J";
        $db = "dbs4nnkn5augyi";

        $conn = new mysqli($server, $userid, $pw, $db);
        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }

        $order_date = date("Y-m-d H:i:s");

        // Prepare values for up to 5 items
        $items = array_fill(0, 5, ['id' => null, 'qty' => null]);
        foreach ($product_ids as $index => $id) {
        if ($index < 5) {
                $items[$index]['id'] = intval($id);
                $items[$index]['qty'] = intval($quantities[$id] ?? 1);
        }
        }

        // Insert into orders table
        $stmt = $conn->prepare("
                INSERT INTO orders (
                order_date, item1_id, item1_qty,
                item2_id, item2_qty, item3_id, item3_qty,
                item4_id, item4_qty, item5_id, item5_qty
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
        "siiiiiiiiii",
        $order_date,
        $items[0]['id'], $items[0]['qty'],
        $items[1]['id'], $items[1]['qty'],
        $items[2]['id'], $items[2]['qty'],
        $items[3]['id'], $items[3]['qty'],
        $items[4]['id'], $items[4]['qty']
        );

        $stmt->execute();

        echo "<p>Your order has been placed successfully!</p>";
        $shipDate = date("Y-m-d", strtotime("+2 days"));
        echo "<p>Expected ship date: <strong>$shipDate</strong></p>";

        $conn->close();
?>
<a href="cart.php">Back to Cart</a>
</body>
</html>