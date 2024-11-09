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


// Get form data
if (isset($_POST['submit'])){
$name= $_POST['company-name'];
$desc = $_POST['company-description'];
$email= $_POST['email'];
$phonenum = $_POST['phone'];
$link= $_POST['page'];
$image = $_POST['company-photo'];
$area = $_POST['area'];




        if(!isset($_SESSION['username']) ){
            echo "<script> alert('U have to be logged in to create a room page!'); </script>";
        }else{
            mysqli_select_db( $conn, "contact_info" );
            mysqli_query($conn, "INSERT INTO room_save (name , description ,email, phone , link, image, area) 
                                        VALUES ('$name','$desc','$email','$phonenum', '$link', '$image', '$area' )");
            echo "<script> alert('Επιτυχης υποβολη!'); </script>";
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
    <link rel="stylesheet" href="styles/start_styles.css">
    <link rel="stylesheet" href="styles/xazaS.css">
    <link rel="stylesheet" href=
"https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity=
"sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk"
        crossorigin="anonymous">
    <script src="captcha.js"></script>
</head>



<body class="body" onload="generate()">


    <header>
        <div class="logo"></div>
        <nav>
            <ul>
                <li><div class="account-container">
                    <div class="account-bubble"><?php if(!isset($_SESSION['username']) && !isset($_SESSION['admin'])){
                                                        echo'Χωρίς σύνδεση';
                                                    }else if(isset($_SESSION['username'])){
                                                        echo'Συνδεδεμένος: ' ;
                                                        echo $_SESSION['username'];
                                                    }else if(isset($_SESSION['admin'])){
                                                        echo 'Διαχηρηστης:';
                                                        echo $_SESSION['admin'];
                                                    } ?></div>
                    <div class="dropdown-menu">
                        <?php if(isset($_SESSION['username'])):?>
                            <a href="settings/names.php?username=<?php echo urlencode($_SESSION['username']) ?>" target="_blank">Ρυθμίσεις</a>
                            <a href="logout.php">Αποσύνδεση</a>
                        <?php elseif (isset($_SESSION['admin'])): ?>
                            <a href="control/insert_page.php" target="_blank">Διαχείριση δηλώσεων</a>
                            <a href="logout.php" >Αποσύνδεση</a>
                        <?php else: ?>
                            <a href="login.php" >Συνδέσου!</a>
                            <a href="sign-up.php" >Εγγραφή</a>
                        <?php endif;?>
  
                    </div>
                    </div></li>
                <li><a href="index.php">Αρχικη</a></li>
                <li><a href="find-a-room.php?int=<?php echo urlencode(5) ?>">Αναζήτηση</a></li>
                <li><a href="create_page.php">Καταχώριση </a></li>
                <li><a href="more.php">Περισσότερα</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
    <div class="advertise-form">
        <h2>Δημιουργιά Σελίδας (Απαιτείται Εγγραφή) </h2>
        <form name="CreateForm" method="post" id="">
            
            <label for="company-name">Όνομα:</label>
            <input type="text" id="company-name" name="company-name" required><br>

            <label for="company-description">Περιγφράφη:</label>
            <input type="text" id="company-description" name="company-description" required><br>

            <label for="phone">Κινητό:</label>
            <input type="tel" id="phone" name="phone" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="Page">Σελιδα</label>
            <input type="text" id="page" name="page" ><br>

            <label for="company-photo">Φωτογραφία Εταιρείας:</label>
            <input type="file" id="company-photo" name="company-photo" accept="image/*" required><br>

            <label for="area">Περιοχή</label>
            <select id="area" name="area">
                <option value="Λαγκάδα">Λαγκάδα</option>
                <option value="Θολάρια">Θολάρια</option>
                <option value="Αιγιάλη">Αιγιάλη</option>
                <option value="Κατάπολα">Κατάπολα</option>
                <option value="Αρκεσίνη">Αρκεσίνη</option>
                <option value="Άλλο">Άλλο</option>
            </select><br>

            <input type="submit" value="Υποβολή" name = 'submit'>
        </form>
    </div>
</div>


</body>
</html>