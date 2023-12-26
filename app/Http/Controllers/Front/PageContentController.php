<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ContentPage;

// use App\Models\ContentOurStory;
// use App\Models\ContentWhatWeDo;
// use App\Models\ContentContact;
// use App\Models\OfficeAddress;
// use App\Models\OfficeEmailId;
// use App\Models\OfficePhoneNumber;
// use App\Models\Lead;
// use App\Models\SeoPage;

class PageContentController extends Controller
{
    public function terms(Request $request)
    {
        $data = ContentPage::where('page', 'terms')->first();
        if($data->status != 1) return redirect()->route('front.error.404');
 
        return view('front.content.index', compact('data'));
    }

    public function return(Request $request)
    {
        $data = ContentPage::where('page', 'cancellation')->first();
        if($data->status != 1) return redirect()->route('front.error.404');
 
        return view('front.content.index', compact('data'));
    }

    public function privacy(Request $request)
    {
        $data = ContentPage::where('page', 'privacy')->first();
        if($data->status != 1) return redirect()->route('front.error.404');
 
        return view('front.content.index', compact('data'));
    }

    public function security(Request $request)
    {
        $data = ContentPage::where('page', 'security')->first();
        if($data->status != 1) return redirect()->route('front.error.404');
 
        return view('front.content.index', compact('data'));
    }

    public function support(Request $request)
    {
        $data = ContentPage::where('page', 'support')->first();
        if($data->status != 1) return redirect()->route('front.error.404');
 
        return view('front.content.index', compact('data'));
    }

    public function service(Request $request)
    {
        $data = ContentPage::where('page', 'service')->first();
        if($data->status != 1) return redirect()->route('front.error.404');
 
        return view('front.content.index', compact('data'));
    }

    /*
    public function ourStory(Request $request)
    {
        $seo = SeoPage::where('page', 'ourstory')->first();
        $data = ContentOurStory::first();
        return view('front.content.ourstory', compact('data', 'seo'));
    }

    public function whatWeDo(Request $request)
    {
        $seo = SeoPage::where('page', 'whatwedo')->first();
        $data = ContentWhatWeDo::first();
        return view('front.content.whatwedo', compact('data', 'seo'));
    }

    public function contactUs(Request $request)
    {
        $seo = SeoPage::where('page', 'contact')->first();
        $data = ContentContact::first();
        $addresses = OfficeAddress::where('status', 1)->orderBy('position')->get();
        $emails = OfficeEmailId::where('status', 1)->orderBy('position')->get();
        $phone_numbers = OfficePhoneNumber::where('status', 1)->orderBy('position')->first();
        return view('front.content.contact', compact('data', 'seo', 'addresses', 'emails', 'phone_numbers'));
    }

    public function contactFormSubmit(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'company_name' => 'nullable|string|min:1|max:255',
            'full_name' => 'required|string|min:1|max:255',
            'mobile_no' => 'required|integer|digits:10',
            'email' => 'required|email|min:1|max:255',
            'enquiry_type' => 'required|string|min:1|max:255',
            // 'address' => 'nullable|string|min:1|max:255',
            'message' => 'nullable|string|min:1|max:255',
        ]);

        $lead = new Lead();
        $lead->page = $request->page ?? '';
        $lead->company_name = $request->company_name ?? '';
        $lead->full_name = $request->full_name;
        $lead->mobile_no = $request->mobile_no;
        $lead->email = $request->email;
        $lead->enquiry_type = $request->enquiry_type;
        // $lead->address = $request->address ?? '';
        $lead->message = $request->message ?? '';
        $lead->save();

        return redirect()->back()->with('success', 'Thank you for your interest. We will contact you soon.');
    }
    */

    /*
    public function contact(Request $request)
    {
        $seo = SeoPage::where('page', 'contact')->first();
        $data = ContentContact::first();
        return view('front.content.contact', compact('data', 'seo'));
    }

    public function contactEnquiry(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'company_name' => 'nullable|string|min:1|max:255',
            'full_name' => 'required|string|min:1|max:255',
            'mobile_no' => 'required|integer|digits:10',
            'email' => 'required|email|min:1|max:255',
            'address' => 'nullable|string|min:1|max:255',
            'message' => 'nullable|string|min:1|max:255',
        ]);

        $lead = new Lead();
        $lead->page = $request->page ?? '';
        $lead->company_name = $request->company_name ?? '';
        $lead->full_name = $request->full_name;
        $lead->mobile_no = $request->mobile_no;
        $lead->email = $request->email;
        $lead->address = $request->address ?? '';
        $lead->message = $request->message ?? '';
        $lead->save();

        return redirect()->back()->with('success', 'Thank you for your interest. We will contact you soon.');
    }
    */
}
