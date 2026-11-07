<?php
require_once 'koneksi_database.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Username dan Password wajib diisi.']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Periksa apakah user ditemukan
    if ($user) {
        $isValid = false;

        // Cek jika password di database masih teks biasa (plain text) ATAU sudah di-hash
        if ($password === $user['password']) {
            $isValid = true;
            // Opsional: Otomatis ubah password plain text di DB menjadi secure hash agar aman
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $updateStmt->execute([$newHash, $user['id']]);
        } elseif (password_verify($password, $user['password'])) {
            $isValid = true;
        }

        if ($isValid) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['name'];

            echo json_encode(['success' => true, 'message' => 'Login Admin Berhasil!']);
            exit;
        }
    }

    echo json_encode(['success' => false, 'message' => 'Username atau Password salah. (Default: admin / admin123)']);
    exit;
}

if ($action === 'logout') {
    unset($_SESSION['admin_logged_in']);
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_name']);
    session_destroy();

    header('Location: index.php');
    exit;
}

echo json_encode(['success' => false, 'message' => 'Aksi tidak valid.']);
exit;
?>