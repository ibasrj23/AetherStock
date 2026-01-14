<?php
/**
 * Setup Script untuk Auto Create Database
 * Akses: http://localhost:8000/setup.php
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'aetherstock';

$error = '';
$success = '';
$setup_done = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update config jika form diisi
    if (!empty($_POST['db_host'])) {
        $db_host = trim($_POST['db_host']);
        $db_user = trim($_POST['db_user']);
        $db_pass = trim($_POST['db_pass']);
        $db_name = trim($_POST['db_name']);
    }
    
    // Buat koneksi ke MySQL
    $conn = new mysqli($db_host, $db_user, $db_pass);
    
    if ($conn->connect_error) {
        $error = "Connection failed: " . $conn->connect_error;
    } else {
        // Create database
        $sql = "CREATE DATABASE IF NOT EXISTS `$db_name`";
        if ($conn->query($sql) === TRUE) {
            // Select database
            $conn->select_db($db_name);
            
            // Create users table
            $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) NOT NULL UNIQUE,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            
            if ($conn->query($sql) !== TRUE) {
                $error = "Error creating users table: " . $conn->error;
            }
            
            // Create products table
            $sql = "CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                description TEXT,
                price DECIMAL(10, 2) NOT NULL,
                quantity INT NOT NULL,
                user_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )";
            
            if ($conn->query($sql) !== TRUE) {
                $error = "Error creating products table: " . $conn->error;
            }
            
            // Check if user already exists
            $check_user = $conn->query("SELECT * FROM users WHERE username = 'user1'");
            
            if ($check_user->num_rows === 0) {
                // Hash password: password123
                $hashed_pwd = password_hash('password123', PASSWORD_BCRYPT);
                $sql = "INSERT INTO users (username, email, password) VALUES ('user1', 'user1@example.com', '$hashed_pwd')";
                
                if ($conn->query($sql) !== TRUE) {
                    $error = "Error inserting user: " . $conn->error;
                } else {
                    $success = "✅ Database dan tabel berhasil dibuat!";
                    $success .= "<br>✅ User demo berhasil ditambahkan!";
                    $success .= "<br><br><strong>Kredensial Login:</strong>";
                    $success .= "<br>Username: user1";
                    $success .= "<br>Password: password123";
                    $setup_done = true;
                }
            } else {
                $success = "✅ Database dan tabel sudah ada!";
                $success .= "<br><strong>Kredensial Login:</strong>";
                $success .= "<br>Username: user1";
                $success .= "<br>Password: password123";
                $setup_done = true;
            }
        } else {
            $error = "Error creating database: " . $conn->error;
        }
        
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup - Product Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .setup-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 40px;
            max-width: 500px;
            width: 100%;
        }
        
        h1 {
            color: #3498db;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .subtitle {
            text-align: center;
            color: #7f8c8d;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
            font-size: 14px;
        }
        
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #bdc3c7;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
        }
        
        input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        button:hover {
            background: #2980b9;
        }
        
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .alert-success {
            background: #d5f4e6;
            color: #27ae60;
            border-left: 4px solid #2ecc71;
        }
        
        .alert-danger {
            background: #fadbd8;
            color: #c0392b;
            border-left: 4px solid #e74c3c;
        }
        
        .info-box {
            background: #ecf0f1;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 13px;
            line-height: 1.6;
        }
        
        .info-box strong {
            color: #3498db;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        a {
            display: inline-block;
            padding: 10px 15px;
            background: #95a5a6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            text-align: center;
            flex: 1;
            transition: background 0.3s ease;
        }
        
        a:hover {
            background: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <h1>🔧 Setup Database</h1>
        <p class="subtitle">Product Management System</p>
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
            
            <div class="info-box">
                <strong>✅ Setup Berhasil!</strong><br>
                Database dan tabel telah dibuat.<br>
                Anda siap untuk login.
            </div>
            
            <div class="action-buttons">
                <a href="login.php">🔐 Login</a>
                <a href="index.php">📊 Dashboard</a>
            </div>
        <?php else: ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    ❌ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="db_host">Database Host</label>
                    <input type="text" id="db_host" name="db_host" value="<?php echo $db_host; ?>" 
                           placeholder="localhost">
                </div>
                
                <div class="form-group">
                    <label for="db_user">Database User</label>
                    <input type="text" id="db_user" name="db_user" value="<?php echo $db_user; ?>" 
                           placeholder="root">
                </div>
                
                <div class="form-group">
                    <label for="db_pass">Database Password</label>
                    <input type="password" id="db_pass" name="db_pass" value="<?php echo $db_pass; ?>" 
                           placeholder="(kosongkan jika tidak ada)">
                </div>
                
                <div class="form-group">
                    <label for="db_name">Database Name</label>
                    <input type="text" id="db_name" name="db_name" value="<?php echo $db_name; ?>" 
                           placeholder="product_crud">
                </div>
                
                <button type="submit">🚀 Setup Database</button>
            </form>
            
            <div class="info-box">
                <strong>ℹ️ Informasi:</strong><br>
                • Jika konfigurasi sudah benar, klik tombol "Setup Database"<br>
                • Database akan dibuat otomatis jika belum ada<br>
                • User demo akan ditambahkan ke database<br>
                • Username: <strong>user1</strong><br>
                • Password: <strong>password123</strong>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
