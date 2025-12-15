<?php 
require_once 'php/auth.php';
redirect_if_not_logged_in();
redirect_if_not_admin();

// Fetch karyawan data
$stmt = $pdo->query("
    SELECT k.*, u.username 
    FROM karyawan k 
    JOIN users u ON k.user_id = u.id
");
$karyawans = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main class="container">
        <div class="dashboard-container">
            <div class="sidebar">
                <div class="profile-card">
                    <h3 class="profile-name"><?php echo $_SESSION['username']; ?></h3>
                    <p class="profile-role">Admin</p>
                </div>
                <nav>
                    <a href="dashboard_admin.php" class="active">Dashboard</a>
                    <a href="karyawan_actions.php?action=create">Tambah Karyawan</a>
                    <a href="logout.php">Logout</a>
                </nav>
            </div>
            
            <div class="main-content">
                <div class="card">
                    <h1 class="card-title">Dashboard Admin</h1>
                    
                    <div class="grid">
                        <div class="stat-card">
                            <div class="stat-value"><?php echo count($karyawans); ?></div>
                            <div class="stat-label">Total Karyawan</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"><?php echo count(array_filter($karyawans, fn($k) => $k['posisi'] === 'Manager')); ?></div>
                            <div class="stat-label">Manager</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value"><?php echo 'Rp ' . number_format(array_sum(array_column($karyawans, 'gaji')), 0, ',', '.'); ?></div>
                            <div class="stat-label">Total Gaji</div>
                        </div>
                    </div>
                    
                    <h2 style="margin: 30px 0 20px; color: var(--secondary);">Daftar Karyawan</h2>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Posisi</th>
                                    <th>Gaji</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($karyawans as $karyawan): ?>
                                <tr>
                                    <td><?php echo $karyawan['id']; ?></td>
                                    <td><?php echo htmlspecialchars($karyawan['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($karyawan['username']); ?></td>
                                    <td><?php echo htmlspecialchars($karyawan['posisi']); ?></td>
                                    <td>Rp <?php echo number_format($karyawan['gaji'], 0, ',', '.'); ?></td>
                                    <td class="actions">
                                        <a href="karyawan_actions.php?action=edit&id=<?php echo $karyawan['id']; ?>" class="edit">Edit</a>
                                        <a href="karyawan_actions.php?action=delete&id=<?php echo $karyawan['id']; ?>" class="delete delete-btn">Hapus</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>