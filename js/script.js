// Form validation and interactive features
document.addEventListener('DOMContentLoaded', function() {
    
    // Signup form validation
    const signupForm = document.getElementById('signupForm');
    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('confirm_password').value;
            
            if (password !== confirm) {
                e.preventDefault();
                showMessage('Passwords do not match!', 'error');
            }
            
            if (password.length < 6) {
                e.preventDefault();
                showMessage('Password must be at least 6 characters!', 'error');
            }
        });
    }
    
    // Auto-hide messages after 5 seconds
    const messages = document.querySelectorAll('.message');
    messages.forEach(function(message) {
        setTimeout(function() {
            message.style.transition = 'opacity 0.5s';
            message.style.opacity = '0';
            setTimeout(function() {
                message.remove();
            }, 500);
        }, 5000);
    });
    
    // Password strength indicator (optional enhancement)
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const strength = checkPasswordStrength(this.value);
            updatePasswordStrength(strength);
        });
    }
});

// Show message function
function showMessage(text, type) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${type}`;
    messageDiv.textContent = text;
    
    const container = document.querySelector('.auth-container') || document.querySelector('.container');
    if (container) {
        container.insertBefore(messageDiv, container.firstChild);
        
        setTimeout(function() {
            messageDiv.style.transition = 'opacity 0.5s';
            messageDiv.style.opacity = '0';
            setTimeout(function() {
                messageDiv.remove();
            }, 500);
        }, 5000);
    }
}

// Password strength checker
function checkPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 6) strength++;
    if (password.match(/[a-z]+/)) strength++;
    if (password.match(/[A-Z]+/)) strength++;
    if (password.match(/[0-9]+/)) strength++;
    if (password.match(/[$@#&!]+/)) strength++;
    
    return strength;
}

// Update password strength indicator
function updatePasswordStrength(strength) {
    let indicator = document.getElementById('password-strength');
    
    if (!indicator) {
        indicator = document.createElement('div');
        indicator.id = 'password-strength';
        indicator.style.marginTop = '5px';
        indicator.style.fontSize = '12px';
        
        const passwordField = document.getElementById('password');
        if (passwordField && passwordField.parentNode) {
            passwordField.parentNode.appendChild(indicator);
        }
    }
    
    const strengths = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
    const colors = ['#ff4444', '#ff7744', '#ffaa44', '#44ff44', '#00aa00'];
    
    if (strength > 0) {
        indicator.textContent = 'Password Strength: ' + strengths[strength - 1];
        indicator.style.color = colors[strength - 1];
    } else {
        indicator.textContent = '';
    }
}

// Confirm logout
function confirmLogout() {
    return confirm('Are you sure you want to logout?');
}

// Add logout confirmation
const logoutBtn = document.querySelector('a[href="logout.php"]');
if (logoutBtn) {
    logoutBtn.addEventListener('click', function(e) {
        if (!confirm('Are you sure you want to logout?')) {
            e.preventDefault();
        }
    });
}

// Form input animations
const formInputs = document.querySelectorAll('.form-group input');
formInputs.forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
    });
});