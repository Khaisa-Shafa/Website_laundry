<!-- LIST TODO
. koneksikan database
. buat submit berfungsi bisa masuk ke database
. how to stay login selama nggak keluar tab
. -->

<?php
include("../Config/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $username = $_POST['name'];
    $password = $_POST['password'];

    if ($conn) {
        $sql = "SELECT * FROM akunlaundry WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $passwordrow = $row['password'];

                if ($password = $passwordrow) {
                    session_start();
                    $_SESSION['username'] = $username;
                    header("Location: ../index.php");
                    exit();
                } else {
                    die ("Incorrect username or password"); 
                }
            } else {
                die("User does not exist"); 
            }
        } else {
            echo "Error executing the query"; 
        }
    } else {
        echo "Failed to connect to the database"; 
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Masuk</title>
    <link rel="stylesheet" href="../Styling/masuk.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rokkitt:ital,wght@0,100;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  </head>
  <body> 
    <!-- navbar start -->
    <nav class="position-fixed z-1 start-0 end-0 navbar navbar-expand-lg ">
      <div class="container">
            <a class="navbar-brand" href="#">LAUNDRY</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
      </div>
    </nav>
    <!-- navbar end -->
    <!-- login start -->
    <form action="" method="post" class="newaccount" novalidate="">
        <div class="container2">
            <h2>Masuk akun</h2>

            <div class="form-group">
                <label for="name"><b>Nama Pengguna</b></label>
                <input id="name" type="text" class="form-control" name="name" required autofocus placeholder="Masukkan Nama Pengguna">
            </div>
            <div class="form-group">
                <label for="password"><b>Kata sandi</b></label>
                <input id="password" type="password" class="form-control" name="password" required data-eye placeholder="Kata sandi (terdiri dari huruf dan angka)">
            </div>
                
            <button class="newaccount" type="submit" name="login" value="Masuk">Masuk</button>
            
            <div class="mt-4 text-center">
                Belum punya akun?<a href="buat.php"> Buat</a>
            </div>
        </div>
    </form>
    <!-- login end -->
</body>