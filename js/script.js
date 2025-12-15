document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const signupForm = document.getElementById('signupForm');
    const loginForm = document.getElementById('loginForm');
    
    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            let isValid = true;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            // Password match validation
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                isValid = false;
            }
            
            // Password strength
            if (password.length < 8) {
                e.preventDefault();
                alert('Password minimal 8 karakter!');
                isValid = false;
            }
        });
    }
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            if (!username || !password) {
                e.preventDefault();
                alert('Username dan password harus diisi!');
            }
        });
    }
    
    // Confirm delete actions
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });
    
    // Auto-dismiss alerts
    setTimeout(function() {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 5000);
});