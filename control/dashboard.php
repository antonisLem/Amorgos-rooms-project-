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


if (isset($_SESSION['admin'])) {
    $cntr = 0;
    $result = mysqli_query($conn,"SELECT * FROM room_save");
    while ( mysqli_num_rows($result) > $cntr) {
        $row = mysqli_fetch_row($result);

            $room = [
                'name' =>$row[0],
                'description' => $row[1],
                'email' => $row[2],
                'phone'=> $row[3],
                'link'=> $row[4],
                'image'=> $row[5],
                'area'=> $row[6],
                'id' => $row[7]
            ];

           
            //$users = json_decode(file_get_contents('rooms.json'), true);
            $rooms[] = $room;
            file_put_contents('rooms.json', json_encode($rooms));
            $cntr++;
    }
}


$nameerror = "";
$mailerror = "";

if (isset($_POST['submit'])){

    $id = $_POST['id'];
    $name= $_POST['name'];
    $email= $_POST['email'];
    $area = $_POST['area'];


    if(!isset($_SESSION['admin'])) {
        echo "<script> alert('U have been logged out!'); </script>";
    }else{
        mysqli_select_db( $conn, "contact_info" );
        $result_insert = mysqli_query($conn,"SELECT DISTINCT * FROM room_save WHERE name = '$name' AND email = '$email' AND area = '$area' AND temp_room_id = '$id'");
        if(mysqli_num_rows($result_insert) > 0){
            $row = mysqli_fetch_row($result_insert);
            mysqli_query($conn, "INSERT INTO room (name , description ,email, phone , link, image, area) 
                                VALUES ('$row[0]','$row[1]','$row[2]','$row[3]', '$row[4]', '$row[5]', '$row[6]')");

            mysqli_query( $conn,"DELETE FROM room_save WHERE temp_room_id = '$id'");
            echo "<script> alert('Εγγραφη αποθηκευτικε'); </script>";

            $toMail = $email;

            $mailHeaders = "\r\nName: " . $name .
            "\r\nEmail: ". $email .
            "\r\nΠεριοχη: ". $area . "\r\n";

            if(mail($toEmail, $name, $mailHeaders)) {
                $message = "To Δωμάτιο σας αποθηκευτικέ με επιτυχία:";
                echo "<script> alert('Mail sent succesfully'); </script>";      
            }else{
                echo "<script> alert('Mail wasn sent. Error!'); </script>";     
            }

            header("Location: dashboard.php?Ineserted");
        }else if($row[0] == NULL){
            $nameerror = "<br /> Το ονομα δεν υπαρχει στην λιστα.";
        }else if($row[2] == NULL){
            $mailerror = "<br /> To mail δεν υπαρχει στην λιστα.";
        }else{
            echo "<script> alert('Δεν υπαρχει στην λιστα'); </script>";
        }
        
    }
}


mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <div class="navbar">
        <p><?php if(!isset($_SESSION['username']) && !isset($_SESSION['admin'])){
                                                        echo'Not logged in';
                                                    }else if(isset($_SESSION['username'])){
                                                        echo'Logged in as: ' ;
                                                        echo $_SESSION['username'];
                                                    }else if(isset($_SESSION['admin'])){
                                                        echo 'Admin:';
                                                        echo $_SESSION['admin'];
                                                    } ?></p>
        <a href="dashboard.php">Δηλώσεις</a>
        <a href="insert_page.php">Διαχειριστές</a>
        <a href="rooms_inspect.php">Δωμάτια</a>
        <a href="users.php">Χρήστες</a>                                             
    </div>

    <div class="main-content">
        <header>
            <h1>Μενού δηλώσεων</h1>
        </header>

        <h2>Προσθήκη δωματίου</h2>
            <form name="dashboard" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="insert">
                <label for="id">Id δωματίου:</labe><br>
                <input type="text" id="id" name="id" required><br>
                <span style="color: red;">  <?php echo $nameerror; ?> </span>

                <label for="name">Όνομα:</label><br>
                <input type="text" id="name" name="name" required><br>
                <span style="color: red;">  <?php echo $nameerror; ?> </span>
                
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" required><br>
                <span style="color: red;">  <?php echo $mailerror; ?> </span>

                <label for="area">Περιοχή</label><br>
                <select id="area" name="area">
                <option value="Λαγκάδα">Λαγκάδα</option>
                <option value="Θολάρια">Θολάρια</option>
                <option value="Αιγιάλη">Αιγιάλη</option>
                <option value="Κατάπολα">Κατάπολα</option>
                <option value="Αρκεσίνη">Αρκεσίνη</option>
                <option value="Άλλο">Άλλο</option>
                </select><br>
                
                <input type="submit" value="Προσθήκη" name = 'submit'>
            </form>



            <div class = "container">
            <h2>Εισερχόμενες δηλώσεις</h2>
                <table >
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Desc</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Link</th>
                            <th>Image</th>
                            <th>Area</th>
                            <th>ID</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="rooms-output">
                        <!-- More user rows go here -->
                    </tbody>                                
                </table>
                <script src = "fetchrooms.js"></script>
            </div>

    
</body>
</html>