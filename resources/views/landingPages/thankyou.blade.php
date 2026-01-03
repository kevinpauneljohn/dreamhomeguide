@extends('landingPages.layouts.app')

@section('title', $title)
@section('content')

@endsection
<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="card thank-you-card border-0 p-4 p-md-5 text-center">

                <!-- Success Icon -->
                <div class="icon-circle">
                    <i class="fa-solid fa-check"></i>
                </div>

                <!-- Message -->
                <h2 class="fw-bold mb-2">
                    Thank You for Your Inquiry!
                </h2>

                <p class="text-muted mb-4">
                    Your request for <strong>{{ucwords(strtolower($property))}}</strong> has been successfully received.
                </p>

                <p class="mb-4">
                    One of our accredited salesperson will contact you shortly
                    to provide complete details, pricing, and assist you with your inquiry.
                </p>

                <!-- What Happens Next -->
                <div class="text-start bg-light rounded p-3 mb-4">
                    <h6 class="fw-semibold mb-2">What happens next?</h6>
                    <ul class="next-steps mb-0">
                        <li>📞 Our agent will call or message you within the day</li>
                        <li>📄 You’ll receive updated prices and unit availability</li>
                        <li>💰 Financing options (Pag-IBIG / Bank) will be explained</li>
                        <li>🏡 Site viewing can be arranged if you’re interested</li>
                    </ul>
                </div>

                <!-- Reminder -->
                <p class="small text-muted mb-4">
                    Please keep your phone lines open so we can assist you promptly.
                </p>

                <!-- Optional CTA -->
                <a href="/" class="btn btn-outline-primary">
                    Back to Homepage
                </a>

            </div>

        </div>
    </div>
</section>

<footer class="text-center pb-4">
    <small class="text-muted">
        © {{ date('Y') }} {{request()->getHost()}}
    </small>
</footer>
@push('meta')
    <script>
        fbq('track', 'ViewContent', {
            content_name: 'Apec Homes - Alpine Residences - thank you',
            content_category: 'Thank You Page'
        });
    </script>
@endpush

@push('css')
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Inter', sans-serif;
        }
        .thank-you-card {
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,.1);
        }
        .icon-circle {
            width: 90px;
            height: 90px;
            background: #eaf7ee;
            color: #198754;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 20px;
        }
        .next-steps li {
            margin-bottom: 10px;
        }
    </style>
@endpush
