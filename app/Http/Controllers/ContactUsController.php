<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitInquiryRequest;
use App\Services\LeadService;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('pages.contact-us')->with([
            'title' => 'Contact Us',
        ]);
    }

    public function submitInquiry(SubmitInquiryRequest $request, LeadService $leadService): \Illuminate\Http\JsonResponse
    {
        $request->merge(['status' => 'hot','source' => 'website','lead_type' => 'buyer']);
        return $leadService->saveLead($request->only('first_name','last_name','phone','email','source','status','lead_type','message','property_id')) ?
            response()->json(['success' => true, 'message' => 'Your inquiry has been submitted successfully.', 'notice' => 'Expect a call or email from us soon.']) :
            response()->json(['success' => false, 'message' => 'An error occurred while submitting your inquiry.',
                'Notice' => 'Your listing has not been submitted. <br/> You may email us at <strong>johnkevinpaunel@gmail.com</strong> instead.']);

    }

}
