<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareConnect Hospital System</title>
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: #0f172a;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            padding: 1rem 5%;
            background-color: #ffffff;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
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
            gap: 1.5rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #475569;
            font-weight: 600;
            font-size: 0.95rem;
            transition: color 0.2s;
            white-space: nowrap;
        }

        .nav-links a:hover {
            color: #2563eb;
        }

        /* Fixed Button CSS */
        /* Fixed Button CSS */
        .btn {
            padding: 0.6rem 1.25rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s;
            text-decoration: none;
            cursor: pointer;
            white-space: nowrap;
            display: flex; /* Changed from inline-flex */
            align-items: center;
            justify-content: center;
        }

        a.btn-outline {
            border: 1px solid #2563eb;
            color: #2563eb;
            background-color: transparent;
        }

        a.btn-outline:hover {
            background-color: #eff6ff;
        }

        a.btn-solid {
            background-color: #2563eb;
            color: #ffffff;
            border: 1px solid #2563eb;
        }

        a.btn-solid:hover {
            background-color: #1d4ed8;
            color: white;
            border-color: #1d4ed8;
        }

        @media (max-width: 900px) {
            .nav-links {
                display: none;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a href="index.php" class="logo">🏥 CareConnect</a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="login.php" class="btn btn-outline">Log In</a>
            <a href="register.php" class="btn btn-solid">Register</a>
        </div>
    </nav>