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

// Cek apakah parameter PelangganID ada di URL
if (isset($_GET['PelangganID'])) {
    $PelangganID = $_GET['PelangganID'];

    // Query untuk menghapus produk berdasarkan PelangganID
    $sql = "DELETE FROM pelanggan WHERE PelangganID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $PelangganID);

    // Eksekusi query
    if ($stmt->execute()) {
        // Redirect ke halaman data_buku.php setelah sukses menghapus
        header('Location: data_pembeli.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "PelangganID tidak ditemukan di URL.";
}

// Tutup koneksi
$conn->close();
?>
