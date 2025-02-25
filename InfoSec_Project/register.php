<?php
    include('include/db_connect.php');

    session_start();

    if (isset($_POST['register'])) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $contactNum = htmlspecialchars(trim($_POST['contactNum']));
            $address = htmlspecialchars(trim($_POST['address']));
            $pass = trim($_POST['pass']);
            $conPass = trim($_POST['conPass']);
            $errors = array();

            // Name Validation
            $name_pattern = "/^[a-zA-Z]+(?:[-' ][a-zA-Z]+)*(?: [a-zA-Z](?:\\.|[-' ][a-zA-Z]+)*)?$/";
            if (!preg_match($name_pattern, $name)) {
                array_push($errors, "Invalid name given. Use 'FN MI LN' format.");
            }

            // Email Validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Invalid email format.");
            }

            // Contact Number Validation
            if (strlen($contactNum) != 11) {
                array_push($errors, "Contact Number must be 11 digits.");
            }

            // Address Validation
            if (strlen($address) < 5 || strlen($address) > 255) {
                array_push($errors, "Address is required and must be between 5 and 255 characters.");
            }

            // Password Validation
            if ($pass !== $conPass) {
                array_push($errors, "Passwords do not match.");
            } elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/", $pass)) {
                array_push($errors, "Password must be 8-16 characters with uppercase, lowercase, number, and special character.");
            }

            try {
                $stmt = $conn->prepare("SELECT email FROM user WHERE email = ? LIMIT 1");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
            } catch (mysqli_sql_exception) {
                echo "Failed to connect";
            }

            if ($user) {
                array_push($errors, "Email already exists.");
            }

            if (count($errors) == 0) {
                try {
                    $pass = password_hash($pass, PASSWORD_DEFAULT);
                    $role_based = "client"; //set role to user once registered in website
                    $stmt = $conn->prepare("INSERT INTO user (name, email, contactNum, address, pass, role) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $name, $email, $contactNum, $address, $pass, $role_based);
                    $stmt->execute();
                } catch (mysqli_sql_exception) {
                    echo "Failed to connect";
                }

                header("Location: register.php?success=true");
                exit();
            }

            if (count($errors) > 0) {
                $error_string = urlencode(implode("\n", $errors));
                header("Location: register.php?error=$error_string");
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
    <title>REGISTER</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/message.css">
</head>
<body>
    <!-- START OF RETURN -->
    <div class="return">
        <a href="index.php">
            <img src="img/return_peach.png" alt="Return">
        </a>
    </div>
    <!-- END OF RETURN -->
    
    <!-- START OF REGISTER SECTION -->
    <section class="form-section">

        <!-- START OF REGISTER DETAILS -->
        <div class="details">
            <img src="img/logo.png" alt="Logo" class="logo">
            <h1><span>PAWPAL</span> CLINIC</h1>
            <p>"This is where pets find healing and love.”</p>
            <img src="img/form_img.png" alt="Form Animals" class="form-img">
        </div>
        <!-- END OF REGISTER DETAILS -->

        <!-- START OF REGISTER FORM -->
        <div class="form-container">
            <form method="post" action="register.php">
    
                <h1>Sign Up</h1>
                <p>Please enter your details to register.</p>
    
                <div class="input-box">
                    <input name="name" type="text" placeholder="Name" minlength="3" maxlength="255" required>
                </div>
    
                <div class="input-box">
                    <input name="email" type="email" placeholder="Email" maxlength="255" required>
                </div>
    
                <div class="input-box">
                    <input name="contactNum" type="number" placeholder="Contact Number" minlength="11" maxlength="11" required>
                </div>

                <div class="input-box">
                    <input name="address" type="text" placeholder="Address" maxlength="255" required>
                </div>
                
                <div class="input-box">
                    <input name="pass" type="password" placeholder="Password" minlength="8" maxlength="16" required>
                </div>
    
                <div class="input-box">
                    <input name="conPass" type="password" placeholder="Confirm Password" minlength="8" maxlength="16" required>
                </div>
                
                <button name="register" type="submit" class="btn">Register</button>
    
                <div class="link">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </div>
            </form>
        </div>
        <!-- END OF REGISTER FORM -->
         
    </section>
    <!-- END OF REGISTER SECTION -->

    <!-- START OF SUCCESS POPUP -->
    <div class="message-container success" id="successPopup">
        <div class="message-box success">
            <div class="title success">
                <h1>REGISTRATION SUCCESSFUL</h1>
            </div>
            <div class="message success">
                <p>
                    You have successfully created your account. <br>
                </p>
            </div>
            <a href="login.php"><button class="btn">CONTINUE</button></a>
        </div>
    </div>
    <!-- END OF SUCCESS POPUP -->

    <!-- START OF ERROR POPUP -->
    <div id="errorPopup" class="message-container error">
        <div class="message-box">
            <div class="title error">
                <h1>REGISTRATION FAILED</h1>
            </div>
            <div class="message error" id="errorMessage">
                <p></p>
            </div>
            <a href="register.php"><button class="btn" id="errorCloseBtn">TRY AGAIN</button></a>
        </div>
    </div>
    <!-- END OF ERROR POPUP -->

    <script src="js/message.js"></script>

</body>
</html>