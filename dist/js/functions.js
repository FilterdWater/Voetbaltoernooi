function hamburger() {
  const menuButton = document.getElementById('toggleMenu');
  const sideMenu = document.getElementById('sideMenu');
  const backDrop = document.getElementById('backDrop');
  const navMenu = document.querySelector('nav');
  const closeBtn = document.getElementById('hamCloseBtn');

  backDrop.addEventListener('click', () => {
    sideMenu.classList.toggle('hidden');
  });

  closeBtn.addEventListener('click', () => {
    sideMenu.classList.toggle('hidden');
  });

  menuButton.addEventListener('click', () => {
    sideMenu.classList.toggle('hidden');
  });
}
