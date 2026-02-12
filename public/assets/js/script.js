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

  if (loginForm) {
    loginForm.addEventListener('submit', (event) => {
      const email = loginForm.querySelector('input[name="email"]')?.value.trim() || '';
      const password = loginForm.querySelector('input[name="password"]')?.value || '';

      if (!isValidEmail(email)) {
        event.preventDefault();
        showClientError(loginForm, 'Email invalide.');
        return;
      }

      if (password.length < 6) {
        event.preventDefault();
        showClientError(loginForm, 'Mot de passe trop court (min 6).');
        return;
      }

      showClientError(loginForm, '');
    });
  }

  if (registerForm) {
    registerForm.addEventListener('submit', (event) => {
      const username = registerForm.querySelector('input[name="username"]')?.value.trim() || '';
      const email = registerForm.querySelector('input[name="email"]')?.value.trim() || '';
      const password = registerForm.querySelector('input[name="password"]')?.value || '';

      if (username.length < 3) {
        event.preventDefault();
        showClientError(registerForm, 'Nom trop court (min 3).');
        return;
      }

      if (!/^[\p{L}0-9 _.-]+$/u.test(username)) {
        event.preventDefault();
        showClientError(registerForm, 'Nom invalide.');
        return;
      }

      if (!isValidEmail(email)) {
        event.preventDefault();
        showClientError(registerForm, 'Email invalide.');
        return;
      }

      if (password.length < 6) {
        event.preventDefault();
        showClientError(registerForm, 'Mot de passe trop court (min 6).');
        return;
      }

      showClientError(registerForm, '');
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