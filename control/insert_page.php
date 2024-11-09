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
    $result = mysqli_query($conn,"SELECT * FROM admin_info");
        while ( mysqli_num_rows($result) > $cntr) {
            $row = mysqli_fetch_row($result);
    
                $admin = [
                    'name' =>$row[0],
                    'username' => $row[1],
                    'password' => $row[2],
                    'email'=> $row[3],
                    'id' => $row[4]
                ];
               

                $admins[] = $admin;
                file_put_contents('admins.json', json_encode($admins));
                $cntr++;
        }
    }

if (isset($_POST['submit'])){

  
    $name= $_POST['name'];
    $username = $_POST['username'];
    $password= $_POST['password'];
    $email = $_POST['email'];

        mysqli_select_db( $conn, "contact_info" );
        mysqli_query($conn, "INSERT INTO admin_info (name , usernname ,password , email ) 
                                VALUES ('$name','$username','$password','$email')");
        echo "<script> alert('Προστέθηκε διαχειριστής!'); </script>";
        header("Location: insert_page.php?Ineserted");

}

$result = $conn->query("SELECT * FROM admin_info");

mysqli_close($conn);
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
            <h1>Μενού Διαχειριστή</h1>
        </header>




            <h2>προσθήκη Διαχειριστή</h2>
            <form name="dashboard" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="admins">
                <label for="name">'Ονομα:</label><br>
                <input type="text" id="name" name="name" required><br>

                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" required><br>
                
                <label for="password">Password:</label><br>
                <input type="text" id="password" name="password" required><br>

                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" required><br>
                
                <input type="submit" value="προσθήκη" name = 'submit'>
            </form>

            <div class = "container">
            <h2>Διαχειριστές</h2>
            <table >
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th>Id</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody id="admin-output">
                        <!-- More user rows go here -->
                    </tbody>                                
                </table>
                <script src = "fetchadmins.js"></script>
                </div>

    </div>
</body>
</html>