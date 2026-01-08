@extends('layouts.app')

@section('title', 'Edit Contact - ' . $contact->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('contacts.index') }}">Contacts</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('contacts.show', $contact) }}">{{ $contact->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">
                    <i class="bi bi-pencil-square"></i> Edit Contact
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('contacts.update', $contact) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $contact->name) }}"
                               placeholder="Enter full name (min. 5 characters)"
                               required>
                        @error('name')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <small class="form-text text-muted">
                            Name must be at least 5 characters long
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="contact" class="form-label">
                            Contact Number <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('contact') is-invalid @enderror" 
                               id="contact" 
                               name="contact" 
                               value="{{ old('contact', $contact->contact) }}"
                               placeholder="Enter 9-digit contact number"
                               maxlength="9"
                               required>
                        @error('contact')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <small class="form-text text-muted">
                            Must be exactly 9 digits (e.g., 912345678)
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email Address <span class="text-danger">*</span>
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $contact->email) }}"
                               placeholder="Enter email address"
                               required>
                        @error('email')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <small class="form-text text-muted">
                            Must be a valid email address
                        </small>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Note:</strong> Contact number and email must be unique. 
                        They cannot be the same as another existing contact.
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a href="{{ route('contacts.show', $contact) }}" class="btn btn-secondary">
                                <i class="bi bi-x"></i> Cancel
                            </a>
                            <a href="{{ route('contacts.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back to List
                            </a>
                        </div>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Update Contact
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3 border-secondary">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-clock-history"></i> Current Values
                </h6>
                <table class="table table-sm mb-0">
                    <tbody>
                        <tr>
                            <th width="30%">Name:</th>
                            <td>{{ $contact->name }}</td>
                        </tr>
                        <tr>
                            <th>Contact:</th>
                            <td>{{ $contact->contact }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $contact->email }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td>{{ $contact->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-3 border-warning">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-lightbulb text-warning"></i> Field Requirements
                </h6>
                <ul class="mb-0 small">
                    <li><strong>Name:</strong> Must be at least 5 characters</li>
                    <li><strong>Contact:</strong> Must be exactly 9 digits and unique across all contacts</li>
                    <li><strong>Email:</strong> Must be a valid email format and unique across all contacts</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('contact').addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '').substring(0, 9);
    });

    let formChanged = false;
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input');
    
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            formChanged = true;
        });
    });

    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    form.addEventListener('submit', () => {
        formChanged = false;
    });
</script>
@endpush