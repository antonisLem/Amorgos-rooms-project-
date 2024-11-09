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

 
 if (isset($_GET['id'])) {  
      $id = $_GET['id'];  
      mysqli_query( $conn,"DELETE FROM signup WHERE sign_id = '$id' "); 
       header('location:users.php');  
 }  
 ?>  