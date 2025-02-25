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

    // ADD CLIENT
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contactNum = $_POST['contactNum'];
        $address = $_POST['address'];
        $role = "user";
        $password = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Hash password

        $stmt = $conn->prepare("INSERT INTO user (name, email, contactNum, address, pass, role) VALUES ('$name', '$email', '$contactNum', '$address', '$password', '$role')");

        if ($stmt->execute()) {
            echo "<script>
                    alert('Client added successfully!');
                    window.location.href = 'admin_clients.php';
                </script>";
        } else {
            echo "<script>alert('Error adding client: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }

    //  UPDATE CLIENT
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contactNum = $_POST['contactNum'];
        $address = $_POST['address'];

        $sql = "UPDATE user SET name=?, email=?, contactNum=?, address=? WHERE user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $contactNum, $address, $id);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Client updated successfully!');
                    window.location.href = 'admin_clients.php';
                </script>";
        } else {
            echo "<script>alert('Error updating client: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }

    // DELETE CLIENT
    if (isset($_POST['delete'])) {        
        $id = $_POST['delete_id'];
        $deleteInput = $_POST['deleteInput'];
        
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
            $stmt = $conn->prepare("DELETE FROM user WHERE user_id = ?");
            $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo "<script>
                    alert('Client deleted successfully!');
                    window.location.href = 'admin_clients.php';
                </script>";
        } else {
            echo "<script>alert('Error deleting client: " . $stmt->error . "');</script>";
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
    <title>ADMIN CLIENTS</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin_clients.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/popup.css">
</head>
<body>
    <!-- HEADER -->
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
    
    <!-- SIDE BAR -->
    <section class="side-bar">
        <div class="nav-bar">
            <a href="admin_dashboard.php" class="dashboard"><img src="img/dashboard_white.png" alt="Dashboard"> <p>Dashboard</p></a>
            <a href="admin_clients.php" class="client"><img src="img/users_peach.png" alt="Client"><p>Clients</p></a>
            <a href="admin_pets.php" class="pet-profile"><img src="img/paws_white.png" alt="Pet Profile"><p>Pet Profiles</p></a>
            <a href="admin_appointments.php" class="appointment"><img src="img/appointment_white.png" alt="Appointment"><p>Appointments</p></a>
        </div>
    </section> 

    <!-- MAIN PANEL -->
    <section class="main-panel">
        <div class="trail"><a href="admin_dashboard.php">DASHBOARD /</a><a href="admin_clients.php" class="current">CLIENT MANAGEMENT</a></div>
        <div class="title">
            <h1>CLIENT MANAGEMENT</h1>
            <button id="add"><img src="img/add.png" alt="Add"><p>ADD CLIENT</p></button>
        </div>
        <div class="tbl-container">
            <table>
                <tr><th>ID</th><th>NAME</th><th>EMAIL</th><th>CONTACT NUMBER</th><th>ADDRESS</th><th>ACTIONS</th></tr>
                <?php
                $result = $conn->query("SELECT * FROM user WHERE user_id != 1");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['user_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['contactNum']}</td>
                        <td>{$row['address']}</td>
                        <td>
                            <button class='edit' onclick='editClient({$row['user_id']}, \"{$row['name']}\", \"{$row['email']}\", \"{$row['contactNum']}\", \"{$row['address']}\")'>
                                <img src='img/edit.png' alt='Edit'>
                            </button>
                            <button class='delete' onclick='deleteClient({$row['user_id']})'>
                                <img src='img/delete.png' alt='Delete'>
                            </button>
                        </td>
                    </tr>";
                }
                ?>
            </table>
        </div>
    </section>
    
    <!-- START OF ADD POPUP -->
    <div id="addPopup" class="popup">
        <div class="popup-container">
            <div class="popup-content">
                <div class="popup-title">
                    <h1>ADD CLIENT</h1>
                    <p>Fill out the required fields.</p>
                </div>
                <div class="popup-line"></div>
                <div class="popup-form">
                    <form action="" method="POST">
                        <div class="box">
                            <label for="name">NAME</label>
                            <input name="name" type="text" placeholder="Name" minlength="10" maxlength="255" required>
                        </div>
                        <div class="box">
                            <label for="email">EMAIL</label>
                            <input name="email" type="email" placeholder="Email" minlength="10" maxlength="255" required>
                        </div>
                        <div class="box">
                            <label for="contactNum">CONTACT NUMBER</label>
                            <input name="contactNum" type="number" placeholder="Contact Number" minlength="11" maxlength="11" required>
                        </div>
                        <div class="box">
                            <label for="address">ADDRESS</label>
                            <input name="address" type="text" placeholder="Address" maxlength="255" required>
                        </div>
                        <div class="box">
                            <label for="tempPass">TEMPORARY PASSWORD</label>
                            <input name="pass" type="password" placeholder="Password" minlength="8" maxlength="16" required>
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
                    <h1>UPDATE CLIENT</h1>
                    <p>Fill out the required fields.</p>
                </div>
                <div class="popup-line"></div>
                <div class="popup-form">
                <form action="admin_clients.php" method="POST">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="box">
                        <input id="edit-name" name="name" name="editEname" type="text" placeholder="Name" minlength="10" maxlength="255" required>
                    </div>
                    <div class="box">
                        <input id="edit-email" name="email" name="editEmail" type="email" placeholder="Email" minlength="10" maxlength="255" required>
                    </div>
                    <div class="box">
                        <input id="edit-contactNum" name="contactNum" name="editContactNum" type="number" placeholder="Contact Number" minlength="11" maxlength="11" required>
                    </div>
                    <div class="box">
                        <input id="edit-address" name="address" name="editAdress" type="text" placeholder="Address" maxlength="255" required>
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
                    <h1>DELETE CLIENT</h1>
                    <p>Fill out the required fields.</p>
                </div>
                <div class="popup-line"></div>
                <div class="popup-form">
                <form action="admin_clients.php" method="POST">
                    <input type="hidden" id="delete-id" name="delete_id" onsubmit="return validateDeleteInput()">
                    <div class="box">
                        <label for="deleteInput">Type "DELETE ID" to confirm deletion</label>
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

    <script src="js/admin_popup.js"></script>

</body>
</html>