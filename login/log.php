<?php
session_start();

// Initialize session variables
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_time'] = null;
}
//hello world!
// Check if the user is already connected
if (isset($_SESSION["connected"]) && $_SESSION["connected"]) {
    switch ($_SESSION["role"]) {
        case "prop":
            $_SESSION["username"] = "prop";
            $_SESSION["password"] = "proprietaire";
            header("location:../proprietaire/prop.php");
            break;
        case "admin":
            $_SESSION["username"] = "admin";
            $_SESSION["password"] = "admin";
            header("location:../admin/admin.php");
            break;
        case "agent":
            $_SESSION["username"] = "agent";
            $_SESSION["password"] = "agent47";
            header("location:../agent/agent.php");
            break;
        case "locataire":
            $_SESSION["username"] = "locataire";
            $_SESSION["password"] = "locataire00";
            header("location:../locataire/loc.php");
            break;
    }
} else {
    // Process login form
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
		$_SESSION["pass"]=$password;
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Validate e-mail
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            echo("<script>alert(\"$email is not a valid email address\");</script>");
            header("location:log.php");
            exit;
        }
		$_SESSION["email"] = $email;
        // Database connection
        $host = 'localhost:3306';
        $dbname = 'gestion_immobiliere';
        $username = 'root';
        $dbPassword = 'ismailo1801997065';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }

        // Query user data
        try {
            $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email=:mail");
            $stmt->bindParam(':mail', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<script>alert(\"Email does not exist\")</script>";
            header("location:log.php");
            exit;
        }

        // Maximum attempts before lockout
        $maxAttempts = 3;
        $lockoutDuration = 300; // Lockout duration in seconds (5 minutes)
        $currentTime = time();

        // Check if user is locked out
        if ($_SESSION['lockout_time'] && $currentTime < $_SESSION['lockout_time']) {
            $remainingTime = $_SESSION['lockout_time'] - $currentTime;
            die("You are temporarily locked out. Please try again in $remainingTime seconds.");
        }

		$password=$_SESSION["pass"];
        // Validate login
        $isValidLogin = ($password === $user['password']);

        if ($isValidLogin) {
            // Reset attempts and lockout time
            $_SESSION['login_attempts'] = 0;
            $_SESSION['lockout_time'] = null;
            $_SESSION["connected"] = true;
            $_SESSION["role"] = $user["role"];

            // Redirect to the appropriate page based on user role
            switch ($_SESSION["role"]) {
                case "prop":
                    header("location:../proprietaire/prop.php");
                    break;
                case "admin":
                    header("location:../admin/admin.php");
                    break;
                case "agent":
                    header("location:../agent/agent.php");
                    break;
                case "locataire":
                    header("location:../locataire/loc.php");
                    break;
            }
        } else {
            // Increment attempts on failed login
            $_SESSION['login_attempts']++;

            if ($_SESSION['login_attempts'] >= $maxAttempts) {
                // Lock the user out for 5 minutes
                $_SESSION['lockout_time'] = $currentTime + $lockoutDuration;
                echo("<script>alert(\"Too many failed login attempts. You are locked out for 5 minutes.\")</script>");
            } else {
                $remainingAttempts = $maxAttempts - $_SESSION['login_attempts'];
                echo "<script>alert(\"Invalid login. You have $remainingAttempts attempt(s) left.\")</script>";
            }
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
    <style>
        #sub {
            border-radius: 20px;
            border: 1px solid #FF4B2B;
            background-color: #FF4B2B;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in;
        }
        #sub.ghost {
            background-color: transparent;
            border-color: #FFFFFF;
        }
        #sub:active {
            transform: scale(0.95);
        }
        #sub:focus {
            outline: none;
        }
    </style>
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
                <button id="sub" type="submit">Sign Up</button>
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


