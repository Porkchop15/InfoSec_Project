document.getElementById("edit-profile-btn").addEventListener("click", function() {
    document.getElementById("editProfile").style.display = "block";
});

function closeProfilePopup() {
    document.getElementById("editProfile").style.display = "none";
}

document.getElementById("change-btn").addEventListener("click", function() {
    document.getElementById("changePass").style.display = "block";
});

function closeChangePopup() {
    document.getElementById("changePass").style.display = "none";
}