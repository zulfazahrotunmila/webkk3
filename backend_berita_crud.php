<?php
require_once 'koneksi_database.php';

header('Content-Type: application/json');
$action = $_GET['action'] ?? 'read';

// 1. READ NEWS (Dapat diakses Publik)
if ($action === 'read') {
    $search = $_GET['q'] ?? '';
    if (!empty($search)) {
        $stmt = $pdo->prepare("SELECT * FROM news WHERE title LIKE ? OR content LIKE ? OR category LIKE ? ORDER BY id DESC");
        $searchTerm = "%$search%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
    } else {
        $stmt = $pdo->query("SELECT * FROM news ORDER BY id DESC");
    }
    $newsList = $stmt->fetchAll();

    foreach ($newsList as &$news) {
        $news['formatted_date'] = formatDateIndo($news['created_at']);
    }

    echo json_encode(['success' => true, 'data' => $newsList]);
    exit;
}

// 2. FETCH SINGLE NEWS
if ($action === 'get') {
    $id = (int)($_GET['id'] ?? 0);
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$id]);
    $news = $stmt->fetch();

    if ($news) {
        $news['formatted_date'] = formatDateIndo($news['created_at']);
        echo json_encode(['success' => true, 'data' => $news]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Berita tidak ditemukan.']);
    }
    exit;
}

// Proteksi Fitur CUD (Harus Admin)
if (!isAdminLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Akses ditolak. Sesi admin telah berakhir.']);
    exit;
}

// 3. CREATE & UPDATE NEWS
if ($action === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $imageUrl = trim($_POST['image_url'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (empty($title) || empty($category) || empty($content)) {
        echo json_encode(['success' => false, 'message' => 'Judul, Kategori, dan Isi Berita wajib diisi.']);
        exit;
    }

    if (!empty($id)) {
        // Update
        $stmt = $pdo->prepare("UPDATE news SET title = ?, category = ?, image_url = ?, content = ? WHERE id = ?");
        $stmt->execute([$title, $category, $imageUrl, $content, $id]);
        echo json_encode(['success' => true, 'message' => 'Berita berhasil diperbarui!']);
    } else {
        // Create
        $stmt = $pdo->prepare("INSERT INTO news (title, category, image_url, content) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $category, $imageUrl, $content]);
        echo json_encode(['success' => true, 'message' => 'Berita baru berhasil ditambahkan!']);
    }
    exit;
}

// 4. DELETE NEWS
if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Berita berhasil dihapus.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'ID Berita tidak valid.']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Aksi tidak dikenal.']);
exit;
?>