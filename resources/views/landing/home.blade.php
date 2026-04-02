@extends('landing.layout')

@section('content')
<style>
    /* Hero Styles */
    .hero {
        height: 100vh;
        display: flex;
        align-items: center;
        padding: 0 8%;
        position: relative;
        background: url('https://images.unsplash.com/photo-1610832958506-aa56368176cf?auto=format&fit=crop&q=80&w=2070') no-repeat center/cover;
        color: #fff;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
    }

    .hero-content h1 {
        font-size: 4rem;
        font-weight: 700;
        line-height: 1.1;
        margin-bottom: 25px;
    }

    .hero-content h1 span {
        color: var(--secondary);
    }

    .hero-content p {
        font-size: 1.25rem;
        margin-bottom: 40px;
        opacity: 0.9;
    }

    /* Feature Sections */
    .features {
        padding: 100px 8%;
        text-align: center;
        background: #fff;
    }

    .section-title {
        font-size: 2.5rem;
        margin-bottom: 60px;
        position: relative;
    }

    .section-title::after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background: var(--primary);
        margin: 15px auto;
        border-radius: 5px;
    }

    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    .feature-card {
        padding: 40px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: 0.4s;
        border: 1px solid #f1f1f1;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(39, 174, 96, 0.15);
        border-color: var(--primary);
    }

    .feature-card i {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 25px;
    }

    .feature-card h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    /* Product Highlights */
    .products-preview {
        padding: 100px 8%;
        background: #fdfdfd;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    .product-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: 0.3s;
    }

    .product-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .product-img {
        height: 250px;
        background-size: cover;
        background-position: center;
    }

    .product-info {
        padding: 25px;
    }

    .product-category {
        font-size: 0.9rem;
        color: var(--primary);
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .product-info h3 {
        margin-bottom: 15px;
        font-size: 1.4rem;
    }

    .price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark);
    }

    .buy-btn {
        display: block;
        width: 100%;
        padding: 15px;
        background: #f1f1f1;
        text-align: center;
        text-decoration: none;
        color: var(--dark);
        font-weight: 600;
        margin-top: 20px;
        border-radius: 10px;
        transition: 0.3s;
    }

    .buy-btn:hover {
        background: var(--primary);
        color: #fff;
    }

    /* Testimonials Glassmorphism */
    .testimonials {
        padding: 120px 8%;
        background: url('https://images.unsplash.com/photo-1519985176271-adb1088fa94c?auto=format&fit=crop&q=80&w=2070') no-repeat center/cover;
        position: relative;
    }

    .testimonials::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(39, 174, 96, 0.85); /* Green overlay */
        z-index: 1;
    }

    .testimonial-container {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .testimonial-card {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(15px);
        padding: 40px;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #fff;
    }

    .testimonial-card p {
        font-style: italic;
        margin-bottom: 25px;
        font-size: 1.1rem;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-info img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 2px solid var(--secondary);
    }

    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.8rem;
        }
    }
</style>

<header class="hero">
    <div class="hero-content" data-aos="fade-right">
        <h1>Bite Into Exceptionally <span>Fresh</span> International Fruit</h1>
        <p>Expertly curated premium quality fruits sourced sustainably from the world's most pristine orchards. Delivered fresh to your home.</p>
        <div style="display: flex; gap: 20px;">
            <a href="/order-tracking" class="cta-btn" style="padding: 18px 45px; font-size: 1.2rem;">Shop Our Collection</a>
            <a href="/about" class="cta-btn" style="background: transparent; border: 2px solid #fff; padding: 18px 45px; font-size: 1.2rem; box-shadow: none;">Our Story</a>
        </div>
    </div>
</header>

<section class="features">
    <h2 class="section-title" data-aos="fade-up">Why Experience Nature's Bounty?</h2>
    <div class="feature-grid">
        <div class="feature-card" data-aos="zoom-in" data-aos-delay="100">
            <i class="fas fa-plane-up"></i>
            <h3>Direct Import</h3>
            <p>We source directly from specialized farms in 30+ countries to ensure maximum freshness and variety.</p>
        </div>
        <div class="feature-card" data-aos="zoom-in" data-aos-delay="200">
            <i class="fas fa-vial"></i>
            <h3>Chemical Free</h3>
            <p>Every fruit undergoes strict testing to guarantee zero pesticides and 100% organic certifications.</p>
        </div>
        <div class="feature-card" data-aos="zoom-in" data-aos-delay="300">
            <i class="fas fa-truck-fast"></i>
            <h3>Eco-Delivery</h3>
            <p>Our cold-chain logistics ensure your order arrives in peak condition within 24 hours of selection.</p>
        </div>
    </div>
</section>

<section class="products-preview">
    <h2 class="section-title" style="text-align: center" data-aos="fade-up">Seasonal Highlights</h2>
    <div class="product-grid">
        <div class="product-card" data-aos="fade-up" data-aos-delay="100">
            <div class="product-img" style="background-image: url('https://images.unsplash.com/photo-1528825831135-3391d4c1c73a?ixlib=rb-4.0.3&auto=format&fit=crop&q=80&w=800')"></div>
            <div class="product-info">
                <span class="product-category">Tropical</span>
                <h3>Premium Japanese Miyazaki Mango</h3>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span class="price">$52.00 / kg</span>
                    <a href="/order-tracking" class="buy-btn" style="width: auto; margin:0; padding: 10px 20px;">View</a>
                </div>
            </div>
        </div>
        <div class="product-card" data-aos="fade-up" data-aos-delay="200">
            <div class="product-img" style="background-image: url('https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?ixlib=rb-4.0.3&auto=format&fit=crop&q=80&w=800')"></div>
            <div class="product-info">
                <span class="product-category">Berries</span>
                <h3>Organic New Zealand SunGold Kiwifruit</h3>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span class="price">$18.50 / box</span>
                    <a href="/order-tracking" class="buy-btn" style="width: auto; margin:0; padding: 10px 20px;">View</a>
                </div>
            </div>
        </div>
        <div class="product-card" data-aos="fade-up" data-aos-delay="300">
            <div class="product-img" style="background-image: url('https://images.unsplash.com/photo-1601004890684-d8cbf643f5f2?ixlib=rb-4.0.3&auto=format&fit=crop&q=80&w=800')"></div>
            <div class="product-info">
                <span class="product-category">Exotic</span>
                <h3>Fresh Malaysian Musang King Durian</h3>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span class="price">$45.00 / kg</span>
                    <a href="/order-tracking" class="buy-btn" style="width: auto; margin:0; padding: 10px 20px;">View</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="testimonials">
    <div class="testimonial-container">
        <div class="testimonial-card" data-aos="fade-up">
            <p>"The quality of Miyazaki Mangoes I received was beyond words. Exactly what you find in luxury department stores in Tokyo, but at my door in London."</p>
            <div class="user-info">
                <img src="https://i.pravatar.cc/150?img=32" alt="User">
                <div>
                    <h4>Sarah Jenkins</h4>
                    <span style="font-size: 0.8rem; opacity: 0.7;">Verified Collector</span>
                </div>
            </div>
        </div>
        <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
            <p>"Absolutely stunning variety. I find fruits here that aren't even available in high-end supermarkets. The packaging is eco-friendly too!"</p>
            <div class="user-info">
                <img src="https://i.pravatar.cc/150?img=12" alt="User">
                <div>
                    <h4>Mark Richardson</h4>
                    <span style="font-size: 0.8rem; opacity: 0.7;">Naturalist</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
