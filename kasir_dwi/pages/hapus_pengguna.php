<?php
session_start();

// Pastikan pengguna sudah login sebelum mengakses halaman ini
if (!isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "kasir_dwi");

// Periksa koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah userID ada di URL dan tidak kosong
if (!empty($_GET['userID'])) {
    $userID = intval($_GET['userID']); // Pastikan userID berupa angka untuk keamanan

    // Siapkan query SQL untuk menghapus pengguna
    $sql = "DELETE FROM user WHERE userID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $userID);
        
        if ($stmt->execute()) {
            // Redirect ke halaman data pengguna setelah berhasil menghapus
            header('Location: data_pengguna.php');
            exit();
        } else {
            echo "Error saat menghapus data: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Query tidak valid.";
    }
} else {
    echo "Error: userID tidak ditemukan di URL.";
}

// Tutup koneksi database
$conn->close();
?>
