function listenProfileClick() {
  const profile = document.getElementById('profile');
  const dropdown = document.getElementById('dropdown');

  profile.addEventListener(
    'click',
    () => {
      if (dropdown.classList.contains('open')) {
        dropdown.classList.remove('open');
        dropdown.classList.add('close');
        dropdown.style.display = 'none';
      } else {
        dropdown.classList.remove('close');
        dropdown.classList.add('open');
        dropdown.style.display = 'block';
      }
    },
    false
  );
}

document.addEventListener('DOMContentLoaded', listenProfileClick, false);
