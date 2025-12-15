-- copy dan salin di XAMPP. kalau belum tau caranya liat tutor

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'karyawan') NOT NULL DEFAULT 'karyawan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE karyawan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT,
    no_telp VARCHAR(20),
    posisi VARCHAR(50),
    gaji DECIMAL(10,2),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


