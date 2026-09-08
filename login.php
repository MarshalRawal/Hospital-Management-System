<?php
// 1. Start the Session (Crucial for keeping users logged in)
session_start();

include 'header.php';
require_once 'db_connect.php';

$message = "";

// 2. Check if the login form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_login'])) {

    // Grab the submitted data
    $email = trim($_POST['email']);
    $raw_password = $_POST['password'];
    // 3. Prepare the SQL to find the user by email (Fixed: user_id instead of id)
    $stmt = $conn->prepare("SELECT user_id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // 4. Check if a user with that email exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // 5. Verify the password using PHP's native checker
        if (password_verify($raw_password, $user['password'])) {

            // Password is correct! Set session variables (Fixed: $user['user_id'])
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;

            // 6. Role-Based Access Control (RBAC) Redirection
            // Added strtolower() to safely handle "Patient" vs "patient" from the database
            $safe_role = strtolower($user['role']);

            if ($safe_role === 'patient') {
                header("Location: patient_dashboard.php");
            } elseif ($safe_role === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: doctor_dashboard.php");
            }
            exit(); // Stop the script immediately after redirecting

        } else {
            $message = "<div class='alert alert-error'>Invalid email or password.</div>";
        }
    } else {
        $message = "<div class='alert alert-error'>Invalid email or password.</div>";
    }
    $stmt->close();
}
?>

<!-- Import Google's Premium 'Inter' Font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 4rem 2rem;
        min-height: 80vh;
        font-family: 'Inter', sans-serif;
    }

    .form-container {
        width: 100%;
        max-width: 450px;
    }

    .form-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .form-header h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .form-header p {
        color: #64748b;
        font-size: 1rem;
    }

    .form-card {
        background-color: #ffffff;
        padding: 2.5rem;
        border-radius: 16px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        border: 1px solid #e2e8f0;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        position: relative;
        margin-bottom: 1.25rem;
    }

    label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
    }

    input {
        padding: 0.85rem 1rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.95rem;
        font-family: 'Inter', sans-serif;
        outline: none;
        transition: all 0.2s ease;
        width: 100%;
        color: #1e293b;
        background-color: #f8fafc;
    }

    input:focus {
        border-color: #2563eb;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        top: 35px;
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }

    .toggle-password:hover {
        color: #2563eb;
    }

    .toggle-password svg {
        width: 20px;
        height: 20px;
    }

    .btn-solid {
        width: 100%;
        margin-top: 1rem;
        padding: 0.85rem;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .alert-error {
        color: #991b1b;
        background-color: #fee2e2;
        border: 1px solid #fecaca;
    }

    .signup-link {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.9rem;
        color: #64748b;
    }

    .signup-link a {
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
    }

    .signup-link a:hover {
        text-decoration: underline;
    }
</style>

<div class="login-wrapper">
    <div class="form-container">
        <div class="form-header">
            <h2>Welcome Back</h2>
            <p>Please enter your credentials to log in.</p>
        </div>

        <?php echo $message; ?>

        <form class="form-card" method="POST" action="login.php">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="john@email.com" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" id="login_password" name="password" required>
                <button type="button" class="toggle-password" onclick="toggleLoginVisibility()">
                    <svg id="eye-icon-login" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <svg id="eye-slash-login" style="display: none;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                </button>
            </div>

            <button type="submit" name="submit_login" class="btn btn-solid">Secure Log In &rarr;</button>

            <div class="signup-link">
                Don't have an account? <a href="register.php">Create one here</a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleLoginVisibility() {
        const inputField = document.getElementById('login_password');
        const eyeOpen = document.getElementById('eye-icon-login');
        const eyeClosed = document.getElementById('eye-slash-login');

        if (inputField.type === 'password') {
            inputField.type = 'text';
            eyeOpen.style.display = 'none';
            eyeClosed.style.display = 'block';
        } else {
            inputField.type = 'password';
            eyeOpen.style.display = 'block';
            eyeClosed.style.display = 'none';
        }
    }
</script>
</body>

</html>