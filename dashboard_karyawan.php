<?php 
require_once 'php/auth.php';
redirect_if_not_logged_in();

// Fetch current employee data
$stmt = $pdo->prepare("
    SELECT k.*, u.username 
    FROM karyawan k 
    JOIN users u ON k.user_id = u.id 
    WHERE k.user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$karyawan = $stmt->fetch();

if (!$karyawan) {
    die("Data karyawan tidak ditemukan. Silakan hubungi admin.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main class="container">
        <div class="dashboard-container">
            <div class="sidebar">
                <div class="profile-card">
                    <h3 class="profile-name"><?php echo htmlspecialchars($karyawan['nama']); ?></h3>
                    <p class="profile-role"><?php echo htmlspecialchars($karyawan['posisi']); ?></p>
                </div>
                <nav>
                    <a href="dashboard_karyawan.php" class="active">Dashboard</a>
                    <a href="logout.php">Logout</a>
                </nav>
            </div>
            
            <div class="main-content">
                <div class="card">
                    <h1 class="card-title">Dashboard Karyawan</h1>
                    
                    <div class="profile-section">
                        <div style="display: flex; gap: 30px; margin-bottom: 30px;">
                            <div style="flex: 1;">
                                <h2>Informasi Pribadi</h2>
                                <p><strong>Nama:</strong> <?php echo htmlspecialchars($karyawan['nama']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($karyawan['username']); ?></p>
                                <p><strong>Posisi:</strong> <?php echo htmlspecialchars($karyawan['posisi']); ?></p>
                                <p><strong>Gaji:</strong> Rp <?php echo number_format($karyawan['gaji'], 0, ',', '.'); ?></p>
                            </div>
                            <div style="flex: 1;">
                                <h2>Kontak</h2>
                                <p><strong>Alamat:</strong> <?php echo nl2br(htmlspecialchars($karyawan['alamat'])); ?></p>
                                <p><strong>Telepon:</strong> <?php echo htmlspecialchars($karyawan['no_telp']); ?></p>
                            </div>
                        </div>
                        
                        <div class="card" style="background: #e8f4ff; border-left: 4px solid var(--primary);">
                            <h3 style="color: var(--primary);">Pengumuman</h3>
                            <p style="margin-top: 10px;">Selamat datang di dashboard karyawan. Di sini Anda dapat melihat informasi pribadi dan data penting terkait pekerjaan Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>