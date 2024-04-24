@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->

    <div class="card">
        <div class="card-body">
        <form action="{{ route('basic.update', $company->id) }}" method="post">
    @csrf
    @method('put')

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Company Name" autocomplete="off" value="{{ old('name') ?? $company->name }}">
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="abbreviation">Abbreviation</label>
        <input type="text" class="form-control @error('abbreviation') is-invalid @enderror" name="abbreviation" id="abbreviation" placeholder="Abbreviation" autocomplete="off" value="{{ old('abbreviation') ?? $company->abbreviation }}">
        @error('abbreviation')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="default_currency">Default Currency</label>
        <input type="text" class="form-control @error('default_currency') is-invalid @enderror" name="default_currency" id="default_currency" placeholder="Default Currency" autocomplete="off" value="{{ old('default_currency') ?? $company->default_currency }}">
        @error('default_currency')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="country">Country</label>
        <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" id="country" placeholder="Country" autocomplete="off" value="{{ old('country') ?? $company->country }}">
        @error('country')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="tax_id">Tax ID</label>
        <input type="text" class="form-control @error('tax_id') is-invalid @enderror" name="tax_id" id="tax_id" placeholder="Tax ID" autocomplete="off" value="{{ old('tax_id') ?? $company->tax_id }}">
        @error('tax_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="managers">Managers</label>
        <input type="text" class="form-control @error('managers') is-invalid @enderror" name="managers" id="managers" placeholder="Managers" autocomplete="off" value="{{ old('managers') ?? $company->managers }}">
        @error('managers')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Phone" autocomplete="off" value="{{ old('phone') ?? $company->phone }}">
        @error('phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" autocomplete="off" value="{{ old('email') ?? $company->email }}">
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="website">Website</label>
        <input type="text" class="form-control @error('website') is-invalid @enderror" name="website" id="website" placeholder="Website" autocomplete="off" value="{{ old('website') ?? $company->website }}">
        @error('website')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Description" autocomplete="off">{{ old('description') ?? $company->description }}</textarea>
        @error('description')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('basic.index') }}" class="btn btn-default">Back to list</a>
</form>

        </div>
    </div>

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
