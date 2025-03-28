<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Associative Array PHP</title>
    <style>
        .associative_arr {
            font-family: monospace;
            white-space: pre;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <!-- Version control: V0.0 -->
    <h1>Store Hours Printer</h1>
    <div id="associative_arr">
        <?php 
            $store_hrs = array('Monday' => '9am - 4pm', 
            'Tuesday' => '9am - 4pm',
            'Wednesday' => '9am - 2pm',
            'Thursday' => '9am - 4pm',
            'Friday' => '9am - 2pm',
            'Saturday' => '9am - 4pm',
            'Sunday' => '9am - 2pm');
            echo loop_through_store_hrs($store_hrs); 
        ?>
    </div>

    <?php
    function loop_through_store_hrs($store_hrs) 
    {
        $output = "<pre>";
        foreach ($store_hrs as $day => $hours) {
            $output .= str_pad($day, 12) . ": " . $hours . "\n";
        }
        $output .= "</pre>";
        return $output;
    };
    ?>

</body>
</html>