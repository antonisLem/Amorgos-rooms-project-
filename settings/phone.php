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


$phoneerror = "";

if (isset($_POST['submit1'])){
$newphone = $_POST['new_phone'];
if($newphone != 0){
    echo "<script> alert('Updated!'); </script>";
    mysqli_query( $conn,"UPDATE signup SET phone = '$newphone' WHERE sign_id = '$id'; "); 
}
            header("Location: phone.php?Updated!!!");
}


if (isset($_POST['submit2'])){
    $newphone2 = $_POST['new_phone2'];
    if($newphone2 != 0){
        echo "<script> alert('Updated!'); </script>";
        mysqli_query( $conn,"UPDATE signup SET phone2 = '$newphone2' WHERE sign_id = '$id'; "); 
}
                header("Location: phone.php?Updated!!!");
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
        <h2>Ενημέρωση Τηλεφωνικών αριθμών</h2>

        <p>Αριθμός 1: <?php echo $phone?></p>
        <p>Αριθμός 2: <?php echo $phone2?></p>

        <form name="name1" method="post" id="">
            <label for="new_phone">Νεος Αριθμός 1:</label><br>
            <input type="tel" id="new_phone" name="new_phone"><br>

            <span style="color: red;">  <?php echo $phoneerror; ?> </span>

            <input type="submit" value="Ενημέρωση 1ου" name = 'submit1'><br>
        </form><br>
        <form name="name2" method="post" id="">

            <label for="new_phone2">Νεος Αριθμός 2:</label><br>
            <input type="tel" id="new_phone2" name="new_phone2"><br>

            <span style="color: red;">  <?php echo $phoneerror; ?> </span>

            <input type="submit" value="Ενημέρωση 2ου" name = 'submit2'><br>
        </form>
</div>
     

</body>
</html>