@extends('layouts.singlePage')

@section('title', 'Terms & Conditions')
@push('seo')
    <x-seo title="{{$title}} — {{url('/')}}" />
@endpush
@section('bannerTitle')
    <div class="container">
        <h1 class="single-page-banner-title">Terms & Conditions</h1>
    </div>
@endsection

@section('content')



    <div class="container py-5">

        <div class="terms-container">

            <!-- LEFT SIDEBAR -->
            <aside class="terms-sidebar shadow-sm">
                <h5>Contents</h5>
                <a href="#intro">Introduction</a>
                <a href="#use">Use of Website</a>
                <a href="#accounts">User Accounts</a>
                <a href="#properties">Property Listings</a>
                <a href="#payments">Payments & Reservations</a>
                <a href="#liability">Limitation of Liability</a>
                <a href="#ip">Intellectual Property</a>
                <a href="#privacy">Privacy</a>
                <a href="#updates">Changes to Terms</a>
                <a href="#contact">Contact Us</a>
            </aside>

            <!-- MAIN TERMS CONTENT -->
            <div class="terms-content">
                <div class="terms-card">

                    <h2 class="mb-2" id="intro">Terms & Conditions</h2>
                    <p class="text-muted">Last Updated: {{ date('F d, Y') }}</p>
                    <hr class="mb-4">

                    <h4 id="intro">1. Introduction</h4>
                    <p>
                        Welcome to <strong>johnkevinpaunel.com</strong>, a digital platform operated under
                        <strong>Dream Home Guide Realty</strong>. By accessing or using this website, you agree to be
                        bound by these Terms & Conditions. If you do not agree with any part of these terms,
                        please discontinue use of the website immediately.
                    </p>

                    <h4 id="use" class="mt-4">2. Use of the Website</h4>
                    <p>
                        You agree to use this website lawfully and responsibly. You must not engage in any activity
                        that disrupts, damages, or interferes with the website’s functionality, security, or accessibility.
                        All users are expected to use the website for its intended purpose—real estate information,
                        inquiries, and service-related communication.
                    </p>

                    <h4 id="accounts" class="mt-4">3. User Accounts</h4>
                    <p>
                        If the website offers account creation, you are responsible for maintaining the confidentiality
                        of your login details and all activities under your account. Dream Home Guide Realty reserves the right
                        to suspend or terminate accounts that violate these Terms.
                    </p>

                    <h4 id="properties" class="mt-4">4. Property Listings & Accuracy</h4>
                    <p>
                        johnkevinpaunel.com, under Dream Home Guide Realty, strives to provide accurate and updated
                        property information. However, property prices, availability, developer promos, requirements, and
                        details may change without prior notice. We make no guarantees regarding the completeness,
                        accuracy, or reliability of any listing.
                    </p>

                    <h4 id="payments" class="mt-4">5. Payments & Reservations</h4>
                    <p>
                        Any reservation fees, documentation fees, or payments processed through this platform follow
                        the official policies of the developer, property owner, or partner institution.
                        All payments are final unless covered by a specific developer refund policy.
                        Dream Home Guide Realty and johnkevinpaunel.com act only as facilitators in the transaction.
                    </p>

                    <h4 id="liability" class="mt-4">6. Limitation of Liability</h4>
                    <p>
                        Dream Home Guide Realty and johnkevinpaunel.com shall not be held liable for any direct, indirect,
                        incidental, or consequential damages arising from:
                    </p>
                    <ul>
                        <li>Use or inability to use the website</li>
                        <li>Reliance on information provided on property listings</li>
                        <li>Developer delays or changes in project specifications</li>
                        <li>Losses caused by third-party service providers</li>
                    </ul>
                    <p>
                        Users are encouraged to verify property details through official sales agents or developers.
                    </p>

                    <h4 id="ip" class="mt-4">7. Intellectual Property Rights</h4>
                    <p>
                        All website content—including text, graphics, logos, images, videos, articles, and layout—is the property
                        of Dream Home Guide Realty and may not be reproduced, copied, or distributed without written permission.
                        Unauthorized use may result in legal action.
                    </p>

                    <h4 id="privacy" class="mt-4">8. Privacy Policy</h4>
                    <p>
                        Your use of this website is also governed by our Privacy Policy, which explains how your personal
                        information is collected, used, and protected. By using this website, you acknowledge and agree
                        to the terms outlined in the Privacy Policy.
                    </p>

                    <h4 id="updates" class="mt-4">9. Updates to Terms</h4>
                    <p>
                        Dream Home Guide Realty reserves the right to update, revise, or modify these Terms & Conditions
                        at any time. Any changes will be posted on this page with the updated date.
                        Continued use of the website indicates acceptance of the revised terms.
                    </p>

                    <h4 id="contact" class="mt-4">10. Contact Information</h4>
                    <p>
                        For questions regarding these Terms & Conditions, you may contact us through:
                        <br><strong>Email:</strong> johnkevinpaunel@gmail.com
                        <br><strong>Phone:</strong> 091710277662 / 09297096801
                        <br><strong>Real Estate Brokerage:</strong> Dream Home Guide Realty
                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection

@push('css')
    <style>
        .terms-container {
            display: flex;
            gap: 40px;
        }

        .terms-sidebar {
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

        .terms-sidebar h5 {
            font-weight: 700;
            margin-bottom: 15px;
        }

        .terms-sidebar a {
            display: block;
            padding: 6px 0;
            font-size: 14px;
            color: #0d6efd;
            text-decoration: none;
        }

        .terms-sidebar a:hover {
            text-decoration: underline;
        }

        .terms-content {
            flex: 1;
        }

        .terms-card {
            background: rgba(255,255,255,0.45);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.25);
            box-shadow: 0px 12px 30px rgba(0,0,0,0.1);
        }

        .terms-card h2, .terms-card h4 {
            font-weight: 700;
        }

        .terms-card p, .terms-card li {
            font-size: 15px;
            line-height: 1.7;
        }

        html {
            scroll-behavior: smooth;
        }

        @media(max-width: 992px) {
            .terms-container {
                flex-direction: column;
            }
            .terms-sidebar {
                width: 100%;
                position: relative;
            }
        }
    </style>
@endpush
