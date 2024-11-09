<?php session_start();
$_SESSION['timeout'] = time();

 if ($_SESSION['timeout'] + 10 * 60 < time()) {
    header('Location: logout.php');
 }
?>
<?php require "functions.php"?>
<?php

    if (isset($_GET['name'])){

        $na = urldecode($_GET['name']);

    }

    $int = urldecode($_GET['int']);
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
        

    <div class="searchDiv">

        <div class="account2-container">
            <button class="account2-bubble">Αναζήτηση τοποθεσιάς</button>
            <div class="dropdown2-menu dropdown-menu-2">
                <?php $areas = getAreas()?>
                <?php 
                    foreach($areas as $area){
                ?> 
                    <a href="areas.php?area=<?php echo urlencode($area['area']) ?>">
                        <?php echo ucfirst($area['area'])?>
                    </a>
                <?php
                    }
                ?>
            </div>
        </div>

        <div class="search-bar" id="search-room">
            <form name="searchbar" method="post" id="search-bar">
                <input type="text" id="search" name="search" placeholder="Αναζήτηση.... ">
                <input type="submit" name="submit" value="Αναζήτηση">
            </form>
            <?php

                if(isset($_POST['search'])){
                    $search = urldecode($_POST['search']);
                    header("location:Search_room.php?name=$search");
                }


            ?>
        </div>

        <div class="logo"><img src="media/logo.png" alt="logo" class="logo"> </div>
            </div>
    <div class="room-list">
        
            <?php $rooms = getRoomsBySearch($na)?>
            <?php 
                foreach($rooms as $room){
            ?>
<div class="room">
                <div>
                <p><a href="room.php?name=<?php echo urlencode($room['name']) ?>">
                    <img src="<?php echo "rooms/{$room['image']}"?>" alt="noroom" class="image-rooms">
                </a></p>
                </div>
                <h3> Ιδιοκτητης: <?php  echo $room['name']?></h3>
                <p> Περιοχή: <?php  echo $room['area']?></p>
                <p> Τηλεφωνο: <?php echo $room['phone'] ?></p>
                <p> email: <?php echo $room['email'] ?></p>
                <a href="room.php?name=<?php echo urlencode($room['name']) ?>" class="btn">
                    Δωματιο:<?php echo $room['name']?>
                </a>
                </div>
            <?php
                }
            ?>
        </div>

    </div>
    </div>

</body>
</html>