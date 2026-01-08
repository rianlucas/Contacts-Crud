@extends('layouts.app')

@section('title', 'All Contacts')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="display-5">
            <i class="bi bi-people"></i> Contact List
        </h1>
        <p class="text-muted">Manage all your contacts in one place</p>
    </div>
    @auth
    <div class="col-md-4 text-end">
        <a href="{{ route('contacts.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Add New Contact
        </a>
    </div>
    @else
    <div class="col-md-4 text-end">
        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
            <i class="bi bi-box-arrow-in-right"></i> Login to Manage
        </a>
    </div>
    @endauth
</div>

@if($contacts->isEmpty())
    <div class="alert alert-info text-center py-5">
        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
        <h4 class="mt-3">No contacts found</h4>
        <p class="text-muted">Start by adding your first contact!</p>
    </div>
@else
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="25%">Name</th>
                            <th width="20%">Contact</th>
                            <th width="25%">Email</th>
                            <th width="25%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>
                                <strong>{{ $contact->name }}</strong>
                            </td>
                            <td>
                                <i class="bi bi-telephone"></i> {{ $contact->contact }}
                            </td>
                            <td>
                                <i class="bi bi-envelope"></i> {{ $contact->email }}
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('contacts.show', $contact) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="View Details">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    
                                    @auth
                                    <a href="{{ route('contacts.edit', $contact) }}" 
                                       class="btn btn-sm btn-warning" 
                                       title="Edit Contact">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('contacts.destroy', $contact) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                title="Delete Contact">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                    @endauth
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($contacts->hasPages())
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $contacts->firstItem() }} to {{ $contacts->lastItem() }} of {{ $contacts->total() }} contacts
                </div>
                <div>
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
@endif

<div class="mt-3">
    <small class="text-muted">
        <i class="bi bi-info-circle"></i> 
        Total contacts: <strong>{{ $contacts->total() }}</strong>
    </small>
</div>
@endsection
