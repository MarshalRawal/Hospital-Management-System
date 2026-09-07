<?php
include 'header.php';
require_once 'db_connect.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_registration'])) {

    // 1. Capture Form Data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $blood_group = $_POST['blood_group'];
    $raw_password = $_POST['password'];

    // 2. Hash the password for security
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    // 3. Begin Transaction (Crucial for relational databases)
    $conn->begin_transaction();

    try {
        // Step A: Insert login credentials into the `users` table
        // Note: Assuming a 'role' column exists, defaulting to 'patient'
        $stmt1 = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, 'patient')");
        $stmt1->bind_param("ss", $email, $hashed_password);
        $stmt1->execute();

        // Step B: Retrieve the auto-generated ID of that new user
        $new_user_id = $conn->insert_id;

        // Step C: Insert profile data into the `patients` table, linking it via user_id
        $stmt2 = $conn->prepare("INSERT INTO patients (user_id, first_name, last_name, date_of_birth, gender, blood_group, contact) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param("issssss", $new_user_id, $first_name, $last_name, $dob, $gender, $blood_group, $contact);
        $stmt2->execute();

        // Step D: If both queries succeeded, commit the changes permanently
        $conn->commit();

        $message = "<div style='color: #166534; background-color: #dcfce3; padding: 1rem; border-radius: 8px; text-align: center; margin-bottom: 1.5rem; border: 1px solid #bbf7d0;'>Account created successfully! You can now log in.</div>";

        $stmt1->close();
        $stmt2->close();
    } catch (Exception $e) {
        // If anything fails, rollback the entire transaction to prevent orphan records
        $conn->rollback();
        $message = "<div style='color: #991b1b; background-color: #fee2e2; padding: 1rem; border-radius: 8px; text-align: center; margin-bottom: 1.5rem; border: 1px solid #fecaca;'>Registration Failed: " . $e->getMessage() . "</div>";
    }
}
?>

<!-- Import Google's Premium 'Inter' Font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Specific CSS just for the Registration Page */
    .register-wrapper {
        display: flex;
        justify-content: center;
        padding: 3rem 2rem;
        min-height: 80vh;
        font-family: 'Inter', sans-serif;
    }

    .form-container {
        width: 100%;
        max-width: 800px;
    }

    .form-header {
        text-align: center;
        margin-bottom: 2.5rem;
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
        padding: 3rem;
        border-radius: 16px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        border: 1px solid #e2e8f0;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.75rem;
    }

    .full-width {
        grid-column: span 2;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        position: relative;
    }

    label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
    }

    input,
    select {
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

    input:focus,
    select:focus {
        border-color: #2563eb;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        top: 38px;
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

    .section-title {
        grid-column: span 2;
        font-size: 1.15rem;
        font-weight: 600;
        color: #0f172a;
        margin-top: 1rem;
        margin-bottom: -0.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .button-group {
        grid-column: span 2;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .full-width,
        .section-title,
        .button-group {
            grid-column: span 1;
        }

        .register-wrapper {
            padding: 2rem 1rem;
        }

        .form-card {
            padding: 1.5rem;
        }
    }
</style>

<div class="register-wrapper">
    <div class="form-container">
        <div class="form-header">
            <h2>Create your patient account</h2>
            <p>Fill in your details below to join the system.</p>
        </div>

        <!-- Display Success or Error Message -->
        <?php echo $message; ?>

        <form class="form-card" id="registrationForm" method="POST" action="register.php">
            <div class="form-grid">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" placeholder="John" required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" placeholder="Doe" required>
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" required>
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" required>
                        <option value="" disabled selected>Select...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="john@email.com" required>
                </div>
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="tel" name="contact" placeholder="+1 (555) 000-0000" required>
                </div>
                <div class="form-group full-width">
                    <label>Blood Group (Optional)</label>
                    <select name="blood_group">
                        <option value="" selected>Select...</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                </div>
                <div class="section-title">Set a password</div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password" name="password" required>
                    <button type="button" class="toggle-password" onclick="toggleVisibility('password', 'eye-icon-1', 'eye-slash-1')">
                        <svg id="eye-icon-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg id="eye-slash-1" style="display: none;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" id="confirm_password" required>
                    <button type="button" class="toggle-password" onclick="toggleVisibility('confirm_password', 'eye-icon-2', 'eye-slash-2')">
                        <svg id="eye-icon-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg id="eye-slash-2" style="display: none;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
                <div class="button-group">
                    <button type="button" class="btn btn-outline" onclick="window.location.href='index.php'">Cancel</button>
                    <button type="submit" name="submit_registration" class="btn btn-solid">Create Account &rarr;</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const form = document.getElementById('registrationForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');

    form.addEventListener('submit', function(event) {
        // 1. Grab all the input values
        const firstName = document.querySelector('input[name="first_name"]').value;
        const lastName = document.querySelector('input[name="last_name"]').value;
        const email = document.querySelector('input[name="email"]').value;
        const phone = document.querySelector('input[name="contact"]').value;
        const dob = document.querySelector('input[name="date_of_birth"]').value;

        // 2. Define Professional Regex Patterns
        const nameRegex = /^[a-zA-Z\s\-]{2,50}$/; // Only letters, spaces, and hyphens (2 to 50 chars)
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Standard email format (e.g., name@domain.com)
        const phoneRegex = /^[0-9]{10,15}$/; // Strictly 10 to 15 digits, no letters or symbols
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/; // 8 chars, 1 upper, 1 lower, 1 number

        // 3. Validate Names
        if (!nameRegex.test(firstName) || !nameRegex.test(lastName)) {
            event.preventDefault();
            alert("Validation Error: First and Last names can only contain letters and must be at least 2 characters.");
            return; // Stops the rest of the script from running
        }

        // 4. Validate Email
        if (!emailRegex.test(email)) {
            event.preventDefault();
            alert("Validation Error: Please enter a valid email address format.");
            return;
        }

        // 5. Validate Phone Number
        if (!phoneRegex.test(phone)) {
            event.preventDefault();
            alert("Validation Error: Contact number must contain only numbers (10 to 15 digits).");
            return;
        }

        // 6. Validate Date of Birth (No time travelers allowed)
        const today = new Date();
        const birthDate = new Date(dob);
        if (birthDate > today) {
            event.preventDefault();
            alert("Validation Error: Date of birth cannot be a future date.");
            return;
        }

        // 7. Validate Password Strength
        if (!passwordRegex.test(password.value)) {
            event.preventDefault();
            alert("Security Error: Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, and one number.");
            password.focus();
            return;
        }

        // 8. Validate Password Match
        if (password.value !== confirmPassword.value) {
            event.preventDefault();
            alert("Security Error: Passwords do not match! Please try again.");
            confirmPassword.focus();
            return;
        }
    });

    function toggleVisibility(inputId, eyeOpenId, eyeClosedId) {
        const inputField = document.getElementById(inputId);
        const eyeOpen = document.getElementById(eyeOpenId);
        const eyeClosed = document.getElementById(eyeClosedId);

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