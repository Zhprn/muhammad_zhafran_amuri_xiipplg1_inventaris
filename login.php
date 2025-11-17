<?php
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {
    $nama_users = $_POST['nama_users'];
    $password_users = $_POST['password_users'];

    $result = $koneksi->query("SELECT * FROM users WHERE nama_users='$nama_users' AND password_users='$password_users'");

    if ($result->num_rows > 0) {
        $_SESSION['login'] = true;
        $_SESSION['nama_users'] = $nama_users;
        header("Location: index.php");
        exit;
    } else {
        $error = "Username Atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin</title>
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: #f3f4f6;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
  .container {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 360px;
  }
  h2 {
    text-align: center;
    color: #333;
    margin-bottom: 25px;
  }
  label {
    display: block;
    margin-bottom: 5px;
    color: #444;
  }
  input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 15px;
  }
  button {
    width: 100%;
    padding: 10px;
    background-color: blueviolet;
    border: none;
    color: #fff;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
  }
  button:hover {
    opacity: 0.8;
  }
  .error {
    color: red;
    text-align: center;
    margin-bottom: 10px;
  }
</style>
</head>
<body>
  <div class="container">
    <h2>Login Admin</h2>
    <form method="POST">
      <label>Username</label>
      <input type="text" name="nama_users" placeholder="Masukkan Username" required>
      <label>Password</label>
      <input type="password_users" name="password_users" placeholder="Masukkan Password" required>
      <button type="submit" name="login">Login</button>
    </form>
  </div>
</body>
</html>
