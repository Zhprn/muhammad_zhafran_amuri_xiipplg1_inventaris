<?php
include 'koneksi.php';

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$page = $_GET['page'] ?? 'items';
$search = $_GET['search'] ?? '';
$filter_categories = $_GET['filter_categories'] ?? '';
$halaman = 5;
$posisi = 0;

if ($page === 'items') {
    if (isset($_GET['hapus'])) {
        $id_hapus = $_GET['hapus'];
        mysqli_query($koneksi, "DELETE FROM items WHERE id_items='$id_hapus'");
        header("Location: index.php?page=items");
        exit;
    }

    $hal = $_GET['hal'] ?? 1;
    $posisi = ($hal - 1) * $halaman;

    $where = [];
    if ($search !== "")
        $where[] = "items.nama_barang LIKE '%$search%'";
    if ($filter_categories !== "")
        $where[] = "items.id_categories='$filter_categories'";

    $query = "
        SELECT items.*, categories.nama_kategori 
        FROM items
        JOIN categories ON items.id_categories = categories.id_categories
    ";

    if (!empty($where))
        $query .= " WHERE " . implode(" AND ", $where);

    $query_page = $query . " ORDER BY items.id_items DESC LIMIT $posisi, $halaman";
    $result = mysqli_query($koneksi, $query_page);

    $daftar_kategori = mysqli_query($koneksi, "SELECT * FROM categories ORDER BY nama_kategori ASC");

    $count_total = mysqli_num_rows(mysqli_query($koneksi, $query));
    $total_halaman = ceil($count_total / $halaman);
}

if ($page === 'categories') {
    $daftar_kategori = mysqli_query($koneksi, "SELECT * FROM categories ORDER BY id_categories DESC");

    if (isset($_GET['hapus'])) {
        $id_hapus = $_GET['hapus'];
        mysqli_query($koneksi, "DELETE FROM categories WHERE id_categories='$id_hapus'");
        header("Location: index.php?page=categories");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Inventaris</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <style>
        body {
            background-color: #f6f5ff;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: blueviolet;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            transition: 0.3s;
            z-index: 1050;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: white;
            margin: 5px 10px;
            border-radius: 6px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background-color: #6a0dad;
        }

        .main-content {
            margin-left: 260px;
            padding: 20px;
            transition: 0.3s;
        }

        .navbar-brand {
            font-weight: 600;
            color: blueviolet !important;
        }

        .btn-primary {
            background-color: blueviolet !important;
            border: none;
        }

        .btn-primary:hover {
            background-color: #6a0dad !important;
        }

        .table thead {
            background: blueviolet;
            color: white;
        }

        .card {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .toggle-btn {
            border: none;
            background: none;
            font-size: 1.5rem;
            color: blueviolet;
        }

        img.thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }

        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar" id="sidebar">
        <h4 class="text-center mt-3 mb-4">INVENTARIS</h4>
        <a href="index.php?page=items" class="<?= $page === 'items' ? 'active' : '' ?>">items</a>
        <a href="index.php?page=categories" class="<?= $page === 'categories' ? 'active' : '' ?>">categories</a>
    </div>

    <div class="main-content" id="main">
        <nav class="navbar bg-white shadow-sm rounded px-3 mb-4 d-flex justify-content-between align-items-center">
            <button id="menu-toggle" class="toggle-btn d-lg-none">&#9776;</button>
            <span class="navbar-brand h5 mb-0">Dashboard Admin</span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </nav>

        <?php if ($page === 'items'): ?>
            <div class="card p-4">
                <h4 class="mb-4">Data items</h4>
                <form method="GET" class="mb-4">
                    <input type="hidden" name="page" value="items">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label">Cari Nama Barang</label>
                            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Filter Kategori</label>
                            <select name="filter_categories" class="form-control">
                                <option value="">Semua Kategori</option>
                                <?php while ($kat = mysqli_fetch_assoc($daftar_kategori)): ?>
                                    <option value="<?= $kat['id_categories'] ?>" <?= $filter_categories == $kat['id_categories'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($kat['nama_kategori']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button class="btn btn-secondary w-50">Terapkan</button>
                            <a href="index.php?page=items" class="btn btn-outline-secondary w-50">Reset</a>
                        </div>
                    </div>
                </form>
                <a href="tambah_items.php" class="btn btn-primary mb-3">+ Tambah items</a>
                <a href="printPdf.php" target="_blank" class="btn-success btn w-100 mb-3">Print PDF</a>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>categories</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Tanggal Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php $no = $posisi + 1; ?>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <?php if ($row['gambar']): ?>
                                                <img src="uploads/<?= $row['gambar'] ?>" class="thumb">
                                            <?php else: ?>
                                                Tidak Ada Gambar
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                                        <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                                        <td><?= $row['stok'] ?></td>
                                        <td>Rp <?= number_format($row['harga_barang'], 0, ',', '.') ?></td>
                                        <td><?= $row['tanggal_masuk'] ?></td>
                                        <td>
                                            <a href="edit_items.php?id=<?= $row['id_items'] ?>"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <a href="index.php?page=items&hapus=<?= $row['id_items'] ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">Tidak ada data.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <nav>
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
                            <li class="page-item <?= ($i == $hal) ? 'active' : '' ?>">
                                <a class="page-link"
                                    href="?page=items&hal=<?= $i ?>&search=<?= $search ?>&filter_categories=<?= $filter_categories ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>

        <?php elseif ($page === 'categories'): ?>
            <div class="card p-4">
                <h4 class="mb-4">Data Kategori</h4>
                <a href="tambah_kategori.php" class="btn btn-primary mb-3">+ Tambah Kategori</a>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = $posisi + 1; ?>
                            <?php if (mysqli_num_rows($daftar_kategori) > 0): ?>
                                <?php while ($kat = mysqli_fetch_assoc($daftar_kategori)): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $kat['nama_kategori']; ?></td>
                                        <td>
                                            <a href="edit_kategori.php?id=<?= $kat['id_categories'] ?>"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <a href="index.php?page=categories&hapus=<?= $kat['id_categories'] ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus kategori ini?')">Hapus</a>

                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3">Belum ada kategori.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('menu-toggle').onclick = () => {
            document.getElementById('sidebar').classList.toggle('show');
        };
    </script>

</body>

</html>