<?php session_start();
$_SESSION['timeout'] = time();

 if ($_SESSION['timeout'] + 10 * 60 < time()) {
    header('Location: logout.php');
 }
?>
<?php require "functions.php"?>

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

$username = $_SESSION['username'];

$result = mysqli_query($conn,"SELECT DISTINCT * FROM signup WHERE username = '$username'");
$row = mysqli_fetch_row($result);
$name = $row[0];
$surname = $row[1];
$compname = $row[2];
$phone = $row[3];
$phone2 = $row[4];
$email = $row[5];
$username = $row[6];
$password = $row[7];
$password2= $row[8];
$id = $row[9];

if (isset($_POST['submit'])){

$newname = $_POST['new_name'];
$newsur = $_POST['new_sur'];
$newcname = $_POST['new_cname'];

$result2 = mysqli_query($conn,"SELECT DISTINCT * FROM signup WHERE compname = '$newcname'");

if(strlen($newname) != 0){
    mysqli_select_db( $conn, "contact_info" );
    mysqli_query( $conn,"UPDATE signup SET name = '$newname' WHERE sign_id = '$id'; "); 
}
if(strlen($newsur) != 0){
    mysqli_select_db( $conn, "contact_info" );
    mysqli_query( $conn,"UPDATE signup SET surname = '$newsur' WHERE sign_id = '$id'; "); 
}
if(strlen($newcname) != 0){
    if( mysqli_num_rows($result2) > 0){
        echo "<script> alert('company name already in use request denied!'); </script>";
    }else{
        mysqli_select_db( $conn, "contact_info" );
    mysqli_query( $conn,"UPDATE signup SET compname = '$newcname' WHERE sign_id = '$id'; "); 
    }
}
            echo "<script> alert('Updated!'); </script>";
                header("Location: names.php?Updated!!!");
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amorgos-rooms</title>
    <link rel="stylesheet" href="styles/formStyles.css">
</head>

<body class="body">
<div class="navbar" >
        <nav>
            <ul>
                <li><a href="names.php">Όνοματα</a></li>
                <li><a href="codes.php">Κωδικοί πρόσβασης</a></li>
                <li><a href="email.php">Email</a></li>
                <li><a href="phone.php">Τηλεφωνικοί αριθμοί</a></li>
            </ul>
        </nav>
        </div>
        <div class="container">
        <h2>Ενημέρωση Ονομάτων</h2>

        <p>Όνομα: <?php echo $name?></p>
        <P>Επίθετο: <?php echo $surname ?></P>
        <p>Όνομα Εταίριας: <?php echo $compname ?></p>

        <form name="name1" method="post" id="">
            <label for="new_name">Νεο Όνομα:</label><br>
            <input type="text" id="new_name" name="new_name"><br>

            <label for="new_sur">Νεο Επίθετο:</label><br>
            <input type="text" id="new_sur" name="new_sur"><br>

            <label for="new_cname">Νεο Όνομα Εταίριας:</label><br>
            <input type="text" id="new_cname" name="new_cname"><br>

            <input type="submit" value="Ενημέρωση" name = 'submit'>
        </form>
</div>
     

</body>
</html>