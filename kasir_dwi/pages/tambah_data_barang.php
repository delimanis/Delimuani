<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "kasir_dwi");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    
    // Insert data produk ke database
    $sql = "INSERT INTO produk (NamaProduk, Stok, Harga) VALUES ('$nama_produk', '$stok', '$harga')";
    
    if ($koneksi->query($sql) === TRUE) {
        header('Location: data_barang.php');
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="icon" href="../asset/favicon-16x16.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Tambah Produk</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
        </div>
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Produk</button>
    </form>
</div>

</body>
</html>
