<!-- LIST TODO
. buat submit berfungsi
. how to stay login selama nggak keluar tab
. -->
<!-- CATATAN : checkbox kuhapus, ga ada term of condition kita :v 
terus email juga ga ada, jadi fitur konfirmasi, lupa, reset juga 
ga bisa... (aku hapus file lupa dan reset juga)-->
<?php
include("../Config/db.php");
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['newaccount'])) {
    // Retrieve form data
    $username = $_POST['name'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    // Check if passwords match
    if ($password !== $password2) {
        echo "Passwords do not match";
    } else {
         
         $sql = "INSERT INTO akunlaundry (username, password) VALUES ('$username', '$hashed_password')";
    }

    if ($conn->query($sql) === TRUE) {
        // Account creation successful, start a session
        // session_start();
        // Store user information in session variables
        // $_SESSION['username'] = $username;
        // Redirect or perform other actions after successful account creation
        header("Location: masuk.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buat Akun</title>
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
    <!-- register start -->
    <form action="" method="post" class="newaccount" novalidate="">
        <div class="container2">
            <h2>Buat akun</h2>
            <div class="form-group">
                <label for="name"><b>Nama Pengguna</b></label>
                <input id="name" type="text" class="form-control" name="name" required autofocus placeholder="Masukkan Pengguna">
            </div>
            <div class="form-group">
                <label for="password"><b>Kata sandi</b></label>
                <input id="password" type="password" class="form-control" name="password" required data-eye placeholder="Kata sandi (terdiri dari huruf dan angka)">
            </div>
            <div class="form-group">
                <label for="password2"><b>Ulangi kata sandi</b></label>
                <input id="password2" type="password" class="form-control" name="password2" required data-eye placeholder="Masukkan ulang kata sandi">
            </div>
            <button class="newaccount" type="submit" name="newaccount" value="Buat">Buat</button>
            <div class="mt-4 text-center">
                Sudah punya akun?<a href="masuk.php"> Masuk</a>
            </div>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/my-login.js"></script>
    <!-- register end -->
</body>