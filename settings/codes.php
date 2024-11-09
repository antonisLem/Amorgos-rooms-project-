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

$passerror = "";
if (isset($_POST['submit'])){

$oldcode = $_POST['old_code'];
$newcode = $_POST['new_code'];
$newcode2 = $_POST['new_code2'];

    if( $oldcode == $password && $newcode == $newcode2){
        if($oldcode == $newcode){
            echo "<script> alert('your new password cant be your old password request denied'); </script>";
        }else{
            $password = $newcode;
            $password2 = $newcode2;

            mysqli_select_db( $conn, "contact_info" );
            mysqli_query( $conn,"UPDATE signup SET password = '$newcode' , password2 = '$newcode2' WHERE sign_id = '$id'; "); 
            echo "<script> alert('Updated!'); </script>";
                header("Location: codes.php?Updated!!!");
        }
    }
    else if( $newcode != $newcode2){   
        $passerror = "<br />Passwords doesnt match!";
    }else if( $oldcode != $password){
        $passerror = "<br />Incorect password";
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
        <h2>Ενημέρωση Κωδικών πρόσβασης</h2>


        <form name="name1" method="post" id="">
            <label for="old_code">Παλιός Κωδικός πρόσβασης:</label><br>
            <input type="password" id="old_code" name="old_code" required><br>

            <label for="new_code">Νεος Κωδικός πρόσβασης:</label><br>
            <input type="text" id="new_code" name="new_code" required><br>

            <label for="new_code2">Επιβεβαίωση Νέου Κωδικού πρόσβασης:</label><br>
            <input type="password" id="new_code2" name="new_code2" required><br>
            <span style="color: red;">  <?php echo $passerror; ?> </span>

            <input type="submit" value="Ενημέρωση" name = 'submit'>
        </form>

</div>      

</body>
</html>