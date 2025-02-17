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

// Cek apakah parameter ProdukID ada di URL
if (isset($_GET['ProdukID'])) {
    $ProdukID = $_GET['ProdukID'];

    // Query untuk menghapus produk berdasarkan ProdukID
    $sql = "DELETE FROM produk WHERE ProdukID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ProdukID);

    // Eksekusi query
    if ($stmt->execute()) {
        // Redirect ke halaman data_buku.php setelah sukses menghapus
        header('Location: data_barang.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "ProdukID tidak ditemukan di URL.";
}

// Tutup koneksi
$conn->close();
?>
