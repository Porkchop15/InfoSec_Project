<?php    
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER PROFILE</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/user_profile.css">
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
                <a href="home.php" class="drpd-logout">
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
            <a href="user_profile.php" class="profile">
                <img src="img/user_peach.png" alt="Profile">
                <p>My Account</p>
            </a>
            <a href="user_pets.php" class="pet-profile">
                <img src="img/paws_white.png" alt="Pet Profile">
                <p>Pet Profiles</p>
            </a>
            <a href="user_appointments.php" class="appointment">
                <img src="img/appointment_white.png" alt="Appointment">
                <p>Appointments</p>
            </a>
        </div>
    </section> 
    <!-- END OF SIDE BAR -->

    <section class="main-panel">
        <!-- START OF TRAIL -->
        <div class="trail">
            <a href="home.php">HOME /</a>
            <a href="user_dashboard.php">DASHBOARD /</a>
            <a href="user_profile.php" class="current">MY ACCOUNT</a>
        </div>
        <!-- END OF TRAIL -->
    
        <!-- START OF TITLE -->
        <div class="title">
            <h1>MY ACCOUNT</h1>
            <button id="edit-profile-btn">
                <img src="img/edit.png" alt="EDIT">
                <p>EDIT</p>
            </button>
        </div>
        <!-- END OF TITLE -->
         
        <!-- FETCH INFO -->  
        <?php
            include('include/db_connect.php');

            if (!isset($_SESSION['email'])) {
                echo "<script>alert('User not logged in.'); window.location.href = 'login.php';</script>";
                exit;
            }

            $email = trim($_SESSION['email']); // Trim spaces

            // Use prepared statement to prevent SQL injection
            $query = "SELECT name, contactNum, address FROM user WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
                $contactNum = htmlspecialchars($row['contactNum'], ENT_QUOTES, 'UTF-8');
                $address = htmlspecialchars($row['address'], ENT_QUOTES, 'UTF-8');
            } else {
                echo "<script>alert('User not found!');</script>";
                exit;
            }

            $stmt->close();
            $conn->close();

            ?>
            <!-- FETCH INFO --> 
             
        <!-- START OF INFO CONTAINER -->
        <div class="info-container">

            <!-- START OF PERSONAL INFO -->
            <div class="personal-info">
                <div class="box-container">
                    <div class="box">
                        <label for="name">NAME</label>
                        <input type="text" value="<?php echo $name; ?>" readonly>
                    </div>
                    <div class="box">
                        <label for="contactNum">CONTACT NUMBER</label>
                        <input type="number" value="<?php echo $contactNum; ?>" readonly>
                    </div>
                    <div class="box">
                        <label for="address">ADDRESS</label>
                        <input type="text" value="<?php echo $address; ?>" readonly>
                    </div>
                </div>
            </div>
            <!-- END OF PERSONAL INFO -->

            <!-- START OF ACCOUNT INFO -->
            <div class="account-info">
                <div class="box-container">
                    <div class="box">
                        <label for="email">EMAIL</label>
                        <input type="text" value="<?php echo $email; ?>" readonly>
                    </div>
                    <div class="box">
                        <label for="pass">PASSWORD</label>
                        <button class="change-pass" id="change-btn">
                            <img src="img/link.png" alt="Link">
                            <p>CHANGE PASSWORD</p>
                        </button>
                    </div>
                </div>
            </div>
            <!-- END OF ACCOUNT INFO -->

        </div>
        <!-- END OF INFO CONTAINER -->

    </section>
    <!-- END OF MAIN PANEL -->

    <!-- START OF PROFILE POPUP -->
    <div id="editProfile" class="popup">
        <div class="popup-container">
            <div class="popup-content">
                <div class="popup-title">
                    <h1>UPDATE PROFILE</h1>
                    <p>Fill out the required fields.</p>
                </div>
                
                <div class="popup-line"></div>
                <div class="popup-form">
                    <form action="user_profile.php" method="post">
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
                        <div class="popup-btn">
                            <button name="update" type="submit" class="edit-btn">UPDATE</button>
                            <button class="cancel-btn" type="button" onclick="closeProfilePopup()">CANCEL</button>
                        </div>

                        <!-- UPDATE PROFILE -->  
                        <?php
                            include('include/db_connect.php');

                            if (isset($_POST['update'])) {
                                if (!isset($_SESSION['email'])) {
                                    echo "<script>alert('User not logged in.'); window.location.href = 'login.php';</script>";
                                    exit;
                                }

                                $email = $_SESSION['email'];

                                // Securely fetch user_id
                                $query = "SELECT user_id FROM user WHERE email = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("s", $email);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                
                                if ($row = $result->fetch_assoc()) {
                                    $id = $row['user_id'];
                                } else {
                                    echo "<script>alert('User not found!');</script>";
                                    exit;
                                }

                                $stmt->close();

                                // Sanitize inputs
                                $up_name = trim($_POST['name']);
                                $up_email = trim($_POST['email']);
                                $up_contactNum = trim($_POST['contactNum']);
                                $up_address = trim($_POST['address']);

                                // Update user profile securely
                                $sql = "UPDATE user SET name=?, email=?, contactNum=?, address=? WHERE user_id=?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("ssssi", $up_name, $up_email, $up_contactNum, $up_address, $id);

                                if ($stmt->execute()) {
                                    echo "<script>
                                            alert('Profile updated successfully!');
                                            window.location.href = 'user_profile.php';
                                        </script>";
                                } else {
                                    echo "<script>alert('Error updating profile: " . $stmt->error . "');</script>";
                                }

                                $stmt->close();
                            }
                        ?>
                        <!-- UPDATE PROFILE -->  

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF RPOFILE POPUP -->

    <!-- START OF CHANGE POPUP -->
    <div id="changePass" class="popup">
        <div class="popup-container">
            <div class="popup-content">
                <div class="popup-title">
                    <h1>CHANGE PASSWORD</h1>
                    <p>Fill out the required fields.</p>
                </div>
                <div class="popup-line"></div>
                <div class="popup-form">
                    <form action="user_profile.php" method="post">
                        <div class="box">
                            <label for="newPass">NEW PASSWORD</label>
                            <input name="pass" type="password" placeholder="Enter New Password" minlength="8" maxlength="16" required>
                        </div>
                        <div class="popup-btn">
                            <button name="reset" type="submit" class="edit-btn">UPDATE</button>
                            <button class="cancel-btn" type="button" onclick="closeChangePopup()">CANCEL</button>

                        <!-- CHANGE PASSWORD -->    
                        <?php
                            include('include/db_connect.php');
                            
                            if (isset($_POST['reset'])) {
                                if (!isset($_SESSION['email'])) {
                                    echo "<script>alert('User not logged in.'); window.location.href = 'login.php';</script>";
                                    exit;
                                }
                            
                                $email = $_SESSION['email']; 
                                $new_password = trim($_POST['pass']);
                            
                                // Validate password length
                                if (strlen($new_password) < 8 || strlen($new_password) > 16) {
                                    echo "<script>alert('Password must be between 8 and 16 characters.');</script>";
                                    exit;
                                }
                            
                                // Hash the new password
                                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                            
                                // Update password in the database
                                $query = "UPDATE user SET pass = ? WHERE email = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("ss", $hashed_password, $email);
                            
                                if ($stmt->execute()) {
                                    echo "<script>
                                            alert('Password updated successfully!');
                                            window.location.href = 'user_profile.php';
                                        </script>";
                                } else {
                                    echo "<script>alert('Error updating password: " . $stmt->error . "');</script>";
                                }
                            
                                $stmt->close();
                                $conn->close();
                            }
                        ?>
                        <!-- CHANGE PASSWORD -->  
                        
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF CHANGE POPUP -->

    <script src="js/user_profile.js"></script>

</body>
</html>