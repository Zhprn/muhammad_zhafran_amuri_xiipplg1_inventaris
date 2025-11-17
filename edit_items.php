<?php
include 'koneksi.php';
$id = $_GET['id'] ?? '';
if ($id == '') {
    header("Location: index.php?page=items");
    exit;
}

$data = mysqli_query($koneksi, "SELECT * FROM items WHERE id_items='$id'");
$row = mysqli_fetch_assoc($data);

$kategori = mysqli_query($koneksi, "SELECT * FROM categories ORDER BY nama_kategori ASC");

if (isset($_POST['update'])) {

    $nama = $_POST['nama_barang'];
    $id_categories = $_POST['id_categories'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga_barang'];
    $tanggal = $_POST['tanggal_masuk'];

    $gambar_lama = $row['gambar'];
    $gambar_baru = $gambar_lama;

    if (!empty($_FILES['gambar']['name'])) {
        $file = $_FILES['gambar'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (in_array($ext, ['png', 'jpg', 'jpeg'])) {

            $filename = "items-" . time() . "-" . rand(100, 999) . "." . $ext;
            $path = "uploads/" . $filename;

            move_uploaded_file($file['tmp_name'], $path);

            if ($gambar_lama != '' && file_exists("uploads/" . $gambar_lama)) {
                unlink("uploads/" . $gambar_lama);
            }

            $gambar_baru = $filename;
        }
    }

    mysqli_query($koneksi, 
        "UPDATE items SET 
            id_categories='$id_categories',
            nama_barang='$nama',
            stok='$stok',
            harga_barang='$harga',
            tanggal_masuk='$tanggal',
            gambar='$gambar_baru'
        WHERE id_items='$id'"
    );

    header("Location: index.php?page=items");
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
                <input type="text" name="nama_barang" class="form-control"
                       value="<?= htmlspecialchars($row['nama_barang']) ?>" required>
            </div>

            <div class="mb-3">
                <label>Kategori Barang</label>
                <select name="id_categories" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    <?php while ($kat = mysqli_fetch_assoc($kategori)): ?>
                        <option value="<?= $kat['id_categories'] ?>"
                            <?= ($kat['id_categories'] == $row['id_categories']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($kat['nama_kategori']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Jumlah Stok</label>
                <input type="number" name="stok" class="form-control"
                       value="<?= $row['stok'] ?>" required>
            </div>

            <div class="mb-3">
                <label>Harga Barang</label>
                <input type="number" name="harga_barang" class="form-control"
                       value="<?= $row['harga_barang'] ?>" required>
            </div>

            <div class="mb-3">
                <label>Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control"
                       value="<?= $row['tanggal_masuk'] ?>" required>
            </div>

            <div class="mb-3">
                <label>Upload Gambar Baru (optional)</label>
                <input type="file" name="gambar" class="form-control" accept="image/*">
            </div>

            <button type="submit" name="update" class="btn btn-primary w-100">Simpan Perubahan</button>
            <a href="index.php?page=barang" class="btn btn-secondary w-100 mt-2">Kembali</a>

        </form>
    </div>
</div>

</body>
</html>
