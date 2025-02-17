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

// Cek apakah ID pelanggan ada di URL
if (isset($_GET['PelangganID'])) {
    $id_pelanggan = $_GET['PelangganID'];
    
    // Ambil data pelanggan berdasarkan ID
    $sql = "SELECT * FROM pelanggan WHERE PelangganID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_pelanggan);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        die("Pelanggan tidak ditemukan!");
    }
} else {
    die("ID pelanggan tidak ditemukan di URL");
}

// Proses update data jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pelanggan = $_POST['NamaPelanggan'];
    $alamat = $_POST['Alamat'];
    $nomor_telepon = $_POST['NomorTelepon'];

    // Query untuk update data pelanggan
    $sql = "UPDATE pelanggan SET NamaPelanggan = ?, Alamat = ?, NomorTelepon = ? WHERE PelangganID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nama_pelanggan, $alamat, $nomor_telepon, $id_pelanggan);
    
    if ($stmt->execute()) {
        header('Location: data_pembeli.php');
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
    <title>Edit Pelanggan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Pelanggan</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="NamaPelanggan" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control" id="NamaPelanggan" name="NamaPelanggan" value="<?php echo htmlspecialchars($row['NamaPelanggan']); ?>">
            </div>
            <div class="mb-3">
                <label for="Alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="Alamat" name="Alamat" value="<?php echo htmlspecialchars($row['Alamat']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="NomorTelepon" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="NomorTelepon" name="NomorTelepon" value="<?php echo htmlspecialchars($row['NomorTelepon']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
        <a href="data_pelanggan.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</body>
</html>
