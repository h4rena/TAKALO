document.addEventListener('DOMContentLoaded', () => {
  console.log('DOM loaded');
  
  const signUpButton = document.getElementById('signUp');
  const signInButton = document.getElementById('signIn');
  const container = document.getElementById('container');

  console.log('signUpButton:', signUpButton);
  console.log('signInButton:', signInButton);
  console.log('container:', container);

  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');

  const showClientError = (form, message) => {
    if (!form) return;
    const errorEl = form.querySelector('.client-error');
    if (errorEl) {
      errorEl.textContent = message || '';
    }
  };

  const isValidEmail = (value) => {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
  };

  const validateLogin = () => {
    if (!loginForm) return true;
    const email = loginForm.querySelector('input[name="email"]')?.value.trim() || '';
    const password = loginForm.querySelector('input[name="password"]')?.value || '';

    if (email !== '' && !isValidEmail(email)) {
      showClientError(loginForm, 'Email invalide.');
      return false;
    }

    if (password !== '' && password.length < 6) {
      showClientError(loginForm, 'Mot de passe trop court (min 6).');
      return false;
    }

    showClientError(loginForm, '');
    return true;
  };

  if (loginForm) {
    loginForm.addEventListener('submit', (event) => {
      if (!validateLogin()) {
        event.preventDefault();
      }
    });

    loginForm.querySelectorAll('input').forEach((input) => {
      input.addEventListener('blur', validateLogin);
    });
  }

  const validateRegister = () => {
    if (!registerForm) return true;
    const username = registerForm.querySelector('input[name="username"]')?.value.trim() || '';
    const email = registerForm.querySelector('input[name="email"]')?.value.trim() || '';
    const password = registerForm.querySelector('input[name="password"]')?.value || '';

    if (username !== '' && username.length < 3) {
      showClientError(registerForm, 'Nom trop court (min 3).');
      return false;
    }

    if (username !== '' && !/^[\p{L}0-9 _.-]+$/u.test(username)) {
      showClientError(registerForm, 'Nom invalide.');
      return false;
    }

    if (email !== '' && !isValidEmail(email)) {
      showClientError(registerForm, 'Email invalide.');
      return false;
    }

    if (password !== '' && password.length < 6) {
      showClientError(registerForm, 'Mot de passe trop court (min 6).');
      return false;
    }

    showClientError(registerForm, '');
    return true;
  };

  if (registerForm) {
    registerForm.addEventListener('submit', (event) => {
      if (!validateRegister()) {
        event.preventDefault();
      }
    });

    registerForm.querySelectorAll('input').forEach((input) => {
      input.addEventListener('blur', validateRegister);
    });
  }

  if (signUpButton && signInButton && container) {
    signUpButton.addEventListener('click', () => {
      console.log('Sign Up clicked');
      container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
      console.log('Sign In clicked');
      container.classList.remove("right-panel-active");
    });
  } else {
    console.log('Elements not found');
  }
});