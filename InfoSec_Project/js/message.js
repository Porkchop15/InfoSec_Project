// Message Popup
document.addEventListener("DOMContentLoaded", function () {
    let urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('success')) {
        document.getElementById('successPopup').classList.add('active');
    }

    if (urlParams.has('error')) {
        const errorPopup = document.getElementById('errorPopup');
        const errorMessage = document.getElementById('errorMessage');
        errorMessage.textContent = urlParams.get('error').replace(/\+/g, ' ');
        errorPopup.classList.add('active');

        document.getElementById('errorCloseBtn').addEventListener('click', function () {
            errorPopup.classList.remove('active');
            removeURLParams();
        });
    }

    function removeURLParams() {
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});