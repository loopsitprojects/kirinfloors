<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Models\ContactEnquiry;
use App\Services\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:5000',
        ]);

        if (! Recaptcha::passes($request, 'contact')) {
            return back()->withInput()->withErrors([
                'form' => 'Sorry, we could not verify your message. Please try again, or call or email us directly.',
            ]);
        }

        // Save and email independently: the enquiry only counts as lost if both fail.
        $enquiry = rescue(fn () => ContactEnquiry::create($validated));

        try {
            Mail::to(config('services.contact_email'))->send(new ContactFormMail($validated));
            rescue(fn () => $enquiry?->update(['emailed_at' => now()]));
        } catch (Throwable $e) {
            report($e);

            if (! $enquiry) {
                return back()->withInput()->withErrors([
                    'form' => 'Sorry, we could not send your message. Please try again, or call or email us directly.',
                ]);
            }
        }

        return redirect()->route('thank-you-contact');
    }
}
