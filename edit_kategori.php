<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? '';
if ($id == '') {
    header("Location: index.php?page=categories");
    exit;
}

$data = mysqli_query($koneksi, "SELECT * FROM categories WHERE id_categories='$id'");
$row = mysqli_fetch_assoc($data);

$kategori = mysqli_query($koneksi, "SELECT * FROM categories ORDER BY nama_kategori ASC");

if (isset($_POST['update'])) {

    $nama = $_POST['nama_kategori'];

    mysqli_query($koneksi, 
        "UPDATE categories SET 
            nama_kategori='$nama'
        WHERE id_categories='$id'"
    );

    echo "<script>alert('Succes Update Data Kategori'); window.location='index.php?page=categories';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body { 
            background-color: #f6f5ff; 
            font-family: 'Poppins', sans-serif; 
        }
        .btn-primary { 
            background-color: blueviolet; 
            border: none; 
        }
        .btn-primary:hover { 
            background-color: #6a0dad; 
        }
        .card { 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
            border: none; 
        }
        h3 { 
            color: blueviolet; 
        }
        img.preview { 
            width: 120px; 
            border-radius: 8px; 
            margin-bottom: 10px; 
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card p-4 col-lg-6 mx-auto">
        <h3 class="text-center mb-3">Edit Barang</h3>

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label>Nama Barang</label>
                <input type="text" name="nama_kategori" class="form-control"
                       value="<?= htmlspecialchars($row['nama_kategori']) ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary w-100">Simpan Perubahan</button>
            <a href="index.php?page=barang" class="btn btn-secondary w-100 mt-2">Kembali</a>

        </form>
    </div>
</div>

</body>
</html>
