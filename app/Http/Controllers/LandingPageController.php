<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Services\LeadService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LandingPageController extends Controller
{
    public function landingPage(LeadService $leadService): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('landingPages.template_one')->with([
            'title' => 'Alpine Residences',
            'monthlyIncomeRange' => $leadService->incomeRange()
        ]);
    }

    public function thankYou(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('landingPages.thankyou')->with([
            'title' => 'Alpine Residences',
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
        ]);

        $request->merge([
            'status' => 'new',
            'source' => 'Facebook Ads',
            'message' => $request->message.'<br/> <strong>Alpine Residences</strong>' ?? ''
        ]);

        try {
            Leads::create($request->only('first_name','last_name','email','phone','financing','occupation','income_range','message','status','source'));
            return redirect()->route('thank-you');
        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
