<?php session_start();
$_SESSION['timeout'] = time();

 if ($_SESSION['timeout'] + 10 * 60 < time()) {
    header('Location: logout.php');
 }
?>
<?php require "functions.php"?>
<?php
    if (isset($_GET['name'])){
        $name = urldecode($_GET['name']);
        $room = getDescByName($name);
    }
?>

<?php

$usererror = "";
$currentDateTime = date('d/m H:i');



if(isset($_POST['submit'])) {
	$userName = $_POST['name'];
    $userSurname = $_POST['surname'];
    $userEmail = $_POST['email'];
	$userPhone = $_POST['phone'];
    $userNumRooms = $_POST['rooms'];
    $userAdults = $_POST['adults'];
    $userChildren = $_POST['children'];
    $userCheckin = $_POST['checkin'];
    $userCheckout = $_POST['checkout'];
    $userDelays = $_POST['delays'];
    $userPet = $_POST['pet'];
    $userMessage = $_POST['comment'];

	$toEmail = $room[0]['email'];


    if(strlen($userName) <= 2){
        $usererror = "<br />At least 2 leters!";
    }else if(strlen($userSurname) <= 2){
        $usererror = "<br />At least 2 leters!";
    }else if(strlen($userPhone) != 10){
        $usererror = "<br />Invalid phone number";
    }else if($userCheckin > $userCheckout){
        $usererror = "<br />The check in date cant be after the check out date!";
    }else if($currentDateTime > $userCheckin ){
        $usererror = "<br />The arival date cant be before the today's date!";
    }else{
	    $mailHeaders = "Ονομα: " . $userName .
        "\r\n Επίθετο: " . $userSurname .
	    "\r\n Email: " . $userEmail  . 
	    "\r\n Κινήτο: " . $userPhone  .
        "\r\n Αριθμός Δωματίων: " . $userNumRooms .
        "\r\n Αριθμός Ενηλίκων: ". $userAdults .
        "\r\n Αριθμός Ανηλίκων: ". $userChildren .
        "\r\n Ημερομηνία άφιξης: ". $userCheckin .
        "\r\n Ημερομηνία αναχώρησης:". $userCheckout .
        "\r\n Ευέλικτες ημερομηνίες:". $userDelays .
        "\r\n κατοικίδιο: ". $userPet .
	    "\r\n Message: " . $userMessage . "\r\n";

	    if(mail($toEmail, $userName, $mailHeaders)) {
	        $message = "Η εκδήλωση ενδιαφέροντος για το κατάλυμα:";
            echo "<script> alert('Mail sent succesfully'); </script>";      
	    }else{
            echo "<script> alert('Mail wasn sent. Error!'); </script>";     
        }
    }
}
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
    <div class="reservation-form">
        <h2>Φόρμα Επικοινωνίας</h2>
        <form name="ContactForm" method="post" id="contact">

            <span style="color: red;"> <?php echo $usererror; ?></span><br>

            <label for="name">Όνομα: <em>*</em></label>
            <input type="text" id="name" name="name" required><br>

            <label for="surname">Επίθετο: <em>*</em></label>
            <input type="text" id="surname" name="surname" required><br>

            <label for="email">Email: <em>*</em></label>
            <input type="email" id="email" name="email" required><br>

            <label for="phone">Αριθμός Κινητού: <em>*</em></label>
            <input type="tel" id="phone" name="phone" required><br>

            <label for="rooms">Αριθμός Δωματίων: <em>*</em></label>
            <input type="number" id="rooms" name="rooms" min="1" value="1" required><br>

            <label for="adults">Αριθμός Ενηλίκων: <em>*</em></label>
            <input type="number" id="adults" name="adults" min="1" value="1" required><br>

            <label for="children">Αριθμός Ανηλίκων: <em>*</em></label>
            <input type="number" id="children" name="children" min="0" value="0"required><br>

            <label for="checkin">Ημερομηνία άφιξης: <em>*</em></label>
            <input type="date" id="checkin" name="checkin" required><br>

            <label for="checkout">Ημερομηνία αναχώρησης: <em>*</em></label>
            <input type="date" id="checkout" name="checkout" required><br>

            <input type="checkbox" id="delays" name="delays">
            <label for="delays">Ευέλικτες ημερομηνίες <em>*</em></label><br>

            <label for="pet">κατοικίδιο: <em>*</em></label>
            <select id="pet" name="pet">
                <option value="none">τίποτα</option>
                <option value="dog">Σκύλος</option>
                <option value="cat">Γάτα</option>
                <option value="Bird">Πτηνό</option>
                <option value="other">Άλλο</option>
            </select><br>

            <label for="comment">Σχόλια/Ερωτήσεις: <em>*</em></label><br>
            <input type="text" id="comment" name="comment" aria-colspan="10"></input><br><br>


            <script src="captcha.js"></script>
                <div class="g-recaptcha" data-theme="light" data-size="normal"
                                data-callback="captchaVerified" data-expired-callback="captchaExpired"
                                data-sitekey="6LehBPspAAAAAHwhfLe1QD0eyP-1a8siwhmose7A">
                </div>
                <div class="text-center mt-3">
                    <button class="btn" id="submit" type="submit"
                        name="submit" disabled aria-disabled="true"><i class="fa fa-paper-plane"></i> &nbsp;
                        Αποστολή</button>
                </div>
                <?php if (!empty($message)) {?>
            <div class='success'>
            <strong><?php echo $message; ?>	</strong>
            <?php } ?>
        </form>



        
    </div>
</div>
<footer>
   <h6> &copy;Δωματιο: <?php  echo $room[0]['name']?></h6>
</footer>


<script>src="dates.js"</script>
</body>
</html>