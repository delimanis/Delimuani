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

// Cek apakah ID pengguna ada di URL
if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];
    
    // Ambil data pengguna berdasarkan ID
    $sql = "SELECT * FROM user WHERE userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        die("Pengguna tidak ditemukan!");
    }
} else {
    die("ID pengguna tidak ditemukan di URL");
}

// Proses update data jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Query untuk update data pengguna
    $sql = "UPDATE user SET username = ?, role = ? WHERE userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $role, $userID);
    
    if ($stmt->execute()) {
        header('Location: data_pengguna.php');
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
    <title>Edit Pengguna</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Pengguna</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($row['username']); ?>">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="admin" <?php if($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="petugas" <?php if($row['role'] == 'petugas') echo 'selected'; ?>>Petugas</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
        <a href="data_pengguna.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</body>
</html>
