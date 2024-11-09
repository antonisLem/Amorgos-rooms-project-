<?php session_start();
$_SESSION['timeout'] = time();

 if ($_SESSION['timeout'] + 10 * 60 < time()) {
    header('Location: logout.php');
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amorgos-rooms</title>
    <link rel="stylesheet" href="styles/start_styles.css">
    <link rel="stylesheet" href="styles/xazaS.css">
</head>



<body class="body">
    <header>
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


            <h1>ΚΑΛΟΣΗΛΘΑΤΕ ΣΤΗΝ AMORGOS-ROOMS</h1>
            
            <h3>Aναζήτηση & καταχώριση αγγελιών</h3>

            <div class="image-container">
                <img id="imageSwap" src="media/panorama1.jpg" alt="Image" class="panoimg">
            </div>

            <p>Η Αμοργός είναι κυκλαδίτικο νησί του Αιγαίου πελάγους. Πήρε το όνομά της από το φυτό αμοργίς,
                 ένα είδος λιναριού από το οποίο φτιάχνονταν οι «άλικοι αμοργίδες», χιτώνες της Αμοργού. Βρίσκεται στο 
                 νοτιοανατολικό άκρο των Κυκλάδων, νοτιοανατολικά της Νάξου και σε απόσταση 136 ναυτικών μιλίων από τον Πειραιά. 
                 Η επιφάνειά της εκτιμάται στα 121,464 τ.χλμ., ενώ έχει μήκος ακτών 126 χιλιόμετρα. Είναι μακρόστενο νησί που εκτείνεται 
                 από ΝΔ προς ΒΑ με απότομη ορεινή μορφολογία εδάφους. Διαθέτει δύο φυσικά λιμάνια, τα Κατάπολα και την Αιγιάλη. Πρωτεύουσα 
                 είναι η Χώρα Αμοργού με κύριο λιμάνι τα Κατάπολα.</p>

                 <div class="btncontain">
                 <a href="find-a-room.php?int=<?php echo urlencode(5) ?>" class="btnaltalt">Βρες καταλημα</a>
                 </div>

            </div>
    
           

            <script src="scripts/IndexScript.js"></script>

</body>
</html>