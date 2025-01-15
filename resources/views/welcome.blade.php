<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>e-SIM Advanced Landing Page</title>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        h1, h2, h3 {
            font-family: 'Arial', sans-serif;
            font-weight: 600;
        }

        /* Header Section */
        header {
            background: #008CBA;
            color: white;
            padding: 3em 0;
            text-align: center;
            position: relative;
            z-index: 10;
        }

        header h1 {
            font-size: 3em;
            margin-bottom: 0.5em;
        }

        header p {
            font-size: 1.2em;
            margin-bottom: 1.5em;
        }

        .cta-button {
            padding: 15px 30px;
            background-color: #ff8c00;
            color: white;
            border-radius: 30px;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .cta-button:hover {
            background-color: #e07b00;
        }

        /* Hero Image */
        .hero-image {
            width: 100%;
            height: 400px;
            background: url('https://via.placeholder.com/1600x600') no-repeat center center;
            background-size: cover;
            margin-top: 20px;
        }

        /* B2B & B2C Sections */
        .section {
            padding: 4em 1em;
            text-align: center;
        }

        .section:nth-of-type(odd) {
            background-color: #ffffff;
        }

        .section .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section h2 {
            font-size: 2.5em;
            margin-bottom: 1em;
        }

        .section p {
            font-size: 1.1em;
            margin-bottom: 1.5em;
        }

        /* Feature Grid */
        .feature-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 2em;
            margin-top: 3em;
        }

        .feature-card {
            background-color: #f9f9f9;
            padding: 2em;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-card img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 1em;
        }

        .feature-card h3 {
            font-size: 1.8em;
            margin-bottom: 1em;
        }

        .feature-card p {
            font-size: 1.1em;
            color: #777;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            padding: 2em 0;
            text-align: center;
        }

        footer a {
            color: white;
            margin: 0 0.5em;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #ff8c00;
        }
    </style>
</head>

<body>

    <header>
        <h1>Welcome to the Future of Connectivity</h1>
        <p>Transforming mobile experiences with e-SIM technology for businesses and consumers worldwide</p>
        <a href="#contact" class="cta-button">Get Started Today</a>
    </header>

    <div class="hero-image"></div>

    <div class="section" style="background-color: #f2f4f5;">
        <div class="container">
            <h2>For Businesses (B2B)</h2>
            <p>Unlock new possibilities for your company by offering flexible, cost-efficient e-SIM plans. Seamlessly integrate with global networks and expand your business outreach.</p>
            <a href="#contact" class="cta-button">Partner with Us</a>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <h2>For Consumers (B2C)</h2>
            <p>Enjoy hassle-free mobile connectivity with our e-SIM technology. Stay connected globally without the need for physical SIM cards, and save on roaming costs.</p>
            <a href="#contact" class="cta-button">Get Your e-SIM Now</a>
        </div>
    </div>

    <div class="section" style="background-color: #ffffff;">
        <h2>Why Choose Our e-SIM?</h2>
        <p>Discover the key advantages of switching to e-SIM for both businesses and consumers</p>
        <div class="feature-grid">
            <div class="feature-card">
                <img src="https://via.placeholder.com/350" alt="Global Coverage">
                <h3>Global Coverage</h3>
                <p>Access a network that spans across the globe. Our e-SIM technology works seamlessly wherever you go.</p>
            </div>
            <div class="feature-card">
                <img src="https://via.placeholder.com/350" alt="Seamless Activation">
                <h3>Seamless Activation</h3>
                <p>Set up your e-SIM with a few taps, and activate it instantly. It’s that easy!</p>
            </div>
            <div class="feature-card">
                <img src="https://via.placeholder.com/350" alt="Cost-Effective">
                <h3>Cost-Effective Plans</h3>
                <p>Choose from flexible pricing plans that save you money on roaming charges and international calls.</p>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 e-SIM Solutions. All Rights Reserved.</p>
        <a href="mailto:info@esim.com">Contact Us</a> | <a href="/terms">Terms of Service</a> | <a href="/privacy">Privacy Policy</a>
    </footer>

</body>
