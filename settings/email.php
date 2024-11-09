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


$mailerror = "";
if (isset($_POST['submit'])){

$newmail = $_POST['new_mail'];


$result2 = mysqli_query($conn,"SELECT DISTINCT * FROM signup WHERE Email = '$newmail' ");
    if( $newmail != $email){
            $email= $newmail;

            mysqli_select_db( $conn, "contact_info" );
            mysqli_query( $conn,"UPDATE signup SET Email = '$newmail' WHERE sign_id = '$id';");
            echo "<script> alert('Updated!'); </script>";
                header("Location: email.php?Updated!!!");
        
    }
    else if( $newmail == $email){   
        $mailerror = "<br />Cant use the same mail again!";
    }else if( mysqli_num_rows($result2) != 0){
        $mailerror = "<br />Mail already registered!";
    }

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
        <h2>Ενημέρωση Email</h2>

        <p>Email: <?php echo $email?></p>

        <form name="name1" method="post" id="">
            <label for="new_mail">Νεο Email:</label><br>
            <input type="email" id="new_mail" name="new_mail"><br>
            <span style="color: red;">  <?php echo $mailerror; ?> </span>

            <input type="submit" value="Ενημέρωση" name = 'submit'>
        </form>
</div>
     

</body>
</html>