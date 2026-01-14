<?php
require 'includes/session.php';
require 'includes/db.php';

// Ambil info user
$query = "SELECT id, username, email, created_at FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Ambil statistik user
$products_query = "SELECT COUNT(*) as total FROM products WHERE user_id = ?";
$stmt = $conn->prepare($products_query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$products_result = $stmt->get_result();
$products_count = $products_result->fetch_assoc();
$stmt->close();

$transaksi_query = "SELECT COUNT(*) as total FROM transaksi t JOIN products p ON t.id_barang = p.id WHERE p.user_id = ?";
$stmt = $conn->prepare($transaksi_query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$transaksi_result = $stmt->get_result();
$transaksi_count = $transaksi_result->fetch_assoc();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - Product Management</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .profile-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .profile-header {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            padding: 40px 32px;
            border-radius: 12px;
            margin-bottom: 32px;
            text-align: center;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 48px;
            font-weight: 700;
            color: var(--primary);
        }

        .profile-header h1 {
            font-size: 28px;
            margin: 0 0 8px 0;
            font-weight: 700;
        }

        .profile-header p {
            margin: 0;
            font-size: 14px;
            opacity: 0.95;
        }

        .profile-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .profile-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            border-left: 4px solid var(--primary);
        }

        .profile-card h3 {
            color: var(--dark);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .profile-card .value {
            font-size: 28px;
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .profile-card p {
            margin: 0;
            color: var(--text-light);
            font-size: 13px;
        }

        .profile-details {
            background: white;
            padding: 32px;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            margin-bottom: 32px;
        }

        .profile-details h2 {
            color: var(--dark);
            font-size: 20px;
            margin-bottom: 24px;
            font-weight: 700;
            border-bottom: 2px solid var(--border);
            padding-bottom: 16px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: var(--text-light);
            font-weight: 600;
            font-size: 14px;
        }

        .detail-value {
            color: var(--dark);
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .action-buttons .btn {
            flex: 1;
            min-width: 200px;
        }

        @media (max-width: 768px) {
            .profile-header {
                padding: 32px 20px;
            }

            .profile-details {
                padding: 20px;
            }

            .detail-row {
                flex-direction: column;
                gap: 8px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <h1>📦 Product Manager</h1>
            </div>
            <div class="navbar-menu">
                <span class="user-info">Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar"><?php echo strtoupper(substr($user['username'], 0, 1)); ?></div>
                <h1><?php echo htmlspecialchars($user['username']); ?></h1>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
            </div>

            <div class="profile-content">
                <div class="profile-card">
                    <h3>Total Produk</h3>
                    <div class="value"><?php echo $products_count['total']; ?></div>
                    <p>Produk yang Anda kelola</p>
                </div>
                <div class="profile-card">
                    <h3>Total Transaksi</h3>
                    <div class="value"><?php echo $transaksi_count['total']; ?></div>
                    <p>Riwayat masuk/keluar stok</p>
                </div>
                <div class="profile-card">
                    <h3>Status Akun</h3>
                    <div class="value">✓ Aktif</div>
                    <p>Akun Anda sedang aktif</p>
                </div>
            </div>

            <div class="profile-details">
                <h2>Informasi Akun</h2>
                <div class="detail-row">
                    <span class="detail-label">Username</span>
                    <span class="detail-value"><?php echo htmlspecialchars($user['username']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email</span>
                    <span class="detail-value"><?php echo htmlspecialchars($user['email']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Pendaftaran</span>
                    <span class="detail-value"><?php echo date('d-m-Y H:i', strtotime($user['created_at'])); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">ID Pengguna</span>
                    <span class="detail-value">#<?php echo $user['id']; ?></span>
                </div>
            </div>

            <div class="action-buttons">
                <a href="change_password.php" class="btn btn-info">🔐 Ubah Password</a>
                <a href="index.php" class="btn btn-primary">📦 Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
