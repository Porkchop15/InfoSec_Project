// FUNCTION: OPEN CREATE POPUPS
document.getElementById("add").addEventListener("click", function() {
    document.getElementById("addPopup").style.display = "block";
});

// FUNCTION: OPEN CLIENT EDIT POPUP WITH DATA
function editClient(userId, name, email, contactNum, address) {
    document.getElementById("edit-id").value = userId;
    document.getElementById("edit-name").value = name;
    document.getElementById("edit-email").value = email;
    document.getElementById("edit-contactNum").value = contactNum;
    document.getElementById("edit-address").value = address;

    document.getElementById("editPopup").style.display = "block";
}

// FUNCTION: OPEN PET PROFILE EDIT POPUP WITH DATA
function editPet(petId, petName, species, breed, gender, petDOB) {
    document.getElementById('edit-id').value = petId;
    document.getElementById('edit-petName').value = petName;
    document.getElementById('edit-species').value = species;
    document.getElementById('edit-breed').value = breed;
    document.getElementById('edit-gender').value = gender;
    document.getElementById('edit-petDOB').value = petDOB;
    
    document.getElementById('editPopup').style.display = 'block';
}

//  FUNCTION: OPEN APPOINTMENT EDIT POPUP WITH DATA
function editAppointment(appointmentId, service_type, preferred_date, preferred_time, special_instructions, pet_profile_id) {
    document.getElementById('edit-appointmentId').value = appointmentId;
    document.getElementById('edit-serviceType').value = service_type;
    document.getElementById('edit-appointmentDate').value = preferred_date;
    document.getElementById('edit-preferredTime').value = preferred_time;
    document.getElementById('edit-Instructions').value = special_instructions;
    document.getElementById('edit-petProfileId').value = pet_profile_id;
    
    document.getElementById('editPopup').style.display = 'block';
}

// FUNCTION: OPEN PET PROFILE DELETE POPUP
function deletePet(petId) {
    document.getElementById("delete-id").value = petId;
    document.getElementById('deleteInput').placeholder = `DELETE ${petId}`;
    document.getElementById("deletePopup").style.display = "block";

    document.getElementById("deletePopup").style.display = "block";
}

// FUNCTION: OPEN APPOINTMENT DELETE POPUP
function deleteAppointment(appointmentId) {
    document.getElementById("delete-id").value = appointmentId;
    document.getElementById('deleteInput').placeholder = `DELETE ${appointmentId}`;
    document.getElementById("deletePopup").style.display = "block";

    document.getElementById("deletePopup").style.display = "block";
}

// FUNCTION: VALIDATE DELETE INPUT
function validateDeleteInput() {
    let deleteInput = document.getElementById('deleteInput');
    let deleteId = document.getElementById('delete-id').value;
    let expectedInput = `DELETE ${deleteId}`;
    
    if (deleteInput.value.trim() !== expectedInput) {
        deleteInput.setCustomValidity(`Incorrect input! You must type exactly "${expectedInput}" to proceed.`);
    } else {
        deleteInput.setCustomValidity('');
    }
    return deleteInput.checkValidity();
}

// CLOSE POPUPS FUNCTION

function closePopup() {
    document.getElementById("addPopup").style.display = "none";
}

function closePopupEdit() {
    document.getElementById("editPopup").style.display = "none";
}

function closePopupDelete() {
    document.getElementById("deletePopup").style.display = "none";
}



