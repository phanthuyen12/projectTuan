@extends('landing.layout')

@section('content')
<style>
    .page-header {
        height: 400px;
        background: url('https://images.unsplash.com/photo-1423483641154-52c1fd690ca9?auto=format&fit=crop&q=80&w=2070') no-repeat center/cover;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        position: relative;
    }
    .page-header::before {
        content: '';
        position: absolute;
        top:0; left:0; width:100%; height:100%;
        background: rgba(0,0,0,0.5);
    }
    .page-header h1 {
        position: relative;
        z-index: 2;
        font-size: 3.5rem;
    }

    .contact-section {
        padding: 100px 8%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        background: #fff;
    }

    .contact-info-card {
        padding: 40px;
        background: #fdfdfd;
        border-radius: 20px;
        border: 1px solid #f1f1f1;
    }

    .contact-info-card h2 {
        font-size: 2rem;
        margin-bottom: 25px;
        color: var(--primary);
    }

    .contact-detail {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
        align-items: center;
    }

    .contact-detail i {
        font-size: 1.5rem;
        color: var(--secondary);
        width: 40px;
    }

    /* Contact Form */
    .contact-form-card {
        padding: 40px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
    }

    .contact-form-card h2 {
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .form-group input, .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        outline: none;
        transition: 0.3s;
    }

    .form-group input:focus, .form-group textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 10px rgba(39, 174, 96, 0.1);
    }

    @media (max-width: 968px) {
        .contact-section {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <h1 data-aos="zoom-in">Contact Us</h1>
</div>

<section class="contact-section">
    <div class="contact-info" data-aos="fade-right">
        <div class="contact-info-card">
            <h2>Get In Touch</h2>
            <p style="margin-bottom: 30px;">Have questions about our seasonal harvests or international distribution? Our customer excellence team is here to help.</p>
            
            <div class="contact-detail">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <h4 style="font-weight: 700;">Headquarters</h4>
                    <p>128 Orchard Lane, Green Valley, CA 94025, USA</p>
                </div>
            </div>
            
            <div class="contact-detail">
                <i class="fas fa-phone-alt"></i>
                <div>
                    <h4 style="font-weight: 700;">Global Support</h4>
                    <p>+1 (800) FRUIT-NOW</p>
                </div>
            </div>
            
            <div class="contact-detail">
                <i class="fas fa-envelope"></i>
                <div>
                    <h4 style="font-weight: 700;">Email Us</h4>
                    <p>fresh@naturesbounty.com</p>
                </div>
            </div>

            <div style="margin-top: 40px;">
                <h4 style="margin-bottom: 15px;">Follow Us</h4>
                <div class="social-links">
                    <a href="#" style="background: var(--primary)"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" style="background: var(--primary)"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="background: var(--primary)"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-form" data-aos="fade-left">
        <div class="contact-form-card">
            <h2>Send a Message</h2>
            <form action="#">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" placeholder="Your full name" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" placeholder="Your email address" required>
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" placeholder="What's this about?">
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea rows="5" placeholder="How can we help nature's way?" required></textarea>
                </div>
                <button type="submit" class="cta-btn" style="width: 100%; border: none; cursor: pointer;">Send Message</button>
            </form>
        </div>
    </div>
</section>

<!-- Map Section (Pseudo) -->
<section style="height: 450px; background: #eee;">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3401.5543!2d-122.1430!3d37.4419!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fba02!2sStanford!5e0!3m2!1sen!2sus!4v1600000000" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
</section>
@endsection
