<?php
session_start();

// Function to initialize login tracking
function initializeTracking($email) {
    if (!isset($_SESSION["connections"][$email])) {
        $_SESSION["connections"][$email] = ["login_attempts" => 0, "lockoutTime" => null];
    }
}

// Function to check lockout status
function isLockedOut($email) {
    $currentTime = time();
    return isset($_SESSION["connections"][$email]) &&
           $_SESSION["connections"][$email]["lockoutTime"] !== null &&
           $currentTime < $_SESSION["connections"][$email]["lockoutTime"];
}

// Database connection
$host = 'localhost:3306';
$dbname = 'gestion_immobiliere';
$username = 'admin';
$dbPassword = 'admin';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if user is logged in
if (isset($_SESSION["connected"]) && $_SESSION["connected"]) {
    $role = $_SESSION["role"];
    header("location:../$role/{$role}.php");
    exit;
}

// Process login form
if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    initializeTracking($email);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('$email is not a valid email address.');</script>";
        header("location:log.php");
        exit;
    }

    // Check lockout status
    if (isLockedOut($email)) {
        $remainingTime = $_SESSION["connections"][$email]["lockoutTime"] - time();
        echo "<script>alert('Locked out. Try again in $remainingTime seconds.');</script>";
        exit;
    }

    // Query user data
    try{
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email=:mail");
    $stmt->bindParam(':mail', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e) {   
    die("Connection failed: " . $e->getMessage());
}
    
    if (isset($user) && password_verify($password, $user["mot_de_passe"])) {
        $_SESSION["connections"][$email]["login_attempts"] = 0;
        $_SESSION["connections"][$email]["lockoutTime"] = null;
        $_SESSION["connected"] = true;
        $_SESSION["role"] = $user["role"];
        header("location:../{$user["role"]}/{$user["role"]}.php");
        exit;
    } else {
        $_SESSION["connections"][$email]["login_attempts"]++;
        if ($_SESSION["connections"][$email]["login_attempts"] >= 3) {
            $_SESSION["connections"][$email]["lockoutTime"] = time() + 300;
            echo "<script>alert('Too many failed attempts. Locked out for 5 minutes.');</script>";
        } else {
            $remainingAttempts = 3 - $_SESSION["connections"][$email]["login_attempts"];
            echo "<script>alert('Invalid login. $remainingAttempts attempt(s) left.');</script>";
            header("location: ../visit/visit.php ");
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="log.css">
    
</head>
<body style="background-image: url('build.jpg'); background-repeat: no-repeat; background-size: cover; " >
    <div class="container" id="container">
        <!-- Sign-Up Form -->
        <div class="form-container sign-up-container">
            <form action="register.php" method="POST">
                <h1>Create Account</h1>
                <span>Use your email for registration</span>
                <input type="text" placeholder="First Name" name="nom" required />
                <input type="text" placeholder="Last Name" name="prenom" required />
                <input type="email" placeholder="Email" name="email" required />
                <input type="text" placeholder="Phone number" name="phone" required />
                <input type="password" placeholder="Password" name="password" required />
                <button id="sub" type="submit" name="butt">Sign Up</button>
            </form>
        </div>

        <!-- Sign-In Form -->
        <div class="form-container sign-in-container">
            <form action="log.php" method="POST">
                <h1>Sign in</h1>
                <span>Use your account</span>
                <input type="email" placeholder="Email" name="email" required />
                <input type="password" placeholder="Password" name="password" required />
                <a href="#">Forgot your password?</a>
                <button id="sub" type="submit" name="connect">Sign In</button>
            </form>
        </div>

        <!-- Overlay Panels -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start your journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    </script>
</body>
</html>


