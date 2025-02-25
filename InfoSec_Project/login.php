<?php
    include('include/db_connect.php');

    session_start();

    if (isset($_POST['login'])) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

            $_SESSION['email'] = $email;

            $password = trim($_POST['pass']);
            $errors = array();

            // Validate email
            if (empty($email)) {
                array_push($errors, "Email is required.");
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Invalid email format.");
            }

            // Validate password
            if (empty($password)) {
                array_push($errors, "Password is required.");
            } elseif (strlen($password) < 8 || strlen($password) > 16) {
                array_push($errors, "Password must be between 8 and 16 characters.");
            }

            // Check credentials in the database
            try {
                $stmt = $conn->prepare("SELECT user_id, email, pass, role FROM user WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                $stmt->close();
            } catch (mysqli_sql_exception $e) {
                echo "Failed to connect: " . $e->getMessage();
            }

            // If user is found and password matches
            if ($user) {
                if (password_verify($password, $user['pass'])) {
                    $_SESSION['valid'] = $user['user_id'];
                    $_SESSION['role'] = $user['role'];

                    if (count($errors) == 0) {
                        header("Location: login.php?success=true&role=" . $_SESSION['role']);
                        exit();
                    }

                } else {
                    array_push($errors, "Incorrect Password. Try another combination.");
                }
            } else {
                array_push($errors, "The email address provided is not registered.");
            }

            // Handle errors
            if (count($errors) > 0) {
                $error_string = urlencode(implode("\n", $errors));
                header("Location: login.php?error=$error_string");
                exit();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/message.css">
</head>
<body>

    <!-- START OF RETURN -->
    <div class="return">
        <a href="index.php">
            <img src="img/return_peach.png" alt="return">
        </a>
    </div>
    <!-- END OF RETURN -->

    <!-- START OF LOGIN SECTION -->
    <section class="form-section">

        <!-- START OF LOGIN DETAILS -->
        <div class="details">
            <img src="img/logo.png" alt="Logo" class="logo">
            <h1><span>PAWPAL</span> CLINIC</h1>
            <p>"This is where pets find healing and love.”</p>
            <img src="img/form_img.png" alt="Form Animals" class="form-img">
        </div>
        <!-- END OF LOGIN DETAILS -->

        <!-- START OF LOGIN FORM -->
        <div class="form-container">
            <form action="" method="post">
                <h1>Login</h1>
                <p>Welcome back! Please enter your details.</p>
    
                <div class="input-box">
                    <input name="email" type="email" placeholder="Email" maxlength="255" required>
                </div>
                
                <div class="input-box">
                    <input name="pass" type="password" placeholder="Password" minlength="8" maxlength="16" required>
                </div>
                
                <button name="login" id="login" type="submit">Login</button>
    
                <div class="link">
                    <p>Don't have an account? <a href="register.php">Sign Up</a></p>
                </div>
            </form>
        </div>
        <!-- END OF LOGIN FORM -->
         
    </section>
    <!-- END OF LOGIN SECTION-->

    <!-- START OF SUCCESS POPUP -->
    <div class="message-container success" id="successPopup">
        <div class="message-box success">
            <div class="title success">
                <h1>LOGIN SUCCESSFUL</h1>
            </div>
            <div class="message success">
                <p>
                    You have successfully logged into your account. <br>
                </p>
            </div>
            <a href="#"><button class="btn" id="loginContinueBtn">CONTINUE</button></a>
        </div>
    </div>
    <!-- END OF SUCCESS POPUP -->

    <!-- START OF ERROR POPUP -->
    <div class="message-container error" id="errorPopup">
        <div class="message-box">
            <div class="title error">
                <h1>LOGIN FAILED</h1>
            </div>
            <div class="message error" id="errorMessage">
                <p></p>
            </div>
            <a href="login.php"><button class="btn" id="errorCloseBtn">TRY AGAIN</button></a>
        </div>
    </div>
    <!-- END OF ERROR POPUP -->

    <script src="js/message.js"></script>
    <script src="js/login.js"></script>

</body>
</html>