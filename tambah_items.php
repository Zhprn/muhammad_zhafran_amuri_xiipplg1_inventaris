<?php
include 'koneksi.php';
    
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['id_categories'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga_barang'];
    $tanggal = $_POST['tanggal_masuk'];

    $gambar = "";
    if (!empty($_FILES['gambar']['name'])) {
        $filename = $_FILES['gambar']['name'];
        $tmpname = $_FILES['gambar']['tmp_name'];

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $newName = "items-" . time() . "-" . rand(100,999) . "." . $ext;

        if (!is_dir("uploads")) {
            mkdir("uploads");
        }

        move_uploaded_file($tmpname, "uploads/" . $newName);
        $gambar = $newName;
    }

    if ($stok <0 || $harga < 0) {
        echo "<script>alert('Jumlah stok dan harga harus lebih dari 0'); window.location='tambah.php';</script>";
        exit;
    }
    mysqli_query($koneksi,"INSERT INTO items (id_categories, nama_barang, stok, harga_barang, tanggal_masuk, gambar)
        VALUES ('$kategori', '$nama', '$stok', '$harga', '$tanggal', '$gambar')"
    );

    header("Location: index.php?page=items");
    exit;
}

$daftar_kategori = mysqli_query($koneksi, "SELECT * FROM categories ORDER BY nama_kategori ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <style>
        body { 
            background-color: #f6f5ff; 
            font-family: 'Poppins', sans-serif; 
        }
        .btn-primary { 
            background-color: blueviolet; 
        }
        .btn-primary:hover { 
            background-color: #6a0dad; 
        }
        .card { 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
        }
        h3 { 
            color: blueviolet; 
        }
        .form-label { 
            font-weight: 500; 
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card p-4 col-lg-6 mx-auto border-0">
        <h3 class="text-center mb-3">Tambah Barang</h3>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori Barang</label>
                <select name="id_categories" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    <?php while ($row = mysqli_fetch_assoc($daftar_kategori)): ?>
                        <option value="<?= $row['id_categories'] ?>">
                            <?= htmlspecialchars($row['nama_kategori']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Stok</label>
                <input type="number" name="stok" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga Barang</label>
                <input type="number" name="harga_barang" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Gambar</label>
                <input type="file" name="gambar" class="form-control" accept="image/*">
            </div>

            <button type="submit" name="simpan" class="btn btn-primary w-100 border-0">Simpan</button>
        </form>

    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
