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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms-Page</title>
    <link rel="stylesheet" href="styles/rooms.css">
    <link rel="stylesheet" href="styles/xazaS.css">
</head>
<body class="body">
    <header>
        <div class="logo"></div>
        <nav>
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

    <div class="searchDiv">
            <h1>Πληροφοριες Δωματιου</h1>
    </div>

        <div>

        <img src="<?php echo "rooms/{$room[0]['image']}"?>" alt="noroom" class="panoimg">

        </div>
        <div class="innerRoom"> 
        <h4>Στοιχια Επικοινωνιας</h4>                                            

                <p> Ιδιοκτητης: <?php  echo $room[0]['name']?></p>
                <p> Περιοχή: <?php  echo $room[0]['area']?></p>
                <p> Τηλεφωνο: <?php echo $room[0]['phone'] ?></p>
                <p> email: <?php echo $room[0]['email'] ?></p>
                <a href="contact.php?name=<?php echo urlencode($room[0]['name']) ?>" class="btn">
                Επικοινωνήστε
                </a>
        </div>

        <div class="innerRoom">
            <p><a href="<?php echo $room[0]['link'] ?>" class="btnaltalt" target="_blank">Σελίδα Ιδιοκτητη</a></p>
        </div>

        </div>

</body>
</html>