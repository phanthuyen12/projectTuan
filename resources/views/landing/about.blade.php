@extends('landing.layout')

@section('content')
    <style>
        .page-header {
            height: 400px;
            background: url('https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=2070') no-repeat center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            position: relative;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .page-header h1 {
            position: relative;
            z-index: 2;
            font-size: 3.5rem;
        }

        .about-story {
            padding: 100px 8%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            background: #fff;
        }

        .about-img img {
            width: 100%;
            border-radius: 30px;
            box-shadow: 20px 20px 0px var(--primary);
        }

        .about-text h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: var(--primary);
        }

        .about-text p {
            margin-bottom: 20px;
            font-size: 1.1rem;
            color: #555;
        }

        .values-section {
            padding: 100px 8%;
            background: #fdfdfd;
            text-align: center;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
            margin-top: 60px;
        }

        .value-card {
            padding: 40px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .value-card i {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 25px;
        }

        @media (max-width: 968px) {
            .about-story {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="page-header">
        <h1 data-aos="zoom-in">Our Journey</h1>
    </div>

    <section class="about-story">
        <div class="about-img" data-aos="fade-right">
            <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=800"
                alt="Orchard">
        </div>
        <div class="about-text" data-aos="fade-left">
            <h2>From Seed to Global Distribution</h2>
            <p>Nature's Bounty was founded in 2012 by a group of environmentalists and botanists who believed that distance
                shouldn't compromise the taste of real fruit.</p>
            <p>Our mission is simple: To redefine freshness by bridging the gap between global growers and conscious
                consumers. We don't just sell fruit; we sell an experience of pure, unadulterated nature.</p>
            <p>Every single farm in our network is audited for fair trade practices and organic regenerative farming. When
                you buy from us, you're supporting global agriculture that gives back to the earth.</p>
            <a href="/invitation-login" class="cta-btn">Join Our Community</a>
        </div>
    </section>

    <section class="values-section">
        <h2 class="section-title" data-aos="fade-up">What We Stand For</h2>
        <div class="values-grid">
            <div class="value-card" data-aos="flip-up" data-aos-delay="100">
                <i class="fas fa-hand-holding-heart"></i>
                <h3>Ethical Sourcing</h3>
                <p>We ensure that every worker in our value chain receives above-market wages and safe working conditions.
                </p>
            </div>
            <div class="value-card" data-aos="flip-up" data-aos-delay="200">
                <i class="fas fa-recycle"></i>
                <h3>Eco-Packaging</h3>
                <p>Our containers are 100% biodegradable, made from plant-based materials that leave zero waste.</p>
            </div>
            <div class="value-card" data-aos="flip-up" data-aos-delay="300">
                <i class="fas fa-award"></i>
                <h3>Superior Taste</h3>
                <p>We only pick fruits at the absolute peak of ripeness, ensuring the flavor profile is second to none.</p>
            </div>
        </div>
    </section>
@endsection