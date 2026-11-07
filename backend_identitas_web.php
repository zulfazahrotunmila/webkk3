<?php
require_once 'koneksi_database.php';

header('Content-Type: application/json');

if (!isAdminLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Akses ditolak. Silakan login terlebih dahulu.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $schoolName = trim($_POST['school_name'] ?? '');
    $npsn = trim($_POST['npsn'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if (empty($schoolName) || empty($npsn) || empty($phone) || empty($email) || empty($address)) {
        echo json_encode(['success' => false, 'message' => 'Semua kolom identitas wajib diisi.']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE school_identity SET school_name = ?, npsn = ?, phone = ?, email = ?, address = ? WHERE id = 1");
    $stmt->execute([$schoolName, $npsn, $phone, $email, $address]);

    echo json_encode(['success' => true, 'message' => 'Identitas sekolah berhasil diperbarui!']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Metode request tidak valid.']);
exit;
?>