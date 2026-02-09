document.addEventListener('DOMContentLoaded', () => {
  console.log('DOM loaded');
  
  const signUpButton = document.getElementById('signUp');
  const signInButton = document.getElementById('signIn');
  const container = document.getElementById('container');

  console.log('signUpButton:', signUpButton);
  console.log('signInButton:', signInButton);
  console.log('container:', container);

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