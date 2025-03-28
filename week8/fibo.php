<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fibonacci PHP</title>
</head>
<body>

    <h1>Fibonacci Generator</h1>
    <!-- Version control because siteground seems delayed? V0.0 -->
    <!-- Let's grab user input for n -->
    <form action="fibo.php" method="GET">
        <input type="number" name="n" placeholder="Enter a number">
        <button type="submit">Get Fibonacci</button>
    </form>

    <?php
        // Access the query string parameter 'n'
        $n = (int) $_GET['n']; //Lets cast a number rather than keep as string
        function fib_generator($num) {

            if ($num <= 0) return array();
            if ($num == 1) return array(0);
            if ($num == 2) return array(0,1);
            
            $fib_arr = array(0,1);
            for ($i=2; $i < $num; $i++) { 
                $temp = $fib_arr[$i-2] + $fib_arr[$i-1];
                array_push($fib_arr, $temp);
            }
            return $fib_arr;
        }

        $package = array(
            'length' => $n,
            'fibSequence' => fib_generator($n)
        );
        echo json_encode($package);
    ?>

</body>
</html>