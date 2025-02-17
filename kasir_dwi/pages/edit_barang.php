<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "kasir_dwi");

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah ID produk ada di URL
if (isset($_GET['id_produk'])) {
    $id_produk = $_GET['id_produk'];
    
    // Ambil data produk berdasarkan ID
    $sql = "SELECT * FROM produk WHERE ProdukID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        die("Produk tidak ditemukan!");
    }
} else {
    die("ID produk tidak ditemukan di URL");
}

// Proses update data jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['NamaProduk'];
    $stok = $_POST['Stok'];
    $harga = $_POST['Harga'];

    // Query untuk update data produk
    $sql = "UPDATE produk SET NamaProduk = ?, Stok = ?, Harga = ? WHERE ProdukID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siii", $nama_barang, $stok, $harga, $id_produk);
    
    if ($stmt->execute()) {
        header('Location: data_barang.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Produk</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="NamaProduk" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="NamaProduk" name="NamaProduk" value="<?php echo htmlspecialchars($row['NamaProduk']); ?>">
            </div>
            <div class="mb-3">
                <label for="Stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="Stok" name="Stok" value="<?php echo htmlspecialchars($row['Stok']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="Harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="Harga" name="Harga" value="<?php echo htmlspecialchars($row['Harga']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
        <a href="data_produk.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</body>
</html>