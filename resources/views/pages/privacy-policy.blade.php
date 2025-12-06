@extends('layouts.singlePage')

@section('title', 'Privacy Policy')

@section('bannerTitle')
    <div class="container">
        <h1 class="single-page-banner-title">Privacy Policy</h1>
    </div>
@endsection

@section('content')

    <style>
        .policy-container {
            display: flex;
            gap: 40px;
        }

        /* LEFT SIDEBAR */
        .policy-sidebar {
            width: 260px;
            position: sticky;
            top: 100px;
            height: fit-content;
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(255,255,255,0.3);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .policy-sidebar h5 {
            font-weight: 700;
            margin-bottom: 15px;
        }

        .policy-sidebar a {
            display: block;
            padding: 6px 0;
            text-decoration: none;
            font-size: 14px;
            color: #0d6efd;
        }

        .policy-sidebar a:hover {
            text-decoration: underline;
        }

        /* MAIN CONTENT CARD */
        .policy-content {
            flex: 1;
        }

        .policy-card {
            background: rgba(255,255,255,0.45);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.25);
            box-shadow: 0px 12px 30px rgba(0,0,0,0.1);
        }

        .policy-card h2, .policy-card h4 {
            font-weight: 700;
        }

        .policy-card p, .policy-card li {
            font-size: 15px;
            line-height: 1.7;
        }

        /* SMOOTH SCROLL */
        html {
            scroll-behavior: smooth;
        }

        /* MOBILE FIX */
        @media(max-width: 992px) {
            .policy-container {
                flex-direction: column;
            }
            .policy-sidebar {
                width: 100%;
                position: relative;
            }
        }
    </style>

    <div class="container py-5">

        <div class="policy-container">

            <!-- LEFT SIDEBAR -->
            <aside class="policy-sidebar shadow-sm">
                <h5>Contents</h5>
                <a href="#intro">Introduction</a>
                <a href="#collect">Information We Collect</a>
                <a href="#use">How We Use Your Data</a>
                <a href="#share">Sharing of Information</a>
                <a href="#cookies">Cookies & Tracking</a>
                <a href="#security">Data Security</a>
                <a href="#rights">Your Rights</a>
                <a href="#updates">Policy Updates</a>
                <a href="#contact">Contact Us</a>
            </aside>

            <!-- MAIN POLICY CONTENT -->
            <div class="policy-content">
                <div class="policy-card">

                    <h2 class="mb-2" id="intro">Privacy Policy</h2>
                    <p class="text-muted">Last Updated: {{ date('F d, Y') }}</p>
                    <hr class="mb-4">

                    <h4 id="collect">1. Information We Collect</h4>
                    <p>
                        We collect personal information such as your name, email, mobile number, and any details submitted
                        through our inquiry forms. We also gather browser data such as IP address, device type, and pages you visit.
                    </p>

                    <h4 id="use" class="mt-4">2. How We Use Your Information</h4>
                    <p>
                        Your information is used to respond to inquiries, recommend properties, enhance your browsing
                        experience, and send updates (with your consent). We do not sell your information.
                    </p>

                    <h4 id="share" class="mt-4">3. Sharing of Information</h4>
                    <p>
                        Your data may be shared with accredited real estate agents, property developers, or partners
                        assisting in your transaction. All partners follow strict confidentiality standards.
                    </p>

                    <h4 id="cookies" class="mt-4">4. Cookies & Tracking</h4>
                    <p>
                        We use cookies to improve performance and personalize your experience. You may disable cookies
                        through your browser settings.
                    </p>

                    <h4 id="security" class="mt-4">5. Data Security</h4>
                    <p>
                        We implement secure systems and encryption protocols. While no system is 100% secure, we follow
                        industry-standard practices to protect your data.
                    </p>

                    <h4 id="rights" class="mt-4">6. Your Rights</h4>
                    <ul>
                        <li>Request access to your personal data</li>
                        <li>Request correction or deletion</li>
                        <li>Withdraw consent from marketing messages</li>
                        <li>Request a copy of your stored information</li>
                    </ul>

                    <p>Send requests to: <strong>johnkevinpaunel@gmail.com</strong></p>

                    <h4 id="updates" class="mt-4">7. Policy Updates</h4>
                    <p>
                        This Privacy Policy may change from time to time. Updates will be posted on this page with a
                        revised date.
                    </p>

                    <h4 id="contact" class="mt-4">8. Contact Us</h4>
                    <p>
                        For questions or concerns, contact us at:
                        <br><strong>Email:</strong> johnkevinpaunel@gmail.com
                        <br><strong>Phone:</strong> 091710277662 / 09297096801
                    </p>

                </div>
            </div>

        </div>

    </div>

@endsection
