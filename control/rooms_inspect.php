<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_info";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


 session_start();
 $_SESSION['timeout'] = time();
 
  if ($_SESSION['timeout'] + 10 * 60 < time()) {
     header('Location: logout.php');
  }

  if (isset($_SESSION['admin'])) {
    $cntr = 0;
    $result = mysqli_query($conn,"SELECT * FROM room");
    while ( mysqli_num_rows($result) > $cntr) {
        $row = mysqli_fetch_row($result);

            $live = [
                'name' =>$row[0],
                'description' => $row[1],
                'email' => $row[2],
                'phone'=> $row[3],
                'link'=> $row[4],
                'image'=> $row[5],
                'area'=> $row[6],
                'id' => $row[7]
            ];

           
            //$users = json_decode(file_get_contents('rooms.json'), true);
            $lives[] = $live;
            file_put_contents('liverooms.json', json_encode($lives));
            $cntr++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <div class="navbar">
        <p><?php if(!isset($_SESSION['username']) && !isset($_SESSION['admin'])){
                                                        echo'Not logged in';
                                                    }else if(isset($_SESSION['username'])){
                                                        echo'Logged in as: ' ;
                                                        echo $_SESSION['username'];
                                                    }else if(isset($_SESSION['admin'])){
                                                        echo 'Admin:';
                                                        echo $_SESSION['admin'];
                                                    } ?></p>
        <a href="dashboard.php">Δηλώσεις</a>
        <a href="insert_page.php">Διαχειριστές</a>
        <a href="rooms_inspect.php">Δωμάτια</a>   
        <a href="users.php">Χρήστες</a>                                          
    </div>

    <div class="main-content">
        <header>
            <h1>Μενού δωματίων</h1>
        </header>


        <div class = "container">
            <h2>Δωμάτια Χρηστών</h2>
                <table >
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Desc</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Link</th>
                            <th>Image</th>
                            <th>Area</th>
                            <th>ID</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="live-output">
                        <!-- More user rows go here -->
                    </tbody>                                
                </table>
                <script src = "fetchlive.js"></script>
            </div>

    </div>
            
</body>
</html>