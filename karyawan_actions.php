<?php 
require_once 'php/auth.php';
redirect_if_not_logged_in();
redirect_if_not_admin();

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? 0;

// Fetch user list for dropdown
$stmt = $pdo->prepare("SELECT id, username FROM users WHERE role = 'karyawan' AND id NOT IN (SELECT user_id FROM karyawan)");
$stmt->execute();
$users = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $no_telp = trim($_POST['no_telp']);
    $posisi = trim($_POST['posisi']);
    $gaji = (float)$_POST['gaji'];
    
    try {
        if ($action === 'create') {
            $stmt = $pdo->prepare("INSERT INTO karyawan (user_id, nama, alamat, no_telp, posisi, gaji) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $nama, $alamat, $no_telp, $posisi, $gaji]);
            header('Location: dashboard_admin.php?success=Karyawan berhasil ditambahkan');
        } elseif ($action === 'edit') {
            $stmt = $pdo->prepare("UPDATE karyawan SET nama=?, alamat=?, no_telp=?, posisi=?, gaji=? WHERE id=?");
            $stmt->execute([$nama, $alamat, $no_telp, $posisi, $gaji, $id]);
            header('Location: dashboard_admin.php?success=Karyawan berhasil diupdate');
        }
        exit;
    } catch (PDOException $e) {
        $error = "Terjadi kesalahan: " . $e->getMessage();
    }
}

// Delete action
if ($action === 'delete' && $id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM karyawan WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: dashboard_admin.php?success=Karyawan berhasil dihapus');
        exit;
    } catch (PDOException $e) {
        $error = "Terjadi kesalahan: " . $e->getMessage();
    }
}

// Fetch data for edit
$karyawan = null;
if ($action === 'edit' && $id) {
    $stmt = $pdo->prepare("SELECT * FROM karyawan WHERE id = ?");
    $stmt->execute([$id]);
    $karyawan = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($action === 'edit') ? 'Edit Karyawan' : 'Tambah Karyawan'; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main class="container">
        <div class="card">
            <h1 class="card-title"><?php echo ($action === 'edit') ? 'Edit Data Karyawan' : 'Tambah Karyawan Baru'; ?></h1>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="karyawan_actions.php?action=<?php echo $action; ?><?php echo ($action === 'edit' && $id) ? '&id='.$id : ''; ?>">
                <?php if ($action !== 'edit'): ?>
                <div class="form-group">
                    <label for="user_id">Pilih User</label>
                    <select class="form-control" id="user_id" name="user_id" required>
                        <option value="">-- Pilih User --</option>
                        <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['id']; ?>" <?php echo ($karyawan && $karyawan['user_id'] == $user['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($user['username']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $karyawan ? htmlspecialchars($karyawan['nama']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo $karyawan ? htmlspecialchars($karyawan['alamat']) : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="no_telp">No. Telepon</label>
                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo $karyawan ? htmlspecialchars($karyawan['no_telp']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="posisi">Posisi/Jabatan</label>
                    <input type="text" class="form-control" id="posisi" name="posisi" value="<?php echo $karyawan ? htmlspecialchars($karyawan['posisi']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="gaji">Gaji (Rp)</label>
                    <input type="number" class="form-control" id="gaji" name="gaji" step="0.01" value="<?php echo $karyawan ? $karyawan['gaji'] : ''; ?>" required min="0">
                </div>
                
                <button type="submit" class="btn btn-success"><?php echo ($action === 'edit') ? 'Update Data' : 'Tambah Karyawan'; ?></button>
                <a href="dashboard_admin.php" class="btn" style="background: #7f8c8d; margin-left: 10px;">Batal</a>
            </form>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>