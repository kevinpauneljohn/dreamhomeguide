<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\Property;
use App\Services\LeadService;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function landingPage(LeadService $leadService): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('landingPages.template_one')->with([
            'title' => 'Alpine Residences',
            'monthlyIncomeRange' => $leadService->incomeRange()
        ]);
    }

    public function propertyLandingPage(string $slug, LeadService $leadService): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $property = Property::where('slug',$slug)->firstOrFail();
        return view('landingPages.template_two')->with([
            'title' => ucwords(strtolower($property->title)),
            'monthlyIncomeRange' => $leadService->incomeRange(),
            'property_id' => $property->id,
        ]);
    }

    public function thankYou(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {

        return view('landingPages.thankyou')->with([
            'title' => 'Thank you!',
            'property' => $request->property
        ]);
    }

    public function formSubmit(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'required_without:phone'],
            'phone' => ['nullable', 'string', 'required_without:email'],
            'financing' => ['required'],
            'occupation' => ['required'],
            'income_range' => ['required'],
            'message' => ['nullable','max:3000'],
            'g-recaptcha-response' => 'required|captcha'
        ]);

        $request->merge([
            'status' => 'new',
            'source' => 'Facebook Ads',
            'message' => $request->message ?? ''
        ]);

        try {
            $leads = Leads::create($request->only('first_name','last_name','email','phone','financing','occupation','income_range','message','status','source','property_id'));
            return redirect()->route('thank-you',[
                'property' => $leads->property->title
            ]);
        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
