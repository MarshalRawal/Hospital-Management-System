<?php include 'header.php'; ?>
<style>
    .hero {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        gap: 3rem;
        padding: 4rem 5%;
        background: linear-gradient(to right, #f8fafc, #eff6ff);
        min-height: 70vh;
    }

    .hero-content {
        max-width: 600px;
    }

    .hero h1 {
        font-size: 2.75rem;
        color: #0f172a;
        margin-bottom: 1rem;
        line-height: 1.2;
        font-weight: 800;
    }

    .hero h1 span {
        color: #2563eb;
    }

    .hero p {
        font-size: 1rem;
        color: #475569;
        margin-bottom: 2rem;
        line-height: 1.7;
    }

    .hero-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .hero-image {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .hero-image img {
        width: 100%;
        max-width: 550px;
        height: auto;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        object-fit: cover;
    }

    .features {
        padding: 5rem 5%;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .feature-card {
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        text-align: left;
        transition: transform 0.2s;
    }

    .feature-card:hover {
        transform: translateY(-5px);
    }

    .feature-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
        display: inline-flex;
        padding: 1rem;
        background-color: #eff6ff;
        border-radius: 12px;
        color: #2563eb;
    }

    .feature-card h3 {
        color: #0f172a;
        margin-bottom: 0.5rem;
        font-size: 1.15rem;
    }

    .feature-card p {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .footer {
        background-color: #ffffff;
        text-align: center;
        padding: 2rem;
        border-top: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 0.9rem;
    }

    @media (max-width: 900px) {
        .hero {
            grid-template-columns: 1fr;
            text-align: center;
            padding: 3rem 5%;
        }

        .hero-content {
            margin: 0 auto;
            order: 2;
        }

        .hero-image {
            order: 1;
            margin-bottom: 2rem;
        }

        .hero-buttons {
            justify-content: center;
        }

        .hero h1 {
            font-size: 2.25rem;
        }
    }
</style>

<section class="hero">
    <div class="hero-content">
        <h1>Modern Healthcare, <span>Simplified.</span></h1>
        <p>A complete hospital management solution designed to seamlessly connect patients, doctors, and administrators in one highly secure platform.
            Book appointments, manage records, and streamline your medical journey today.</p>
        <div class="hero-buttons">
            <a href="login.php" class="btn btn-solid">Book an Appointment</a>
            <a href="register.php" class="btn btn-outline">Create Patient Account</a>
        </div>
    </div>
    <div class="hero-image">
        <img src="https://images.unsplash.com/photo-1538108149393-fbbd81895907?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Hospital Team Workspace">
    </div>
</section>
<section class="features">
    <div class="feature-card">
        <div class="feature-icon">📅</div>
        <h3>Easy Scheduling</h3>
        <p>Patients can view doctor availability in real-time and book appointments instantly without waiting in line.</p>
    </div>
    <div class="feature-card">
        <div class="feature-icon">👨‍⚕️</div>
        <h3>Expert Doctors</h3>
        <p>Our specialists can easily manage their daily schedules, review patient histories, and submit official diagnoses.</p>
    </div>
    <div class="feature-card">
        <div class="feature-icon">🔒</div>
        <h3>Secure Records</h3>
        <p>All medical records, prescriptions, and appointment histories are stored securely and easily accessible anytime.</p>
    </div>
</section>
<footer class="footer">
    <p>&copy; 2026 CareConnect Hospital Management System. All rights reserved.</p>
</footer>

</body>

</html>