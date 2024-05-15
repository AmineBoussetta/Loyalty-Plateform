@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->
<div class="card">
    <div class="card-body">
        <form action="{{ route('companies.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="abbreviation">Abbreviation</label>
                <input type="text" class="form-control @error('abbreviation') is-invalid @enderror" name="abbreviation" id="abbreviation" placeholder="Abbreviation" autocomplete="off" value="{{ old('abbreviation') }}">
                @error('abbreviation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
    <label for="default_currency">Default Currency</label>
    <select class="form-control" name="default_currency" id="default_currency">
        <option value="">Select Currency</option>
        @foreach($currencies as $code => $name)
            <option value="{{ $code }}">{{ $name }} ({{ $code }})</option>
        @endforeach
    </select>
</div>


            <div class="form-group">
                <label for="country">Country</label>
                <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" id="country" placeholder="Country" autocomplete="off" value="{{ old('country') }}">
                @error('country')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tax_id">Tax ID</label>
                <input type="text" class="form-control @error('tax_id') is-invalid @enderror" name="tax_id" id="tax_id" placeholder="Tax ID" autocomplete="off" value="{{ old('tax_id') }}">
                @error('tax_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Phone" autocomplete="off" value="{{ old('phone') }}">
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" autocomplete="off" value="{{ old('email') }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="website">Website</label>
                <input type="text" class="form-control @error('website') is-invalid @enderror" name="website" id="website" placeholder="Website" autocomplete="off" value="{{ old('website') }}">
                @error('website')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3" placeholder="Description">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div><!-- Separator Line -->
<hr>

<!-- Manager Fields -->
<div class="form-group">
    <strong>Manager 1</strong>
    <label for="gerant_name">Manager Name</label>
    <input type="text" class="form-control" name="gerant_name[]" placeholder="Manager Name" autocomplete="off">
</div>

<div class="form-group">
    <label for="gerant_email">Manager Email</label>
    <input type="email" class="form-control" name="gerant_email[]" placeholder="Manager Email" autocomplete="off">
</div>

<div class="form-group">
    <label for="gerant_phone">Manager Phone</label>
    <input type="text" class="form-control" name="gerant_phone[]" placeholder="Manager Phone" autocomplete="off">
</div>

<!-- Container for adding more managers -->
<div id="managersContainer"></div>
  <!-- Submit Button -->
  <button type="submit" class="btn btn-primary" style="background-color: #00337C; border-color: #00337C;">Save</button>
<!-- Button to add more managers -->
<button type="button" class="btn btn-primary" id="addManagerBtn"style="background-color: #03C988; border-color: #03C988;" >Add More Managers</button>


<!-- JavaScript to add more managers -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize manager count
        let managerCount = 1;

        // Button click event to add more managers
        document.getElementById('addManagerBtn').addEventListener('click', function() {
            managerCount++;

            // Create new manager fields
            const newManagerFields = `
                <div class="form-group">
                <strong>Manager ${managerCount}</strong>
                </br>
                    <label for="gerant_name_${managerCount}">Manager Name</label>
                    <input type="text" class="form-control" name="gerant_name[]" placeholder="Manager Name" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="gerant_email_${managerCount}">Manager Email</label>
                    <input type="email" class="form-control" name="gerant_email[]" placeholder="Manager Email" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="gerant_phone_${managerCount}">Manager Phone</label>
                    <input type="text" class="form-control" name="gerant_phone[]" placeholder="Manager Phone" autocomplete="off">
                </div>
            `;

            // Append new manager fields to the container
            document.getElementById('managersContainer').insertAdjacentHTML('beforeend', newManagerFields);
        });
    });
</script>

    <!-- End of Main Content -->
@endsection

@push('notif')
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning border-left-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
@endpush