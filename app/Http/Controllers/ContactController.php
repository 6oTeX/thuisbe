<?php
// app/Http/Controllers/ContactController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact; // Import the Contact model

class ContactController extends Controller
{

        // Method to display the list of messages
        public function index()
        {
            $contacts = Contact::all();
            return view('contacts.index', compact('contacts'));
        }
    // Method to display the contact form
    public function show()
    {
        return view('contact');
    }

    // Method to handle form submission
    public function submit(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Create a new Contact instance
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->message = $request->message;

        // Save the contact data
        $contact->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}