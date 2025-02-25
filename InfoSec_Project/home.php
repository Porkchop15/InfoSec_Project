<?php
    // SESSION HANDLING
    session_start();
    if(!isset($_SESSION['valid'])) {
        header("Location: index.php");
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
    <title>HOME</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/popup.css">
</head>
<body>
    <!-- START OF HEADER -->
    <header class="header-container">
        <div class="header">
            <div class="logo">
                <a href="home.php#home-section" class="logo_link">
                    <img src="img/logo.png" alt="Logo">
                    <p><span>PAWPAL</span> CLINIC</p>
                </a>
            </div>
            <div class="middle-links">
                <a href="home.php#home-section">HOME</a>
                <a href="home.php#home-services">SERVICES</a>
                <a href="home.php#home-hiw">HOW IT WORKS</a>
                <a href="home.php#home-contact">CONTACT</a>
            </div>
            <div class="dropdown">
                <button>
                    <img src="img/user_orange.png" alt="User">
                </button>
                <div class="drpd-content">
                    <a href="user_dashboard.php">
                        <img src="img/user_orange.png" alt="User">
                        <p>My Portal</p>
                    </a>
                    <a href="user_pets.php">
                        <img src="img/paws_orange.png" alt="Pet Profile">
                        <p>Pets Profile</p>
                    </a>
                    <a href="user_appointments.php">
                        <img src="img/appointment_orange.png" alt="Appointment">
                        <p>Appointments</p>
                    </a>
                    <a href="logout.php" class="drpd-logout">
                        <img src="img/logout_white.png" alt="Logout">
                        <p>Logout</p>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <!-- END OF HEADER -->

    <!-- START OF HOME SECTION -->
    <section class="home-section" id="home-section">

        <!-- START OF HERO -->
        <div class="home-hero">
            <img src="img/logo.png" alt="Logo" class="logo">
            <p>WELCOME TO <span>PAWPAL</span> CLINIC</p>
            <h1>We offer best care services to our little friends</h1>
            <a href="user_appointments.php">
                <button class="book-appointment-btn">BOOK APPOINTMENT</button>
            </a>
            <img src="img/hero_img.png" alt="Hero Animal" class="animal-hero">

        </div>
        <!-- END OF HERO -->

        <!-- START OF SERVICES -->
        <div class="home-services" id="home-services">
            <h1>SERVICES</h1>
            <p>At PawPal Clinic, we offer a wide range of services to keep your pets healthy and happy.</p>
            <div class="services-container">
                <div class="services-box">
                    <img src="img/service_1.png" alt="Pet Grooming">
                    <h1>Pet Grooming</h1>
                    <p>Professional grooming for all breeds, including baths, haircuts, nail trims, and ear cleaning</p>
                    <a href="user_appointments.php">
                        <button class="book-appointment-btn">BOOK APPOINTMENT</button>
                    </a>
                </div>
                <div class="services-box">
                    <img src="img/service_2.png" alt="Vet Consultations">
                    <h1>Vet Consultations</h1>
                    <p>Receive expert veterinary care for routine check-ups, illness diagnosis, and comprehensive treatment</p>
                    <a href="user_appointments.php">
                        <button class="book-appointment-btn">BOOK APPOINTMENT</button>
                    </a>
                </div>
            </div>
            <img src="img/service_img.png" alt="Service Animals" class="animal-services">
        </div>
        <!-- END OF SERVICES -->

        <!-- START OF HOW IT WORKS -->
        <div class="home-hiw" id="home-hiw">
            <h1>HOW IT WORKS</h1> 
            <p>At PawPal Clinic, we make caring for your pets easy and stress-free with our streamlined process. <br> Whether you're looking for pet grooming or veterinary consultations, we've got you covered.</p>
            <div class="hiw-content">
                <img src="img/hiw_img.png" alt="HIW Animals">
                <div class="hiw-container">
                    <div class="hiw-box">
                        <h1 class="step">STEP 1</h1>
                        <img src="img/step_1.png" alt="Create Pet Profile">
                        <h1>CREATE PET PROFILE</h1>
                        <p>Provide basic details about your pet to set up their profile.</p>
                        <a href="user_pets.php">
                            <button id="pet-profile-btn">CREATE PET PROFILE</button>
                        </a>
                    </div>
                    <div class="hiw-box">
                        <h1 class="step">STEP 2</h1>
                        <img src="img/step_2.png" alt="Book Appointment">
                        <h1>BOOK APPOINTMENT</h1>
                        <p>Choose a service, date, and time that suits you</p>
                        <a href="user_appointments.php">
                        <button class="book-appointment-btn">BOOK APPOINTMENT</button>
                        </a>
                    </div>
                    <div class="hiw-box">
                        <h1 class="step">STEP 3</h1>
                        <img src="img/step_3.png" alt="Visit PawPal Clinic">
                        <h1>VISIT PAWPAL CLINIC</h1>
                        <p>Bring your pet to PawPal Clinic for their grooming or vet consultation.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END OF HOW IT WORKS -->

        <!-- START OF CONTACT -->
        <div class="home-contact" id="home-contact">
            <h1>WE'D LOVE TO HEAR FROM YOU!</h1> 
            <p>Whether you have questions about our services, need to book an appointment, or want to provide feedback, feel free to reach out. </p>
            <div class="contact-content">
                <div class="social-container">
                    <img src="img/social_1.png" alt="Facebook">
                    <img src="img/social_2.png" alt="WhatsApp">
                    <img src="img/social_3.png" alt="Instagram">
                    <img src="img/social_4.png" alt="Tiktok">
                </div>
                <img src="img/contact_img.png" alt="Contact Dog">
            </div>
        </div>
        <!-- END OF CONTACT -->
    </section>
    <!-- END OF HOME SECTION -->

    <!-- START OF FOOTER -->
    <footer>
        <a href="index.php#index-section"><img src="img/logo.png" alt="Logo"></a>
        <div class="footer-links">
            <a href="home.php#home-section">HOME</a>
            <a href="home.php#home-services">SERVICES</a>
            <a href="home.php#home-hiw">HOW IT WORKS</a>
            <a href="home.php#home-contact">CONTACT</a>
            <a href="user_appointments.php">APPOINTMENT</a>
            <a href="user_dashboard.php">MY PORTAL</a>
        </div>
        <div class="line">
        </div>
        <p>© 2025 PawPal Clinic. All rights reserved.</p>
    </footer>
    <!-- END OF FOOTER -->




    <script src="js/home.js"></script>
</body>
</html>