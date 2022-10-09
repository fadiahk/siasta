<?php
$koneksi = mysqli_connect("localhost", "root", "", "siasta");

if (mysqli_connect_error()) {
    echo "koneksi database gagal" . mysqli_connect();
}

if (isset($_POST['regis'])) {
    $nama = $_POST["nama_lengkap"];
    $user = $_POST["username"];
    $pass = $_POST["password"];
    $level = $_POST["level"];

    $query = "INSERT INTO user (nama_lengkap, username, password, level) values ('$nama','$user','$pass','$level')";

    if(mysqli_query($koneksi, $query)) {
        echo "<br><br><h1>Username $user berhasil terdaftar</h1>
        <a href='login.php'><h1>Kembali Login</h1>";
    } else {
        echo "Pendaftaran Gagal : " . mysqli_error($koneksi);
    }
}
