<header>
    <div class="container">
        <nav>
            <div class="logo">PT.Andino Makmur</div>
            <div class="nav-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a href="dashboard_admin.php">Dashboard</a>
                    <?php else: ?>
                        <a href="dashboard_karyawan.php">Dashboard</a>
                    <?php endif; ?>
                    <a href="logout.php">Logout</a>
                <?php else: ?>
                    <a href="index.php">Home</a>
                    <a href="login.php">Login</a>
                    <a href="signup.php">Sign Up</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>