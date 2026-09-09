<?php
// Include the navigation bar
include 'header.php';
?>

<!-- Import Google's Premium 'Inter' Font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        background-color: #f8fafc;
        color: #0f172a;
        font-family: 'Inter', sans-serif;
        margin: 0;
        padding: 0;
    }

    /* Beautiful Gradient Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #eff6ff 0%, #bfdbfe 100%);
        padding: 5rem 2rem;
        text-align: center;
        border-bottom: 1px solid #93c5fd;
    }

    .hero-content {
        max-width: 800px;
        margin: 0 auto;
    }

    .hero-title {
        font-size: 2.75rem;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 1.25rem;
        letter-spacing: -0.02em;
    }

    .hero-subtitle {
        font-size: 1.15rem;
        color: #3b82f6;
        line-height: 1.6;
        font-weight: 500;
    }

    /* Core Content Area */
    .about-wrapper {
        max-width: 1100px;
        margin: -2rem auto 4rem auto;
        padding: 0 2rem;
        position: relative;
        z-index: 10;
    }

    .mission-card {
        background: #ffffff;
        padding: 3rem;
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
        text-align: center;
        border: 1px solid #e2e8f0;
        margin-bottom: 4rem;
    }

    .mission-card h2 {
        color: #0f172a;
        font-size: 1.75rem;
        margin-bottom: 1rem;
    }

    .mission-card p {
        color: #475569;
        font-size: 1.05rem;
        line-height: 1.7;
        max-width: 800px;
        margin: 0 auto;
    }

    /* 3-Column Feature Grid */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .feature-card {
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.08);
        border-color: #bfdbfe;
    }

    .icon-wrapper {
        width: 56px;
        height: 56px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .feature-card h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 1rem;
    }

    .feature-card p {
        color: #64748b;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .hero-title { font-size: 2rem; }
        .mission-card { padding: 2rem 1.5rem; }
    }
</style>

<!-- Hero Banner -->
<div class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">Empowering Local Healthcare</h1>
        <p class="hero-subtitle">Bringing modern digital infrastructure to small clinics and independent hospitals.</p>
    </div>
</div>

<div class="about-wrapper">
    
    <!-- Core Mission Statement -->
    <div class="mission-card">
        <h2>Bridging the Digital Divide</h2>
        <p>Many small clinics struggle with paper records and phone-based booking simply because enterprise software is too expensive. CareConnect was engineered from the ground up to solve this. We provide a lightweight, highly secure platform that gives local medical facilities the exact tools they need to bring their practice online.</p>
    </div>

    <!-- Features Grid -->
    <div class="features-grid">
        
        <!-- Booking Feature -->
        <div class="feature-card">
            <div class="icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <h3>Online Appointment Booking</h3>
            <p>Patients no longer need to wait on hold. Our intuitive dashboard allows patients to view doctor availability and securely book their appointments 24/7 from any device.</p>
        </div>

        <!-- Prescriptions Feature -->
        <div class="feature-card">
            <div class="icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
            <h3>Digital Prescriptions</h3>
            <p>Doctors can log clinical diagnoses and prescribe medications directly into the database. Patients can instantly view their medical history and active prescriptions from their home dashboard.</p>
        </div>

        <!-- Security Feature -->
        <div class="feature-card">
            <div class="icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
            </div>
            <h3>Data Security & Privacy</h3>
            <p>Built on a robust relational database, our system uses encrypted passwords and Role-Based Access Control to ensure patient medical records remain strictly confidential.</p>
        </div>

    </div>
</div>

</body>
</html>