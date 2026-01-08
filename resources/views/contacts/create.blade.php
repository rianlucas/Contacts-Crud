@extends('layouts.app')

@section('title', 'Add New Contact')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="bi bi-person-plus"></i> Add New Contact
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('contacts.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
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
                               value="{{ old('contact') }}"
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
                               value="{{ old('email') }}"
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
 
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('contacts.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Save Contact
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3 border-info">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-info-circle text-info"></i> Field Requirements
                </h6>
                <ul class="mb-0 small">
                    <li><strong>Name:</strong> Must be at least 5 characters</li>
                    <li><strong>Contact:</strong> Must be exactly 9 digits and unique</li>
                    <li><strong>Email:</strong> Must be a valid email format and unique</li>
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
</script>
@endpush