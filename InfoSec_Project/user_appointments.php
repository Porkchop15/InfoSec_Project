<?php
    include('include/db_connect.php');

    // SESSION HANDLING
    session_start();
    if(!isset($_SESSION['valid'])) {
        header("Location: home.php");
        exit();
    }

    if($_SESSION['role'] !== 'client') {
        header("Location: admin_dashboard.php");
        exit();
    }

    // ADD APPOINTMENTS
    if (isset($_POST['add'])) {
        $serviceType = $_POST['serviceType'];
        $appointmentDate = $_POST['appointmentDate'];
        $preferredTime = $_POST['preferredTime'];
        $specialInstructions = $_POST['specialInstructions'];
        $petProfileId = $_POST['petProfileId'];
        $userId = $_SESSION['valid'];
    
        $stmt = $conn->prepare("INSERT INTO appointment (service_type, preferred_date, preferred_time, special_instructions, pet_profile_id, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssii", $serviceType, $appointmentDate, $preferredTime, $specialInstructions, $petProfileId, $userId);
    
        // Execute the query and provide feedback
        if ($stmt->execute()) {
            echo "<script>
                    alert('Appointment added successfully!');
                    window.location.href = 'user_appointments.php';
                </script>";
        } else {
            echo "<script>alert('Error adding appointment: " . $stmt->error . "');</script>";
        }
    
        $stmt->close();
    }
    
    // UPDATE APPOINTMENTS
    if (isset($_POST['update'])) {
        $appointmentId = $_POST['appointmentId'];
        $serviceType = $_POST['serviceType'];
        $appointmentDate = $_POST['appointmentDate'];
        $preferredTime = $_POST['preferredTime'];
        $specialInstructions = $_POST['specialInstructions'];
        $petProfileId = $_POST['petProfileId'];
        $userId = $_SESSION['valid'];

        // Use prepared statement
        $stmt = $conn->prepare("UPDATE appointment SET service_type=?, preferred_date=?, preferred_time=?, special_instructions=?, pet_profile_id=?, user_id=? WHERE appointment_id=?");
        $stmt->bind_param("ssssiii", $serviceType, $appointmentDate, $preferredTime, $specialInstructions, $petProfileId, $userId, $appointmentId);



        if ($stmt->execute()) {
            echo "<script>
                    alert('Appointment updated successfully!');
                    window.location.href = 'user_appointments.php';
                </script>";
        } else {
            echo "<script>alert('Error updating appointment: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }

    // DELETE APPOINTMENTS
    if (isset($_POST['delete'])) {
        $id = $_POST['delete_id']; // Get the appointment ID
        $deleteInput = trim($_POST['deleteInput']); // Get the confirmation input
    
        // Ensure the user typed exactly "DELETE {id}"
        if ($deleteInput !== "DELETE $id") {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let inputField = document.getElementById('deleteInput');
                        inputField.setCustomValidity('Incorrect input! You must type exactly \"DELETE $id\" to proceed.');
                        inputField.reportValidity();
                    });
                </script>";
        } else {
            // Prepare the SQL DELETE statement
            $stmt = $conn->prepare("DELETE FROM appointment WHERE appointment_id = ?");
            $stmt->bind_param("i", $id);
    
            if ($stmt->execute()) {
                echo "<script>
                        alert('Appointment deleted successfully!');
                        window.location.href = 'user_appointments.php';
                    </script>";
            } else {
                echo "<script>alert('Error deleting appointment: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }
    }

    // GET PET PROFILE IDS FOR DATALIST
    $stmt = $conn->prepare("SELECT pet_id FROM pet_profile WHERE pet_owner_id = ?");
    $stmt->bind_param("i", $_SESSION['valid']);
    $stmt->execute();
    $result = $stmt->get_result();

    $petProfileIds = [];
    while ($row = $result->fetch_assoc()) {
        $petProfileIds[] = $row['pet_id'];
    }
    $stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER APPOINTMENTS</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/appointments.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/popup.css">
</head>
<body>
    <!-- START OF HEADER -->
    <header>
        <div class="header">
            <div class="logo">
                <a href="user_dashboard.php">
                    <img src="img/logo.png" alt="Logo">
                    <p><span>PAWPAL</span> CLINIC</p> 
                </a>         
            </div>
            <div class="left">
                <p class="tag">Client Portal</p>
                <a href="logout.php" class="drpd-logout">
                    <img src="img/logout_red.png" alt="Exit">
                </a>   
            </div>
        </div>
    </header>
    <!-- END OF HEADER -->

    <!-- START OF SIDE BAR -->
    <section class="side-bar">
        <div class="nav-bar">
            <a href="user_dashboard.php" class="dashboard">
                <img src="img/dashboard_white.png" alt="Dashboard">                
                <p>Dashboard</p>
            </a>
            <a href="user_profile.php" class="user">
                <img src="img/user_white.png" alt="user">
                <p>My Account</p>
            </a>
            <a href="user_pets.php" class="pet-profile">
                <img src="img/paws_white.png" alt="Pet Profile">
                <p>Pet Profiles</p>
            </a>
            <a href="user_appointments.php" class="appointment">
                <img src="img/appointment_peach.png" alt="Appointment">
                <p>Appointments</p>
            </a>
        </div>
    </section> 
    <!-- END OF SIDE BAR-->

    <!-- START OF ADD POPUP -->
    <div id="addPopup" class="popup">
        <div class="popup-container">
            <div class="popup-content">
                <div class="popup-title">
                    <h1>ADD APPOINTMENT</h1>
                    <p>Fill out the required fields.</p>
                </div>
                <div class="popup-line"></div>
                <div class="popup-form">
                    <form action="" method="POST">
                        <div class="box">
                            <label for="serviceType">SERVICE TYPE</label>
                            <select name="serviceType" required>
                                <option value="" disabled selected>Select Service Type</option>
                                <option value="Vet Consultation">Vet Consultation</option>
                                <option value="Pet Grooming">Pet Grooming</option>
                            </select>
                        </div>  
                        <div class="box">
                            <label for="appointmentDate">PREFERRED DATE</label>
                            <input name="appointmentDate" type="date" placeholder="Appointment Date" required>
                        </div>                        
                        <div class="box">
                            <label for="preferredTime">PREFERRED TIME</label>
                            <select name="preferredTime" required>
                                <option value="" disabled selected>Select Preferred Time</option>
                                <option value="09:00:00">09:00 AM</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="12:00:00">12:00 PM</option>
                                <option value="13:00:00">01:00 PM</option>
                                <option value="14:00:00">02:00 PM</option>
                                <option value="15:00:00">03:00 PM</option>
                                <option value="16:00:00">04:00 PM</option>
                                <option value="17:00:00">05:00 PM</option>
                            </select>
                        </div>
                        <div class="box">
                            <label for="specialInstructions">SPECIAL INSTRUCTIONS / NOTES</label>
                            <textarea name="specialInstructions" placeholder="Enter any special instructions or notes here" rows="4" cols="50"></textarea>
                        </div>                                           
                        <div class="box">
                            <label for="petProfileId">PET PROFILE ID</label>
                            <input list="petProfileIds" name="petProfileId" type="number" placeholder="Enter or Select Pet Profile ID" required>
                            <datalist id="petProfileIds">
                                <?php foreach ($petProfileIds as $petId): ?>
                                    <option value="<?= $petId ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="popup-btn">
                            <button name="add" type="submit" class="add-btn">ADD</button>
                            <button class="cancel-btn" type="button" onclick="closePopup()">CANCEL</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF ADD POPUP -->

    <!-- START OF EDIT POPUP -->
    <div id="editPopup" class="popup">
        <div class="popup-container">
            <div class="popup-content">
                <div class="popup-title">
                    <h1>UPDATE APPOINTMENT</h1>
                    <p>Fill out the required fields.</p>
                </div>
                <div class="popup-line"></div>
                <div class="popup-form">
                    <form action="user_appointments.php" method="POST">
                        <input type="hidden" id="edit-appointmentId" name="appointmentId">
                        <div class="box">
                            <select id="edit-serviceType" name="serviceType" required>
                                <option value="" disabled selected>Select Service Type</option>
                                <option value="Vet Consultation">Vet Consultation</option>
                                <option value="Pet Grooming">Pet Grooming</option>
                            </select>
                        </div>  
                        <div class="box">
                            <input id="edit-appointmentDate" name="appointmentDate" type="date" placeholder="Appointment Date" required>
                        </div>                        
                        <div class="box">
                            <select id="edit-preferredTime" name="preferredTime" required>
                                <option value="" disabled selected>Select Preferred Time</option>
                                <option value="09:00:00">09:00 AM</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="12:00:00">12:00 PM</option>
                                <option value="13:00:00">01:00 PM</option>
                                <option value="14:00:00">02:00 PM</option>
                                <option value="15:00:00">03:00 PM</option>
                                <option value="16:00:00">04:00 PM</option>
                                <option value="17:00:00">05:00 PM</option>
                            </select>
                        </div>
                        <div class="box">
                            <textarea id="edit-Instructions" name="specialInstructions" placeholder="Enter any special instructions or notes here" rows="4" cols="50"></textarea>
                        </div>                                   
                        <div class="box">
                            <input id="edit-petProfileId" list="petProfileIds" name="petProfileId" type="number" placeholder="Enter or Select Pet Profile ID" required>
                            <datalist id="petProfileIds">
                                <?php foreach ($petProfileIds as $petId): ?>
                                    <option value="<?= $petId ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="popup-btn">
                            <button name="update" type="submit" class="edit-btn">UPDATE</button>
                            <button class="cancel-btn" type="button" onclick="closePopupEdit()">CANCEL</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF EDIT POPUP -->

    <!-- START OF DELETE POPUP -->
    <div id="deletePopup" class="popup">
        <div class="popup-container">
            <div class="popup-content">
                <div class="popup-title">
                    <h1>DELETE APPOINTMENT</h1>
                    <p>Fill out the required fields.</p>
                </div>
                <div class="popup-line"></div>
                <div class="popup-form">
                    <form id="deleteForm" action="user_appointments.php" method="POST" onsubmit="return validateDeleteInput()">
                        <input type="hidden" id="delete-id" name="delete_id">
                        <div class="box">
                            <label for="deleteInput">Type "DELETE ID" to delete the appointment</label>
                            <input id="deleteInput" name="deleteInput" type="text" placeholder="DELETE ID" required oninput="validateDeleteInput()">
                        </div>
                        <div class="popup-btn">
                            <button name="delete" type="submit" class="delete-btn">DELETE</button>
                            <button class="cancel-btn" type="button" onclick="closePopupDelete()">CANCEL</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF DELETE POPUP -->

    <!-- START OF MAIN PANEL -->
    <section class="main-panel">
        <!-- START OF TRAIL -->
        <div class="trail">
            <a href="home.php">HOME /</a>
            <a href="user_dashboard.php">DASHBOARD /</a>
            <a href="user_appointments.php" class="current">MY APPOINTMENTS</a>
        </div>
        <!-- END OF TRAIL -->
    
        <!-- START OF TITLE -->
        <div class="title">
            <h1>MY APPOINTMENTS</h1>
            <button id="add">
                <img src="img/add.png" alt="Add">
                <p>NEW APPOINTMENT</p>
            </button>
        </div>
        <!-- END OF TITLE -->
    
        <!-- START OF TABLE -->
        <div class="tbl-container">
            <table>
                <!-- TABLE HEAD -->
                <tr>
                    <th>ID</th>
                    <th>SERVICE TYPE</th>
                    <th>PREFERRED DATE</th>
                    <th>PREFERRED TIME</th>
                    <th>SPECIAL INSTRUCTIONS/NOTES</th>
                    <th>PET PROFILE ID</th>
                    <th>ACTIONS</th>
                </tr>
                <?php
                    include('include/db_connect.php');

                    if (!isset($_SESSION['valid'])) {
                        echo "Unauthorized access.";
                        header("Location: index.php");
                        exit();
                    }

                    $user_id = $_SESSION['valid'];

                    // Fetch appointments for the logged-in user
                    $stmt = $conn->prepare("SELECT * FROM appointment WHERE user_id = ?");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['appointment_id']}</td>
                            <td>{$row['service_type']}</td>
                            <td>{$row['preferred_date']}</td>
                            <td>{$row['preferred_time']}</td>
                            <td>{$row['special_instructions']}</td>
                            <td>{$row['pet_profile_id']}</td>
                            <td>
                                <button class='edit' onclick='editAppointment({$row['appointment_id']}, \"{$row['service_type']}\", \"{$row['preferred_date']}\",\"{$row['preferred_time']}\", \"{$row['special_instructions']}\", \"{$row['pet_profile_id']}\")'>
                                    <img src='img/edit.png' alt='Edit'>
                                </button>
                                <button class='delete' onclick='deleteAppointment({$row['appointment_id']})'>
                                    <img src='img/delete.png' alt='Delete'>
                                </button>
                            </td>
                        </tr>";
                    }

                    // Close the statement
                    $stmt->close();
                    ?>
            </table>
        </div>
            <!-- END OF TABLE -->
    </section>
    <!-- END OF MAIN PANEL -->

    <script src="js/user_popup.js"></script>

</body>
</html>