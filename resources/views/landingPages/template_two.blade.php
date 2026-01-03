@extends('landingPages.layouts.app')

@section('title', $title)
@section('content')
    <!-- HERO SECTION -->
    <section class="hero text-center">
        <div class="container">
            <h1 class="mb-3">
                🏡 Request Complete Details of <br class="d-none d-md-block">
                <strong>{{ucwords(strtolower($title))}}</strong>
            </h1>
            <p class="mb-3">
                Get updated prices, available units, sample computations, and exclusive promos.
                An accredited salesperson will assist you for free.
            </p>
        </div>
    </section>

    <!-- FORM SECTION -->
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card form-card border-0 p-4 p-md-5">
                    <h5 class="fw-semibold text-center mb-2">
                        {{ucwords(strtolower($title))}} Inquiry Form
                    </h5>
                    <p class="text-muted text-center mb-4">
                        Fill out the form below to receive complete project details.
                    </p>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            Please, fill in all required fields.
                        </div>
                    @endif

                    <form id="alpineInquiryForm" method="POST" action="{{route('form-submit')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label><span class="text-danger">*</span>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       name="first_name" placeholder="Enter your first name" value="{{ old('first_name') }}">
                                @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label><span class="text-danger">*</span>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       name="last_name" placeholder="Enter your last name" value="{{ old('last_name') }}">
                                @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Mobile Number</label><span class="text-danger">*</span>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                       name="phone" placeholder="09XX XXX XXXX" value="{{ old('mobile') }}">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" placeholder="you@email.com" value="{{ old('email') }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Preferred Financing</label><span class="text-danger">*</span>
                                <select class="form-select @error('financing') is-invalid @enderror" name="financing">
                                    <option value="">Select financing option</option>
                                    <option value="pagibig" @if(old('financing') == "pagibig") selected @endif>Pag-IBIG Financing</option>
                                    <option value="bank" @if(old('financing') == "bank") selected @endif>Bank Financing</option>
                                    <option value="cash" @if(old('financing') == "cash") selected @endif>Cash / Spot Payment</option>
                                </select>
                                @error('financing')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Occupation</label><span class="text-danger">*</span>
                                <select class="form-select @error('occupation') is-invalid @enderror" name="occupation">
                                    <option value="">Set your occupation</option>
                                    <option value="locally employed" @if(old('financing') == "locally employed") selected @endif>Locally Employed</option>
                                    <option value="with registered business" @if(old('occupation') == "with registered business") selected @endif>With Registered Business</option>
                                    <option value="ofw" @if(old('occupation') == "ofw") selected @endif>Ofw</option>
                                    <option value="foreign citizen" @if(old('occupation') == "foreign citizen") selected @endif>Foreign Citizen</option>
                                </select>
                                @error('occupation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Monthly Income Range</label><span class="text-danger">*</span>
                                <select class="form-select @error('income_range') is-invalid @enderror" name="income_range">
                                    <option value="">Set you monthly income range</option>
                                    @foreach($monthlyIncomeRange as $income)
                                        <option value="{{$income}}"  @if(old('income_range') == $income) selected @endif>{{$income}}</option>
                                    @endforeach
                                </select>
                                @error('income_range')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message (Optional)</label>
                            <textarea class="form-control @error('message') is-invalid @enderror"
                                      rows="7"
                                      name="message"
                                      id="message"
                                      maxlength="3000"
                                      placeholder="Any questions or preferred unit type?"></textarea>
                            @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="text-muted d-flex justify-content-end">
                                <span id="messageCount">0</span>/3000 characters
                            </small>
                        </div>

                        <!-- Hidden Project Tag -->
                        <input type="hidden" name="property_id" value="{{$property_id}}">

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                📩 Get Property Details
                            </button>
                        </div>

                        <p class="trust text-center mt-3 mb-0">
                            ✔ Free consultation • ✔ No obligation • ✔ No spam <br>
                            ✔ Pag-IBIG & Bank Financing Assistance Available
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="text-center mt-5 pb-4">
        <small class="text-muted">
            © {{ date('Y') }} johnkevinpaunel.com
        </small>
    </footer>

@endsection

@push('meta')
    <script>
        fbq('track', 'ViewContent', {
            content_name: 'Apec Homes - Alpine Residences',
            content_category: 'Landing Page'
        });
    </script>
@endpush

@push('css')
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Inter', sans-serif;
        }
        .hero {
            background: linear-gradient(135deg, #0d3b66, #145da0);
            color: #fff;
            padding: 60px 20px;
        }
        .hero h1 {
            font-weight: 700;
        }
        .hero p {
            opacity: 0.9;
        }
        .form-card {
            margin-top: -60px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,.12);
        }
        .btn-primary {
            background: #ff7a00;
            border: none;
            font-weight: 600;
            padding: 14px;
        }
        .btn-primary:hover {
            background: #e96f00;
        }
        .trust {
            font-size: 13px;
            color: #6c757d;
        }
    </style>
@endpush

@push('scripts')
    @vite('resources/js/landing-page/form.js')
@endpush
