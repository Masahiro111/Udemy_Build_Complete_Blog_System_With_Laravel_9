<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'subject' => 'nullable|min:5|max:50',
            'message' => 'required|min:5|max:500',
        ]);

        Contact::query()->create($validated);

        Mail::to("admin@example.com")
            ->send(new ContactMail(
                $validated['first_name'],
                $validated['last_name'],
                $validated['email'],
                $validated['subject'],
                $validated['message']
            ));

        return redirect()->route('contact.create')
            ->with('success', 'Your Message has been sent');
    }
}
