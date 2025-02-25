// HOME PAGE
var btns = document.getElementsByClassName("book-appointment-btn");

for (var i = 0; i < btns.length; i++) {
    btns[i].onclick = function() {
        document.getElementById("bookAppointmentPopup").style.display = "block";
    }
}

document.getElementById("pet-profile-btn").addEventListener("click", function() {
    document.getElementById("petProfilePopup").style.display = "block";
});

function closeBAP() {
    document.getElementById("bookAppointmentPopup").style.display = "none";
}

function closePPP() {
    document.getElementById("petProfilePopup").style.display = "none";
}