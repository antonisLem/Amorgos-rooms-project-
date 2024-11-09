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

$mailerror = "";
$usererror = "";
$passerror = "";
$phoneerror = "";
$phoneerror2 = "";

if (isset($_POST['submit'])){
    $name= $_POST['name'];
    $surname = $_POST['surname'];
    $cname = $_POST['company-name'];
    $phone = $_POST['company-phone'];
    $phone2 = $_POST['second-phone'];
    $email= $_POST['company-email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordc = $_POST['confirm-password'];
    
    
    $resultuser = mysqli_query($conn, "SELECT * FROM signup WHERE username = '$username' ");
    $resultmail = mysqli_query($conn, "SELECT * FROM signup WHERE Email = '$email' ");         
    

if(mysqli_num_rows($resultuser) > 0){
            //echo "<script> alert('Username already in use!'); </script>";
            //header("Location: sign-up.php?UserExists");
            $usererror = "<br />Username alredy in use!";
}else if(mysqli_num_rows($resultmail) > 0){
            //echo "<script> alert('Mail already in use!'); </script>";
            //header("Location: sign-up.php?UserExists");
            $mailerror = "<br />Mail alredy in use!";
}else if(strlen($phone) != 10){
    $phoneerror = "<br />Not viable number.  Must have 10 digits!";

}else if (strlen($phone2) != 10 && strlen($phone2) != 0){
    $phoneerror2 = "<br />Not viable number. Must have 10 digits!";

}else if(($password == $passwordc)){

    if(strlen($password) <= 8){
        //echo "<script> alert('Password need at least 8 digits!'); </script>";
        //header("Location: sign-up.php?WrongPass1");
        $passerror = "<br />Need at least 8 digits!";
    }else if(!preg_match("#[0-9]+#", $password)){
        //echo "<script> alert('Password at least one digit!'); </script>";
        //header("Location: sign-up.php?WrongPass2");
        $passerror = "<br />At least one integer!";
    }else if(!preg_match("#[a-z]+#", $password)){
        //echo "<script> alert('Password at least one lowercare character!'); </script>";
        //header("Location: sign-up.php?WrongPass3");
        $passerror = "<br />At least one lowercare character!";
    }else if(!preg_match("#[A-Z]+#", $password)){
        //echo "<script> alert('Password at least one capital character!'); </script>";
        //header("Location: sign-up.php?WrongPass4");
        $passerror = "<br />At least one capital character!";
    }else{
        mysqli_query($conn, "INSERT INTO signup (name , surname , compname, phone, phone2, Email, username, password, password2) 
                     VALUES ('$name','$surname','$cname','$phone', '$phone2', '$email', '$username','$password','$passwordc' )"); 
        echo "<script> alert('Account Succresfully Created'); </script>";

        $toEmail = $email;

        $mailHeaders = "Ονομα: " . $name .
        "\r\n Επίθετο: " . $surname .
	    "\r\n Εταιρηκο όνομα: " . $cname  . 
	    "\r\n Κινήτο: " . $phone  .
        "\r\n 2ο Κινήτο: " . $phone2 .
        "\r\n Email: ". $email .
        "\r\n Username: ". $username .
        "\r\n Password: ". $password . "\r\n";

        if(mail($toEmail, $username, $mailHeaders)) {
            $message = "Ο λογαριασμός σας στο Amorgos-Rooms:";
            echo "<script> alert('Mail sent succesfully'); </script>";      
        }else{
            echo "<script> alert('Mail wasn sent. Error!'); </script>";     
        }

        header("Location: index.php?NeedLogin");
    }
}else{
        //echo "<script> alert('The passwords doesn't match'); </script>";
        //header("Location: sign-up.php?WrongPass1");
        $passerror = "<br />The passwords doesn't match!";
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
    <link rel="stylesheet" href=
"https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity=
"sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk"
        crossorigin="anonymous">
        <script src="captcha.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="body" onload="generate()">

    <header>
        <div class="logo"></div>
        <nav>
        <ul>
                <li><a href="index.php">Αρχικη</a></li>
                <li><a href="find-a-room.php">Αναζήτηση</a></li>
                <li><a href="create_page.php">Καταχώριση </a></li>
                <li><a href="more.php">Περισσότερα</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="reservation-form">
            <h2>Εγγραφή</h2>
            <form name="signUpForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="sign">
                <label for="name">Όνομα υπευθύνου:</label>
                <input type="text" id="name" name="name" required><br>

                <label for="surname">Επίθετο υπευθύνου:</label>
                <input type="text" id="surname" name="surname" required><br>

                <label for="company-name"> Επωνυμία επιχείρησης:</label>
                <input type="text" id="company-name" name="company-name" required><br>

                <label for="company-phone">Τηλέφωνο επιχείρησης:</label>
                <input type="tel" id="company-phone" name="company-phone" required><br>
                <span style="color: red;">  <?php echo $phoneerror2; ?> </span>

                <label for="second-phone">Δευτερο τηλέφωνο (Προαιρετικό):</label>
                <input type="tel" id="second-phone" name="second-phone"><br>
                <span style="color: red;">  <?php echo $phoneerror; ?> </span>

                <label for="company-email">Email:</label>
                <input type="email" id="company-email" name="company-email" required><br>
                <span style="color: red;">  <?php echo $mailerror ?> </span>
 
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required><br>   
                <span style="color: red;">  <?php echo $usererror; ?> </span>

                <label for="password">Password</label>
                <input type="text" id="password" name="password" required><br>   
                <span style="color: red;">  <?php echo $passerror; ?> </span>
                
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required><br>   
                
                
           
                <script src="captcha.js"></script>
                <div class="g-recaptcha" data-theme="light" data-size="normal"
                                data-callback="captchaVerified" data-expired-callback="captchaExpired"
                                data-sitekey="6LehBPspAAAAAHwhfLe1QD0eyP-1a8siwhmose7A">
                </div>
                <div class="text-center mt-3">
                    <button class="btn" id="submit" type="submit"
                        name="submit" disabled aria-disabled="true">
                        Εγγραφή</button>
                        
                </div>
        </div>
    </div>

    </body>
    </html>