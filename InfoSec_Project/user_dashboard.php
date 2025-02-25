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
    <title>USER DASHBOARD</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
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
                <img src="img/dashboard_peach.png" alt="Dashboard">                
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
                <img src="img/appointment_white.png" alt="Appointment">
                <p>Appointments</p>
            </a>
        </div>
    </section> 
    <!-- END OF SIDE BAR -->

    <!-- START OF MAIN PANEL -->
    <section class="main-panel">

        <!-- START OF TRAIL -->
        <div class="trail">
            <a href="home.php">HOME /</a>
            <a href="user_dashboard.php" class="current">DASHBOARD</a>
        </div>
        <!-- END OF TRAIL -->

        <!-- START OF WELCOME -->
        <div class="welcome">
            <h1>Welcome, Client!</h1>
            <p>Let's make today a pawfect day for grooming and veterinary care. <br> Explore your client tools to get started.</p>
            <img src="img/dashboard_welcome.png" alt="User Hello">
        </div>
        <!-- END OF WELCOME -->

        <!-- START OF QUICK LINKS -->
        <div class="quick-links">
            <h1 class="title">QUICK LINKS</h1>
            <div class="link-container">
                <a href="user_profile.php" class="link">
                    <img src="img/user_white.png" alt="Profile">
                    <h1>MANAGE MY ACCOUNT</h1>
                    <p>Update your personal information</p>
                </a>
                <a href="user_pets.php" class="link">
                    <img src="img/paws_white.png" alt="Pet Profile">
                    <h1>MANAGE PET PROFILES</h1>
                    <p>Create and update your pet's records</p>
                </a>
                <a href="user_appointments.php" class="link">
                    <img src="img/appointment_white.png" alt="Appoinment">
                    <h1>MANAGE APPOINTMENTS</h1>
                    <p>Book and modify your pet's appointments</p>
                </a>
            </div>
        </div>
        <!-- END OF QUICK LINKS -->

    </section>
    <!-- END OF MAIN PANEL -->
</body>
</html>