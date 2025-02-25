<?php   
    include('include/db_connect.php');

    // SESSION HANDLING
    session_start();
    if(!isset($_SESSION['valid'])) {
        header("Location: index.php");
        exit();
    }
    
    if($_SESSION['role'] !== 'admin') {
        header("Location: index.php");
        exit();
    }

    // ADD PET
    if (isset($_POST['add'])) {
        $petName = $_POST['petName'];
        $species = $_POST['species'];
        $breed = $_POST['breed'];
        $gender = $_POST['gender'];
        $petDOB = $_POST['petDOB'];
        $petOwnerId = $_POST['petOwnerId'];

        $stmt = $conn->prepare("INSERT INTO pet_profile (pet_name, species, breed, gender, date_of_birth, pet_owner_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $petName, $species, $breed, $gender, $petDOB, $petOwnerId);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Pet added successfully!');
                    window.location.href = 'admin_pets.php';
                </script>";
        } else {
            echo "<script>alert('Error adding pet: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }

    // UPDATE PET
    if (isset($_POST['update'])) {
        $petId = $_POST['petId'];
        $petName = $_POST['petName'];
        $species = $_POST['species'];
        $breed = $_POST['breed'];
        $gender = $_POST['gender'];
        $petDOB = $_POST['petDOB'];
        $petOwnerId = $_POST['petOwnerId'];

        $sql = "UPDATE pet_profile SET pet_name=?, species=?, breed=?, gender=?, date_of_birth=?, pet_owner_id=? WHERE pet_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $petName, $species, $breed, $gender, $petDOB, $petOwnerId, $petId);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Pet updated successfully!');
                    window.location.href = 'admin_pets.php';
                </script>";
        } else {
            echo "<script>alert('Error adding pet: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }   

    // DELETE PET
    if (isset($_POST['delete'])) {
        $id = $_POST['delete_id'];
        $deleteInput = trim($_POST['deleteInput']);
    
        if ($deleteInput !== "DELETE $id") {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let inputField = document.getElementById('deleteInput');
                        inputField.setCustomValidity('Incorrect input! You must type exactly \"DELETE $id\" to proceed.');
                        inputField.reportValidity();
                    });
                </script>";
        } else {
            $stmt = $conn->prepare("DELETE FROM pet_profile WHERE pet_id = ?");
            $stmt->bind_param("i", $id);
    
            if ($stmt->execute()) {
                echo "<script>
                        alert('Pet deleted successfully!');
                        window.location.href = 'admin_pets.php'; // Redirect or use AJAX for smoother UI
                    </script>";
            } else {
                echo "<script>alert('Error deleting pet: " . $stmt->error . "');</script>";
            }
    
            $stmt->close();
        }
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PET PROFILE</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/pets.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/popup.css">
</head>
<body>
    <!-- START OF HEADER -->
    <header>
        <div class="header">
            <div class="logo">
                <a href="admin_dashboard.php">
                    <img src="img/logo.png" alt="">
                    <p><span>PAWPAL</span> CLINIC</p> 
                </a>         
            </div>
            <div class="left">
                <p class="tag">Admin Portal</p>
                <a href="logout.php" class="drpd-logout">
                    <img src="img/logout_red.png" alt="">
                </a>
                
            </div>
        </div>
    </header>
    <!-- END OF HEADER -->

    <!-- START OF SIDE BAR -->
    <section class="side-bar">
        <div class="nav-bar">
            <a href="admin_dashboard.php" class="dashboard">
                <img src="img/dashboard_white.png" alt="Dashboard">                
                <p>Dashboard</p>
            </a>
            <a href="admin_clients.php" class="user">
                <img src="img/users_white.png" alt="Client">
                <p>Clients</p>
            </a>
            <a href="admin_pets.php" class="pet-profile">
                <img src="img/paws_peach.png" alt="Pet Profile">
                <p>Pet Profiles</p>
            </a>
            <a href="admin_appointments.php" class="appointment">
                <img src="img/appointment_white.png" alt="Appointment">
                <p>Appointments</p>
            </a>
        </div>
    </section> 
    <!-- END OF SIDE BAR -->


    <!-- START OF ADD POPUP -->
    <div id="addPopup" class="popup">
        <div class="popup-container">
            <div class="popup-content">
                <div class="popup-title">
                    <h1>ADD PET PROFILE</h1>
                    <p>Fill out the required fields.</p>
                </div>
                <div class="popup-line"></div>
                <div class="popup-form">
                    <form action="" method="POST">
                        <div class="box">
                            <label for="petName">PET'S NAME</label>
                            <input name="petName" type="text" placeholder="Pet's Name" minlength="3" maxlength="20" required>
                        </div>
                        <div class="box">
                            <label for="species">SPECIES</label>
                            <input name="species" type="text" placeholder="Species" minlength="3" maxlength="50" required>
                        </div>
                        <div class="box">
                            <label for="breed">BREED</label>
                            <input name="breed" type="text" placeholder="Breed" minlength="3" maxlength="50" required>
                        </div>
                        <div class="box">
                            <label for="gender">GENDER</label>
                            <select name="gender" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                            </select>
                        </div>
                        <div class="box">
                            <label for="petDOB">DATE OF BIRTH</label>
                            <input name="petDOB" type="date" placeholder="Date of Birth" required>
                        </div>                      
                        <div class="box">
                            <label for="petOwnerId">PET OWNER ID</label>
                            <input list="petOwnerIds" name="petOwnerId" type="number" placeholder="Enter or Select Pet Owner ID" required>
                            <datalist id="petOwnerIds">
                                <option value="1">
                                <option value="2">
                                <option value="3">
                                <option value="4">
                                <option value="5">
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
                    <h1>UPDATE PET PROFILE</h1>
                    <p>Fill out the required fields.</p>
                </div>
                <div class="popup-line"></div>
                <div class="popup-form">
                    <form action="admin_pets.php" method="POST">
                        <input type="hidden" id="edit-id" name="petId">
                        <div class="box">
                            <input id="edit-petName" name="petName" type="text" placeholder="Pet's Name" minlength="3" maxlength="20" required>
                        </div>
                        <div class="box">
                            <input id="edit-species" name="species" type="text" placeholder="Species" minlength="3" maxlength="50" required>
                        </div>
                        <div class="box">
                            <input id="edit-breed" name="breed" type="text" placeholder="Breed" minlength="3" maxlength="50" required>
                        </div>
                        <div class="box">
                            <select id="edit-gender" name="gender" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                            </select>
                        </div>
                        <div class="box">
                            <input id="edit-petDOB" name="petDOB" type="date" placeholder="Date of Birth" required>
                        </div>                     
                        <div class="box">
                            <input list="petOwnerIds" id="edit-petOwnerId" name="petOwnerId" type="number" placeholder="Enter or Select Pet Owner ID" required>
                            <datalist id="petOwnerIds">
                                <option value="1">
                                <option value="2">
                                <option value="3">
                                <option value="4">
                                <option value="5">
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
                    <h1>DELETE PET PROFILE</h1>
                    <p>Fill out the required fields.</p>
                </div>
                <div class="popup-line"></div>
                <div class="popup-form">
                <form id="deleteForm" action="admin_pets.php" method="POST" onsubmit="return validateDeleteInput()">
                        <input type="hidden" id="delete-id" name="delete_id">
                        <div class="box">
                            <label for="deleteInput">Type "DELETE ID" to delete the pet profile</label>
                            <input id="deleteInput" name="deleteInput" type="text" placeholder="DELETE ID" required oninput="validateDeleteInput()">
                    </div>
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
            <a href="admin_dashboard.php">DASHBOARD /</a>
            <a href="admin_pets.php" class="current">PET PROFILE MANAGEMENT</a>
        </div>
        <!-- END OF TRAIL -->
    
        <!-- START OF TITLE -->
        <div class="title">
            <h1>PET PROFILE MANAGEMENT</h1>
            <button id="add">
                <img src="img/add.png" alt="Add">
                <p>ADD PET</p>
            </button>
        </div>
        <!-- END OF TITLE -->
    
        <!-- START OF TABLE -->
        <div class="tbl-container">
            <table>
                <!-- TABLE HEAD -->
                <tr>
                    <th>ID</th>
                    <th>PET'S NAME</th>
                    <th>SPECIES</th>
                    <th>BREED</th>
                    <th>GENDER</th>
                    <th>DATE OF BIRTH</th>
                    <th>PET OWNER ID</th>
                    <th>ACTIONS</th>
                </tr>
                <!-- TABLE ROWS -->
                <?php
                    $result = $conn->query("SELECT * FROM pet_profile");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['pet_id']}</td>
                            <td>{$row['pet_name']}</td>
                            <td>{$row['species']}</td>
                            <td>{$row['breed']}</td>
                            <td>{$row['gender']}</td>
                            <td>{$row['date_of_birth']}</td>
                            <td>{$row['pet_owner_id']}</td>
                            <td>
                                <button class='edit' onclick='editPet({$row['pet_id']}, \"{$row['pet_name']}\", \"{$row['species']}\", \"{$row['breed']}\", \"{$row['gender']}\", \"{$row['date_of_birth']}\", \"{$row['pet_owner_id']}\")'>
                                    <img src='img/edit.png' alt='Edit'>
                                </button>
                                <button class='delete' onclick='deletePet({$row['pet_id']})'>
                                    <img src='img/delete.png' alt='Delete'>
                                </button>
                            </td>
                        </tr>";
                    }
                ?>
            </table>
        </div>
            <!-- END OF TABLE -->
    </section>
    <!-- END OF MAIN PANEL -->

    <script src="js/admin_popup.js"></script>
    
</body>
</html>