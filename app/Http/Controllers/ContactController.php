<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::paginate(15);
        return view('contacts.index', compact('contacts'));
    }
    
    public function create()
    {
        return view('contacts.create');
    }
    
    public function store(StoreContactRequest $request)
    {
        Contact::create($request->validated());
        return redirect()->route('contacts.index')
            ->with('success', 'Contact created successfully.');
    }
    
    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }
    
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }
    
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contact->update($request->validated());
        return redirect()->route('contacts.show', $contact)
            ->with('success', 'Contact updated successfully.');
    }
    
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
}
