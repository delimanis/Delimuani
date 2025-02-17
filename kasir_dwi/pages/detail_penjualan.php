<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "kasir_dwi");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID penjualan dari parameter URL
if (!isset($_GET['PenjualanID'])) {
    echo "Penjualan tidak ditemukan.";
    exit();
}
$PenjualanID = intval($_GET['PenjualanID']);

// Query untuk mengambil detail penjualan
$sql = "SELECT PenjualanID, TanggalPenjualan, TotalHarga, PelangganID FROM penjualan WHERE PenjualanID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $PenjualanID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Detail Penjualan</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>PenjualanID</th>
                    <th>Tanggal Penjualan</th>
                    <th>Total Harga</th>
                    <th>PelangganID</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['PenjualanID']; ?></td>
                        <td><?php echo $row['TanggalPenjualan']; ?></td>
                        <td>Rp <?php echo number_format($row['TotalHarga'], 2, ',', '.'); ?></td>
                        <td><?php echo $row['PelangganID']; ?></td>
                    </tr>
                <?php } else { ?>
                    <tr><td colspan="4">Tidak ada data penjualan</td></tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="data_pelanggan.php" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
