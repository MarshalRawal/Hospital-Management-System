<?php
// 1. Start Session & Verify Authentication (The Admin Bouncer)
session_start();

if (!isset($_SESSION['logged_in']) || strtolower($_SESSION['role']) !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once 'db_connect.php';

// 2. Fetch Live Statistics for the Dashboard
$patient_query = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'patient'");
$total_patients = $patient_query->fetch_assoc()['count'];

$doctor_query = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'doctor'");
$total_doctors = $doctor_query->fetch_assoc()['count'];

$app_query = $conn->query("SELECT COUNT(*) as count FROM appointments");
$total_appointments = $app_query->fetch_assoc()['count'];

$completed_query = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE status = 'Completed'");
$completed_appointments = $completed_query->fetch_assoc()['count'];

// 3. Fetch the 5 most recent appointments for the preview table
$recent_apps_query = $conn->query("SELECT app_id, date, time_slot, reason, status FROM appointments ORDER BY app_id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | CareConnect</title>
    <!-- Import Google's Premium 'Inter' Font to match the rest of the site -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', Arial, sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: #333;
        }

        /* Unified CareConnect Header */
        .top-header {
            background-color: #ffffff;
            padding: 1rem 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .header-brand {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2563eb;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

      
        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-item {
            color: #64748b;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            transition: color 0.2s;
        }

        .nav-item:hover {
            color: #2563eb;
        }

        .btn-logout {
            background-color: #fef2f2;
            color: #ef4444;
            padding: 0.5rem 1.25rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            border: 1px solid #fecaca;
            margin-left: 10px;
        }

        .btn-logout:hover {
            background-color: #ef4444;
            color: white;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
            padding-bottom: 50px;
        }

        /* Banner */
        .dashboard-banner {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .dashboard-banner h2 {
            font-size: 24px;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .dashboard-banner p {
            color: #64748b;
            font-size: 16px;
        }

        /* Analytics Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 25px 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            border-top: 4px solid #2563eb;
        }

        .stat-title {
            font-size: 14px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 5px;
        }

        .stat-desc {
            font-size: 13px;
            color: #94a3b8;
        }

        .card-doctors {
            border-top-color: #0ea5e9;
        }

        .card-patients {
            border-top-color: #10b981;
        }

        .card-appointments {
            border-top-color: #8b5cf6;
        }

        .card-completed {
            border-top-color: #f59e0b;
        }

        /* Recent Appointments Table Styling */
        .table-container {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            border-top: 4px solid #1e293b;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-header h3 {
            font-size: 18px;
            color: #0f172a;
        }

        .view-all {
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .view-all:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
        }

        th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            color: #334155;
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .status-completed {
            background: #d1fae5;
            color: #059669;
        }
    </style>
</head>

<body>

    <div class="top-header">
        <!-- Unified Logo matching CareConnect branding -->
        <a href="admin_dashboard.php" class="header-brand">🏥 CareConnect </a>
        <div class="nav-links">
            <a href="manage_doctors.php" class="nav-item">Manage Doctors</a>
            <a href="manage_patients.php" class="nav-item">Manage Patients</a>
            <a href="manage_appointments.php" class="nav-item">All Appointments</a>
            <a href="login.php" class="btn-logout">Log Out</a>
        </div>
    </div>

    <div class="container">
        <div class="dashboard-banner">
            <h2>System Overview</h2>
            <!-- Updated text to reflect the new brand -->
            <p>Real-time analytics and metrics for the CareConnect Hospital Management System.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card card-doctors">
                <div class="stat-title">Total Doctors</div>
                <div class="stat-number"><?php echo $total_doctors; ?></div>
                <div class="stat-desc">Registered medical staff</div>
            </div>
            <div class="stat-card card-patients">
                <div class="stat-title">Total Patients</div>
                <div class="stat-number"><?php echo $total_patients; ?></div>
                <div class="stat-desc">Registered active users</div>
            </div>
            <div class="stat-card card-appointments">
                <div class="stat-title">Total Appointments</div>
                <div class="stat-number"><?php echo $total_appointments; ?></div>
                <div class="stat-desc">All time bookings</div>
            </div>
            <div class="stat-card card-completed">
                <div class="stat-title">Completed Visits</div>
                <div class="stat-number"><?php echo $completed_appointments; ?></div>
                <div class="stat-desc">Successfully concluded</div>
            </div>
        </div>

        <!-- Recent Appointments Table -->
        <div class="table-container">
            <div class="table-header">
                <h3>Recent Appointments Overview</h3>
                <a href="manage_appointments.php" class="view-all">View All &rarr;</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Appt ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Department</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($recent_apps_query->num_rows > 0): ?>
                        <?php while ($row = $recent_apps_query->fetch_assoc()): ?>
                           <tr>
        <td>#<?php echo $row['app_id']; ?></td>
        <td><?php echo $row['date']; ?></td>
        <td><?php echo $row['time_slot']; ?></td>
        <td><?php echo htmlspecialchars($row['reason']); ?></td>
        <td>
            <span class="status-badge <?php echo ($row['status'] === 'Completed') ? 'status-completed' : 'status-pending'; ?>">
                <?php echo htmlspecialchars($row['status']); ?>
            </span>
        </td>
    </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <!-- This spans across all 5 columns if the database is empty -->
                            <td colspan="5" style="text-align: center; color: #94a3b8; font-style: italic; padding: 20px;">
                                No appointments found in the system yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>