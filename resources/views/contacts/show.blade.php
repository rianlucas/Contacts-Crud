@extends('layouts.app')

@section('title', 'Contact Details - ' . $contact->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('contacts.index') }}">Contacts</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $contact->name }}
                </li>
            </ol>
        </nav>

        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">
                    <i class="bi bi-person-circle"></i> Contact Details
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-4">
                            <label class="text-muted small text-uppercase">Contact ID</label>
                            <h5 class="mb-0">#{{ $contact->id }}</h5>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <label class="text-muted small text-uppercase">
                                <i class="bi bi-person"></i> Full Name
                            </label>
                            <h4 class="mb-0">{{ $contact->name }}</h4>
                        </div>

                        <div class="mb-4">
                            <label class="text-muted small text-uppercase">
                                <i class="bi bi-telephone"></i> Contact Number
                            </label>
                            <h5 class="mb-0">
                                <a href="tel:{{ $contact->contact }}" class="text-decoration-none">
                                    {{ $contact->contact }}
                                </a>
                            </h5>
                        </div>

                        <div class="mb-4">
                            <label class="text-muted small text-uppercase">
                                <i class="bi bi-envelope"></i> Email Address
                            </label>
                            <h5 class="mb-0">
                                <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                    {{ $contact->email }}
                                </a>
                            </h5>
                        </div>

                        <hr>

                        <!-- Timestamps -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small text-uppercase">Created At</label>
                                <p class="mb-0">
                                    <i class="bi bi-calendar-plus"></i> 
                                    {{ $contact->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small text-uppercase">Last Updated</label>
                                <p class="mb-0">
                                    <i class="bi bi-calendar-check"></i> 
                                    {{ $contact->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('contacts.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                    
                    <div class="btn-group">
                        <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit Contact
                        </a>
                        
                        <button type="button" 
                                class="btn btn-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i> Delete Contact
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this contact?</p>
                <div class="alert alert-warning">
                    <strong>Contact:</strong> {{ $contact->name }}<br>
                    <strong>Email:</strong> {{ $contact->email }}
                </div>
                <p class="text-danger mb-0">
                    <i class="bi bi-info-circle"></i> This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i> Cancel
                </button>
                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Yes, Delete Contact
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection