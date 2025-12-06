<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitListingRequest;
use App\Services\LeadService;
use App\Services\PropertyService;

class PagesController extends Controller
{
    public function listMyProperty(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('pages.list-my-property')->with([
            'title' => 'List My Property',
        ]);
    }

    public function submitListing(SubmitListingRequest $request, LeadService $leadService): \Illuminate\Http\JsonResponse
    {
        try {
            $request->merge(['status' => 'new','source' => 'website','user_id' => auth()->id(),'lead_type' => 'seller']);
            $lead = $leadService->saveLead($request->only('first_name','last_name','phone','email','source','status','lead_type'));
            if($lead)
            {
                $request->merge(['lead_id' => $lead->id]);
                $leadService->sellerLeadPropertyInformation($lead->lead_type, $request->only('location','property_category','additional_details','lead_id'));
                return response()->json(['success' => true, 'message' => 'Your listing has been submitted successfully.','notice' => 'Expect a call or email from us soon.']);
            }

        }catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
        return response()->json(['success' => false, 'Notice' => 'Your listing has not been submitted. <br/> You may email us at <strong>johnkevinpaunel@gmail.com</strong> instead.']);
    }
}
