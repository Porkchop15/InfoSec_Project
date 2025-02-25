// role-based login
document.addEventListener("DOMContentLoaded", function () {
    let urlParams = new URLSearchParams(window.location.search);
    
    document.getElementById('loginContinueBtn').addEventListener('click', function(event) {
        event.preventDefault();
        const userRole = urlParams.get('role');
        
        if (userRole === 'admin') {
            window.location.href = 'admin_dashboard.php';
        } else {
            window.location.href = 'home.php';
        }
    });
});