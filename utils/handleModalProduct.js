function listenAddProductClick() {
  const openModal = document.getElementById('openModal');
  const modal = document.getElementById('modal');
  const closeModal = document.getElementById('closeModal');
  const addProduct = document.getElementById('addProduct');

  openModal.addEventListener(
    'click',
    () => {
      modal.classList.remove('off');
    },
    false
  );

  closeModal.addEventListener(
    'click',
    () => {
      modal.classList.add('off');
    },
    false
  );

  addProduct.addEventListener(
    'click',
    () => {
      modal.classList.add('off');
    },
    false
  );
}

document.addEventListener('DOMContentLoaded', listenAddProductClick, false);
