

// JavaScript to control the modal behavior
const openPopup = document.getElementById('openPopup');
const modal = document.getElementById('signInModal');
const closeBtn = document.querySelector('.close');

openPopup.addEventListener('click', () => {
  modal.style.display = 'block';
});

closeBtn.addEventListener('click', () => {
  modal.style.display = 'none';
});

window.addEventListener('click', (event) => {
  if (event.target === modal) {
    modal.style.display = 'none';
  }
});
