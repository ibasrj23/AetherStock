-- Membuat tabel users
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample user (username: ibas, password: ibas)
INSERT INTO users (username, email, password) VALUES 
('ibas', 'ibas@example.com', '$2y$10$EvjL8Pt9ShHKnmIpHKGBmOJrNpd0Jm6UWDZbwh6PLdGkB9wPPFEpi');

-- Membuat tabel products
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  price DECIMAL(10, 2) NOT NULL,
  quantity INT NOT NULL,
  user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Membuat tabel transaksi
CREATE TABLE IF NOT EXISTS transaksi (
  id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
  id_barang INT NOT NULL,
  jenis_transaksi ENUM('masuk', 'keluar') NOT NULL,
  jumlah_barang INT NOT NULL,
  tanggal_transaksi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  keterangan TEXT,
  FOREIGN KEY (id_barang) REFERENCES products(id) ON DELETE CASCADE
);


