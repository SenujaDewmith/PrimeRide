document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('showLogin') === 'true') {
      switchForm('login');
    }

    
    const alertMessage = document.getElementById('alert-message');
    if (alertMessage) {
      setTimeout(() => {
        alertMessage.style.display = 'none';
        if (alertMessage.classList.contains('alert-success')) {
          
          const signupForm = document.getElementById('signupForm');
          if (signupForm) {
            signupForm.reset();
          }
          
          switchForm('login');
        }
      }, 5000);
    }
  });

  function switchForm(formType) {
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');
    const loginTab = document.getElementById('login-tab');
    const signupTab = document.getElementById('signup-tab');

    if (formType === 'login') {
      loginForm.classList.remove('d-none');
      signupForm.classList.add('d-none');
      loginTab.classList.add('btn-primary');
      loginTab.classList.remove('btn-outline-primary');
      signupTab.classList.remove('btn-primary');
      signupTab.classList.add('btn-outline-primary');
    } else {
      loginForm.classList.add('d-none');
      signupForm.classList.remove('d-none');
      signupTab.classList.add('btn-primary');
      signupTab.classList.remove('btn-outline-primary');
      loginTab.classList.remove('btn-primary');
      loginTab.classList.add('btn-outline-primary');
    }
  }

  document.getElementById('signup-password').addEventListener('input', function () {
    const password = this.value;
    const regex = /^(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if (regex.test(password)) {
      this.setCustomValidity('');
    } else {
      this.setCustomValidity('Password must be at least 8 characters long, contain one uppercase letter, and one special symbol.');
    }
  });

  document.getElementById('confirm-password').addEventListener('input', function () {
    const password = document.getElementById('signup-password').value;
    const confirmPassword = this.value;
    if (password === confirmPassword) {
      this.setCustomValidity('');
    } else {
      this.setCustomValidity('Passwords do not match.');
    }
  });

  document.addEventListener("DOMContentLoaded", function() {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('showLogin') === 'true') {
    switchForm('login');
  }
});