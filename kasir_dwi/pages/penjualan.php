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

// Query untuk mengambil data penjualan
$sql = "SELECT * FROM penjualan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjualan</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../asset/favicon-16x16.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="row">
        <?php include 'sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Data Penjualan</h1>
            </div>

            <div class="container mt-5">
                <a href="tambah_penjualan.php" class="btn btn-primary mb-3">Tambah Penjualan</a>
                <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Penjualan</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                            <th>Nama Pelanggan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['PenjualanID'] . "</td>";
                                echo "<td>" . $row['TanggalPenjualan'] . "</td>";
                                echo "<td>Rp " . number_format($row['TotalHarga'], 2, ',', '.') . "</td>";
                                echo "<td>" . $row['NamaPelanggan'] . "</td>";
                                echo "<td>
                                    <a href='detail_penjualan.php?id=" . $row['PenjualanID'] . "' class='btn btn-info btn-sm'>Detail</a>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Tidak ada data penjualan</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>

<?php
$conn->close();
?>
