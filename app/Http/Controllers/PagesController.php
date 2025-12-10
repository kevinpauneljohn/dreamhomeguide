<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitListingRequest;
use App\Models\Blog;
use App\Services\LeadService;
use App\Services\PropertyService;
use Spatie\Sitemap\SitemapGenerator;

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

    public function blogs(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('pages.blog.index')->with([
            'title' => 'Blog',
            'blogs' => Blog::where('status','published')->paginate(12)
        ]);
    }

    public function blogPost($slug): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $blog = Blog::where('slug',$slug)->firstOrFail();
        return view('pages.blog.post')->with([
            'title' => ucwords(strtolower($blog->title)),
            'blog' => $blog,
            'relatedBlogs' => Blog::where('status','published')->take(3)->get()
        ]);
    }

    /*
     *Privacy Policy Page
     */
    public function privacyPolicy(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('pages.privacy-policy')->with([
            'title' => 'Privacy Policy',
        ]);
    }

    public function termsAndConditions(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('pages.terms-and-conditions')->with([
            'title' => 'Terms and Conditions',
        ]);
    }

    public function sitemap()
    {
        return view('pages.sitemap')->with([
            'title' => 'Sitemap',
            'latestBlogs' => Blog::all()->sortByDesc('created_at')->take(5),
        ]);
    }

    public function sitemapXml()
    {
        return SitemapGenerator::create('https://johnkevinpaunel.com')->writeToFile(public_path('sitemap.xml'));
    }
}
