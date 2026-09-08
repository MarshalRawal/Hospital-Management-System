<?php
// 1. Start Session & Verify Authentication (The Bouncer)
session_start();

if (!isset($_SESSION['logged_in']) || strtolower($_SESSION['role']) !== 'patient') {
    header("Location: login.php");
    exit();
}

// 2. Connect to Database & Load the Custom Logged-In Header
require_once 'db_connect.php';
include 'dashboard_header.php';

// 3. Securely Fetch the Patient's Data
$user_id = $_SESSION['user_id'];
$patient_data = [];

// Prepare the SQL statement to grab their specific data
$stmt = $conn->prepare("SELECT first_name, last_name FROM patients WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $patient_data = $result->fetch_assoc();
} else {
    die("<div style='text-align:center; margin-top:2rem; color:red;'>Database Error: Profile not found.</div>");
}
$stmt->close();
?>

<!-- UI / Frontend Design starts here -->
<style>
    .container {
        max-width: 1000px;
        margin: 2.5rem auto;
        padding: 0 1.5rem;
    }

    /* Elegant Gradient Banner */
    .dashboard-banner {
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
        margin-bottom: 2.5rem;
        border: 1px solid #7dd3fc;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .banner-title {
        font-size: 1.85rem;
        font-weight: 700;
        color: #0369a1;
        margin-bottom: 0.5rem;
        letter-spacing: -0.01em;
    }

    .banner-text {
        color: #0284c7;
        font-size: 1.05rem;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.75rem;
    }

    /* Polished Panels */
    .panel {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .panel:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px -3px rgba(0, 0, 0, 0.08);
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }

    .panel-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #0f172a;
    }

    /* Styled Empty States with subtle icons */
    .empty-state {
        text-align: center;
        padding: 1.5rem 1rem;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px dashed #cbd5e1;
        color: #64748b;
    }

    /* New Icon Wrapper for a premium look */
    .icon-wrapper {
        width: 64px;
        height: 64px;
        background: #e0f2fe;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem auto;
    }

    .empty-icon {
        width: 32px;
        height: 32px;
        color: #0284c7;
    }

    .empty-text {
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    /* Beautiful Action Button */
    .btn-primary {
        display: inline-block;
        background-color: #0284c7;
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(2, 132, 199, 0.2);
    }

    .btn-primary:hover {
        background-color: #0369a1;
        box-shadow: 0 4px 6px rgba(2, 132, 199, 0.3);
    }

    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container">

    <div class="dashboard-banner">
        <h2 class="banner-title">Welcome back, <?php echo htmlspecialchars($patient_data['first_name']); ?>!</h2>
        <p class="banner-text">Manage your upcoming appointments and access your clinical diagnoses.</p>
    </div>

    <div class="dashboard-grid">

        <!-- Appointments Panel -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">My Appointments</div>
            </div>
            <div class="empty-state">
                <div class="icon-wrapper">
                    <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>
                </div>
                <div class="empty-text">No upcoming appointments scheduled.<br>Secure your spot today.</div>
                <a href="book_appointment.php" class="btn-primary">Book Now</a>
            </div>
        </div>

        <!-- Diagnosis & Prescription Panel -->
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Medical Records</div>
            </div>

            <div class="empty-state">
                <div class="icon-wrapper">
                    <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <div class="empty-text">No diagnoses or prescriptions on file.<br>Records will appear here after a visit.</div>
            </div>
        </div>

    </div>
</div>
</body>

</html>