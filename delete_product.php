<?php
require 'includes/session.php';
require 'includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id === 0) {
    header("Location: index.php");
    exit();
}

// Verifikasi produk milik user
$query = "SELECT id FROM products WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit();
}

$stmt->close();

// Hapus produk
$query = "DELETE FROM products WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id, $_SESSION['user_id']);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: index.php?deleted=1");
    exit();
} else {
    $stmt->close();
    $conn->close();
    header("Location: index.php?error=1");
    exit();
}
?>
