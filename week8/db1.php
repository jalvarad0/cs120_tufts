<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Music Genres</title>
</head>
<body>

    <!-- Version control because siteground seems delayed? V0.1 -->
    <h1>Music Genre Generator</h1>

    <!-- Here is where we send the info over to the second file -->
    <form action="db2.php" method="POST"> 
        <?php
            //Alright let's grab instructors code and connect below
            //Establish connection info
            $server = "localhost"; // your server
            $userid = "uptxoagcom2z8"; // your user id
            $pw = "qd#j@41&1G1J"; //your password
            $db = "dbgcxj5jvivcy3"; //your database

            //Create connection
            $conn = new mysqli($server, $userid, $pw);

            //Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            // echo "Connected successfully <br>"; // DEBUG
        
            //Select the database
            $conn->select_db($db);
        
            //run a query
            $sql = "SELECT * FROM Genre";
            $result = $conn->query($sql);

            //get results
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<label>";
                    echo "<input type='checkbox' name='genres[]' value='" . $row["GenreID"] . "'> " . $row["Name"];
                    echo "</label><br>";
                }
            } else {
                echo "no result";
            }

            //close the connection
            $conn->close();
            
        ?>
        <input type="submit" value="Submit Genres">
    </form>
</body>
</html>