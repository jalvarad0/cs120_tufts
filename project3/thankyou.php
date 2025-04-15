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

        /* Alright lets setup our date variable so that we can inset into db */
        // Reference https://www.ionos.com/digitalguide/websites/web-development/php-date/ Juan!
        $order_date = date("Y-m-d H:i:s");

        /* Alright lets setup our date variable so that we can inset into db */
        $items = array_fill(0, 5, ['id' => null, 'qty' => null]);
        foreach ($product_ids as $index => $id) {
                if ($index < 5) { // We only want to process 5 items to not overflow buff
                        $items[$index]['id'] = intval($id);
                        $items[$index]['qty'] = intval($quantities[$id] ?? 1); // Check qty for that item exists, if not update it to 1.
                }
        }

        /* Juan, some resources to figure out how to insert into the db */
        // https://www.w3schools.com/php/php_mysql_prepared_statements.asp --> creating the statment looks useful.
        // https://www.php.net/manual/en/mysqli-stmt.bind-param.php --> getting all the data to conform. Pretty cool that they abstact this away.
        // https://phpdelusions.net/mysqli --> Tutorial on E2E flow.
        // Good luck fam :)

        /* Step 1: Create a statement object that we can modify that will be used to insert into db */
        $sql_input_statement = $conn->prepare("
                INSERT INTO orders (
                        order_date, item1_id, item1_qty,
                        item2_id, item2_qty, item3_id, item3_qty,
                        item4_id, item4_qty, item5_id, item5_qty
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        /* Step 2: Lets now attach the values we want to the statment */
        $sql_input_statement->bind_param(
                "siiiiiiiiii",
                $order_date,
                $items[0]['id'], $items[0]['qty'],
                $items[1]['id'], $items[1]['qty'],
                $items[2]['id'], $items[2]['qty'],
                $items[3]['id'], $items[3]['qty'],
                $items[4]['id'], $items[4]['qty']
        );

        /* Part 3: Send that bad boy over */
        $sql_input_statement->execute();

        echo "<p>Your order has been placed successfully!</p>";
        $ship_date = date("Y-m-d", strtotime("+2 days"));
        echo "<p>Expected ship date: <strong>$ship_date</strong></p>";
        
        $conn->close();
?>
<a href="cart.php">Back to Cart</a>
</body>
</html>