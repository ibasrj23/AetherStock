<?php
require 'includes/session.php';
require 'includes/db.php';

$message = '';
$message_type = '';

// Ambil data transaksi
$query = "SELECT t.*, p.name, p.price FROM transaksi t 
          JOIN products p ON t.id_barang = p.id 
          WHERE p.user_id = ? 
          ORDER BY t.tanggal_transaksi DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$transaksi_list = [];

while ($row = $result->fetch_assoc()) {
    $transaksi_list[] = $row;
}

$stmt->close();

// Hitung statistik
$total_masuk = 0;
$total_keluar = 0;

foreach ($transaksi_list as $t) {
    if ($t['jenis_transaksi'] == 'masuk') {
        $total_masuk += $t['jumlah_barang'];
    } else {
        $total_keluar += $t['jumlah_barang'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Product Management</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .transaction-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .transaction-header h2 {
            color: #333;
            font-size: 28px;
        }

        .back-btn {
            padding: 10px 20px;
            background-color: var(--text-light);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
        }

        .back-btn:hover {
            background-color: var(--text);
            transform: translateY(-2px);
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            color: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            border-left: 4px solid;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card.masuk {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-left-color: #f0fdf4;
        }

        .stat-card.keluar {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border-left-color: #fef2f2;
        }

        .stat-card:not(.masuk):not(.keluar) {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-left-color: #e0e7ff;
        }

        .stat-card h4 {
            margin: 0;
            font-size: 14px;
            opacity: 0.95;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .stat-card .number {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }

        .stat-card.masuk {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        }

        .stat-card.keluar {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }

        .table-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            overflow-x: auto;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .table-container thead {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 2px solid var(--border);
        }

        .table-container th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-container td {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            color: var(--text);
            font-size: 14px;
        }

        .table-container tbody tr:hover {
            background-color: var(--light-2);
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge.masuk {
            background: #f0fdf4;
            color: #166534;
        }

        .badge.keluar {
            background: #fef2f2;
            color: #991b1b;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
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
                <a href="profile.php" class="btn btn-primary">👤 Profil</a>
                <a href="change_password.php" class="btn btn-info">🔐 Ubah Password</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="transaction-header">
            <h2>📊 Riwayat Transaksi</h2>
            <a href="index.php" class="back-btn">← Kembali ke Dashboard</a>
        </div>

        <div class="stats-row">
            <div class="stat-card masuk">
                <h4>Total Barang Masuk</h4>
                <p class="number"><?php echo $total_masuk; ?></p>
            </div>
            <div class="stat-card keluar">
                <h4>Total Barang Keluar</h4>
                <p class="number"><?php echo $total_keluar; ?></p>
            </div>
            <div class="stat-card">
                <h4>Total Transaksi</h4>
                <p class="number"><?php echo count($transaksi_list); ?></p>
            </div>
        </div>

        <?php if (empty($transaksi_list)): ?>
            <div class="table-container">
                <div class="no-data">
                    <p>Belum ada riwayat transaksi</p>
                </div>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jenis Transaksi</th>
                            <th>Jumlah</th>
                            <th>Harga/Unit</th>
                            <th>Total Nilai</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksi_list as $index => $t): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($t['name']); ?></td>
                                <td>
                                    <span class="badge <?php echo $t['jenis_transaksi']; ?>">
                                        <?php echo ucfirst($t['jenis_transaksi']); ?>
                                    </span>
                                </td>
                                <td><?php echo $t['jumlah_barang']; ?> unit</td>
                                <td>Rp <?php echo number_format($t['price'], 0, ',', '.'); ?></td>
                                <td>Rp <?php echo number_format($t['price'] * $t['jumlah_barang'], 0, ',', '.'); ?></td>
                                <td><?php echo date('d-m-Y H:i', strtotime($t['tanggal_transaksi'])); ?></td>
                                <td><?php echo htmlspecialchars($t['keterangan'] ?? '-'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
