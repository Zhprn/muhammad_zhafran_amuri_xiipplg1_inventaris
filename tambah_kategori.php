<?php 
include ("koneksi.php");

if(isset($_POST['simpan'])) {
    $nama_kategori = $_POST['nama_kategori'];

    mysqli_query($koneksi, "INSERT INTO categories(nama_kategori) VALUES ('$nama_kategori')");

    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<style>
    body { 
        background-color: #f6f5ff; 
        font-family: 'Poppins', sans-serif; 
    }

    .btn {
        background-color: blueviolet;
    }

    .btn:hover {
        background-color: #6a0dad; 
    }
    .form-label {
        color: blueviolet;
    }
</style>
<body>
    <div class="container mt-5">
        <div class="card p-4 col-lg-6 mx-auto border-0">
            <h3 class="mb-3 text-center form-label">Tambah Kategori</h3>
            <form method="POST" class="form">
                <div class="mb-3">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control">
                </div>
                <button class="btn text-white w-100" action="submit" name="simpan">Submit</button>
            </form>
        </div>
    </div>
</body>
<script src="js/bootstrap.min.js"></script>
</html>