// Xử lý form đăng nhập
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('#login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.querySelector('#email-login').value;
            const password = document.querySelector('#password-login').value;
            
            // Gửi request đăng nhập
            fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    'email-login': email,
                    'password-login': password
                })
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.json();
                }
            })
            .then(data => {
                if (data && data.error) {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }

    // Xử lý form đăng ký
    const registerForm = document.querySelector('#register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(registerForm);
            
            fetch('/register/register', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.json();
                }
            })
            .then(data => {
                if (data && data.message) {
                    alert(data.message);
                    if (data.success) {
                        window.location.href = '/login';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }
}); 