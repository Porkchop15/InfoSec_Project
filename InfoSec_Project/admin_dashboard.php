<?php   
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN DASHBOARD</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
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
                <img src="img/dashboard_peach.png" alt="Dashboard">                
                <p>Dashboard</p>
            </a>
            <a href="admin_clients.php" class="user">
                <img src="img/users_white.png" alt="Client">
                <p>Clients</p>
            </a>
            <a href="admin_pets.php" class="pet-profile">
                <img src="img/paws_white.png" alt="Pet Profile">
                <p>Pet Profiles</p>
            </a>
            <a href="admin_appointments.php" class="appointment">
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
            <a href="admin_dashboard.php">
                <p>DASHBOARD</p>
            </a>
        </div>
        <!-- END OF TRAIL -->

        <!-- START OF WELCOME -->
        <div class="welcome">
            <h1>Welcome, Admin!</h1>
            <p>Let's make today a pawfect day for grooming and veterinary care. <br> Explore your admin tools to get started.</p>
            <img src="img/dashboard_welcome.png" alt="Admin Hello">
        </div>
        <!-- END OF WELCOME -->

        <!-- START OF QUICK LINKS -->
        <div class="quick-links">
            <h1 class="title">QUICK LINKS</h1>
            <div class="link-container">
                <a href="admin_clients.php" class="link">
                    <img src="img/users_white.png" alt="Clients">
                    <h1>MANAGE CLIENTS</h1>
                    <p>Handle user accounts effortlessly</p>
                </a>
                <a href="admin_pets.php" class="link">
                    <img src="img/paws_white.png" alt="Pet Profiles">
                    <h1>MANAGE PET PROFILES</h1>
                    <p>Access and update pet client information</p>
                </a>
                <a href="admin_appointments.php" class="link">
                    <img src="img/appointment_white.png" alt="Appoinment">
                    <h1>MANAGE APPOINTMENTS</h1>
                    <p>Coordinate and manage clinic appointments</p>
                </a>
            </div>
        </div>
        <!-- END OF QUICK LINKS -->

    </section>
    <!-- END OF MAIN PANEL -->
</body>
</html>