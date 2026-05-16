<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nature's Bounty - Premium International Fruits</title>
    <!-- Modern Typography: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- AOS for Scroll Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary: #27AE60;
            /* Fresh Green */
            --primary-dark: #1E8449;
            --secondary: #F39C12;
            /* Vibrant Orange */
            --accent: #E74C3C;
            /* Berry Red */
            --bg-grad: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            --dark: #2C3E50;
            --glass: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.3);
            --shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: var(--bg-grad);
            color: var(--dark);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Navbar Styles */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            height: 90px;
            background: var(--glass);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 8%;
            transition: 0.3s;
        }

        nav.scrolled {
            height: 70px;
            background: rgba(255, 255, 255, 0.95);
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo i {
            color: var(--secondary);
        }

        .nav-links {
            display: flex;
            gap: 40px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            font-size: 1.1rem;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .cta-btn {
            background: var(--primary);
            color: white;
            padding: 12px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        }

        .cta-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Hero Section Styling */

        /* Footer */
        footer {
            background: #1a1a1a;
            color: #fff;
            padding: 80px 8% 40px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer-col h3 {
            font-size: 1.5rem;
            margin-bottom: 25px;
            color: var(--secondary);
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 12px;
        }

        .footer-col ul li a {
            color: #ccc;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer-col ul li a:hover {
            color: var(--primary);
            padding-left: 10px;
        }

        .social-links {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #fff;
            font-size: 1.2rem;
            transition: 0.3s;
        }

        .social-links a:hover {
            background: var(--primary);
            transform: rotate(360deg);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #777;
        }

        /* Responsive Improvements */
        @media (max-width: 968px) {
            nav {
                padding: 0 4%;
            }

            .nav-links {
                display: none;
            }
        }
    </style>
</head>

<body>

    <nav id="navbar">
        <a href="/" class="logo">
            <i class="fas fa-leaf"></i> Nature's Bounty
        </a>
        <ul class="nav-links">
            <li><a href="/">Home</a></li>
            <li><a href="/about">About Us</a></li>
            <li><a href="/products">Products</a></li>
            <li><a href="/contact">Contact</a></li>
        </ul>
        <a href="/invitation-login" class="cta-btn">Order Now</a>
    </nav>

    @yield('content')

    <footer>
        <div class="footer-grid">
            <div class="footer-col">
                <a href="/" class="logo" style="color: #fff; margin-bottom: 20px;">
                    <i class="fas fa-leaf"></i> Nature's Bounty
                </a>
                <p>Bringing the finest, fresh-picked fruits from global orchards directly to your doorstep. Quality you
                    can taste, nature you can trust.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/products">Our Fruits</a></li>
                    <li><a href="/contact">Get in Touch</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Our Fruits</h3>
                <ul>
                    <li><a href="#">Exotic Dragon Fruit</a></li>
                    <li><a href="#">Premium Mangoes</a></li>
                    <li><a href="#">Organic Berries</a></li>
                    <li><a href="#">Tropical Pineapples</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Newsletter</h3>
                <p>Subscribe to get updates on seasonal harvests and special offers.</p>
                <div style="margin-top: 20px; display: flex;">
                    <input type="email" placeholder="Your email"
                        style="padding: 12px; border: none; border-radius: 5px 0 0 5px; outline: none; flex: 1;">
                    <button
                        style="padding: 12px 20px; background: var(--primary); color: #fff; border: none; border-radius: 0 5px 5px 0; cursor: pointer;">Join</button>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Nature's Bounty Inc. All rights reserved. Registered for international distribution.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });

        window.addEventListener('scroll', function () {
            var nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>