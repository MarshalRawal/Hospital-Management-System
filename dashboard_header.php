<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .navbar {
            background-color: #ffffff;
            padding: 1rem 5%;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
        }

        .nav-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-brand span {
            color: #2563eb;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .nav-link:hover {
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
        }

        .btn-logout:hover {
            background-color: #ef4444;
            color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a href="patient_dashboard.php" class="nav-brand">Care<span>Connect</span></a>
        <div class="nav-links">
            <a href="patient_dashboard.php" class="nav-link">Dashboard</a>
            <a href="book_appointment.php" class="nav-link">Appointments</a>
            <a href="medical_records.php" class="nav-link">Diagnoses & Prescriptions</a>
            <a href="profile.php" class="nav-link">My Profile</a>
            <a href="index.php" class="btn-logout">Log Out</a>
        </div>
    </nav>