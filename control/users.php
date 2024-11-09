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
    $result = mysqli_query($conn,"SELECT * FROM signup");
    while ( mysqli_num_rows($result) > $cntr) {
        $row = mysqli_fetch_row($result);

            $pageuser = [
                'name' =>$row[0],
                'surname' => $row[1],
                'cname' => $row[2],
                'phone'=> $row[3],
                'phone2'=> $row[4],
                'Email'=> $row[5],
                'username'=> $row[6],
                'password' => $row[7],
                'password2' => $row[8],
                'id' => $row[9]
            ];

           
            //$users = json_decode(file_get_contents('rooms.json'), true);
            $pageusers[] = $pageuser;
            file_put_contents('users.json', json_encode($pageusers));
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
            <h1>Μενού Χρηστών</h1>
        </header>


        <div class = "container">
            <h2>Χρήστες</h2>
                <table >
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Comp-Name</th>
                            <th>Phone</th>
                            <th>Phone2</th>
                            <th>Email</th>
                            <th>username</th>
                            <th>password</th>
                            <th>password2</th>
                            <th>user id</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="users-output">
                        <!-- More user rows go here -->
                    </tbody>                                
                </table>
                <script src = "fetchusers.js"></script>
            </div>

    </div>
            
</body>
</html>