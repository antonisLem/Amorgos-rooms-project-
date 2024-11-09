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


$passerror = "";
$usererror = "";

if (isset($_POST['submit'])){
$username = $_POST['username'];
$password = $_POST['password'];



$resultuser = mysqli_query($conn, "SELECT DISTINCT username FROM signup WHERE username = '$username' AND password2 = '$password' ");
$resultpass = mysqli_query($conn, "SELECT DISTINCT password2 FROM signup WHERE password2 = '$password'");


$adminuser = mysqli_query($conn,"SELECT DISTINCT usernname FROM admin_info WHERE usernname = '$username' AND password = '$password' ");
$adminpass = mysqli_query($conn,"SELECT DISTINCT password FROM admin_info WHERE password = '$password'");


if ((mysqli_num_rows($resultuser)) > 0 && (mysqli_num_rows($resultpass) > 0)){
    mysqli_query($conn, "INSERT INTO login (username , password )  VALUES ('$username', '$password' )");
    $_SESSION['username'] = "$username";
    echo $_SESSION['username'];
    header("Location: index.php?LoggedIn!!!");
}else{
    echo "den ekane login :' (";
    if(mysqli_num_rows($resultuser) == 0){
        $usererror = "<br />Incorect username and password!";
    }else if (mysqli_num_rows($resultpass) == 0) {
        $passerror = "<br />Incorect password!";
    }else if($captcha != 1){
        $passerror = "<br />Captcha wrong";
    }else{
        $passerror = "<br />Something wrong";
    }
}


if ((mysqli_num_rows($adminuser)) > 0 && (mysqli_num_rows($adminpass) > 0) ){
    $_SESSION['admin'] = "$username";
    echo $_SESSION['admin'];
    header("Location: index.php?LoggedInAsAdmin!!!");
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
    <link rel="stylesheet" href="styles/xazaS.css">
    <link rel="stylesheet" href=
"https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity=
"sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk"
        crossorigin="anonymous">
        <script src="captcha.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="body">

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

            <h2>Συνδέσου</h2>
            <form name="loginForm" method="post" id="login">

                <label for="username">Username</label>
                <span style="color: red;">  <?php echo $usererror; ?> </span>
                <input type="text" id="username" name="username" required><br>   

                <label for="password">password</label>
                <span style="color: red;">  <?php echo $passerror; ?> </span>
                <input type="password" id="password" name="password" required><br>    

                <script src="captcha.js"></script>
                <div class="g-recaptcha" data-theme="light" data-size="normal"
                                data-callback="captchaVerified" data-expired-callback="captchaExpired"
                                data-sitekey="6LehBPspAAAAAHwhfLe1QD0eyP-1a8siwhmose7A">
                </div>
                <div class="text-center mt-3">
                    <button class="btn" id="submit" type="submit"
                        name="submit" disabled aria-disabled="true">
                        Συνδέσου</button>
                        
                </div>
        </div>
    </div>

    </body>
    </html>