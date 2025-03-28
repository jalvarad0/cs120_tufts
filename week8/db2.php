<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Songs by Genre</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            text-align: center;
        }

        h1 {
            text-align: center;
        }

        .song-list {
            display: inline-block;
            text-align: left; 
        }

        .song {
            padding: 5px 0;
            border-bottom: 1px solid #ccc;
            width: max-content;
            margin: 0 auto;
        }
    </style>
</head>
<body>

    <!-- Version control because siteground seems delayed? V0.0 -->
    <h1>Songs by Genre</h1>

    <?php
        $user_selected_genres = $_POST['genres']; // Let's grab what db1.php posted
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

        //Let's now get the input in a format that we can use it in our query
        $genre_list = implode(',', array_map('intval', $user_selected_genres));
        // echo''. $genre_list .''; // DEBUG
        
        //run a query
        $sql = "
                SELECT Song.Title, Artist.Name FROM Song
                JOIN Artist ON Song.ArtistID = Artist.ArtistID
                JOIN SongGenre ON Song.SongID = SongGenre.SongID
                WHERE SongGenre.GenreID IN ($genre_list)
                ORDER BY Song.Title ASC;
            ";
        // echo $sql; // DBEUG
        $result = $conn->query($sql);

        //get results
        if ($result->num_rows > 0) {
            echo "<div class='song-list'>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='song'>";
                echo "<strong>" . $row['Title'] . "</strong> by " . $row['Name'];
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "no result";
        }

        //close the connection
        $conn->close();
        ?>
</body>
</html>