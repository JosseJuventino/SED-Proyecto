document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('overlay');
    const popup = document.getElementById('popup');
    const openPopup = document.getElementById('openPopup');
    const closePopup = document.getElementById('closePopup');

    openPopup.addEventListener('click', () => {
        overlay.classList.remove('hidden');
        popup.classList.remove('hidden');
    });

    closePopup.addEventListener('click', () => {
        overlay.classList.add('hidden');
        popup.classList.add('hidden');
    });
});