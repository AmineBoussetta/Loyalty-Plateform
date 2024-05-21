@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 font-weight-bold" style="color: #00337C;">{{ $title ?? __('New Company') }}</h1>

    <!-- Main Content goes here -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('companies.store') }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold text-black">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" autocomplete="off" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="abbreviation" class="font-weight-bold text-black">Abbreviation</label>
                            <input type="text" class="form-control @error('abbreviation') is-invalid @enderror" name="abbreviation" id="abbreviation" placeholder="Abbreviation" autocomplete="off" value="{{ old('abbreviation') }}">
                            @error('abbreviation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="default_currency" class="font-weight-bold text-black">Default Currency</label>
                            <select class="form-control" name="default_currency" id="default_currency">
                                <option value="">Select Currency</option>
                                @foreach($currencies as $code => $name)
                                    <option value="{{ $code }}">{{ $name }} ({{ $code }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country" class="font-weight-bold text-black">Country</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" id="country" placeholder="Country" autocomplete="off" value="{{ old('country') }}">
                            @error('country')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tax_id" class="font-weight-bold text-black">Tax ID</label>
                            <input type="text" class="form-control @error('tax_id') is-invalid @enderror" name="tax_id" id="tax_id" placeholder="Tax ID" autocomplete="off" value="{{ old('tax_id') }}">
                            @error('tax_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="font-weight-bold text-black">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Phone" autocomplete="off" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="font-weight-bold text-black">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" autocomplete="off" value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="website" class="font-weight-bold text-black">Website</label>
                            <input type="text" class="form-control @error('website') is-invalid @enderror" name="website" id="website" placeholder="Website" autocomplete="off" value="{{ old('website') }}">
                            @error('website')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="font-weight-bold text-black">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3" placeholder="Description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Manager Fields Card -->
                <div class="card mt-4">
                    <div class="card-header font-weight-bold h4">
                        Managers
                    </div>
                    <div class="card-body" id="managersContainer">
                        <div class="manager-group">
                            <strong>Manager 1</strong>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gerant_name_1" class="font-weight-bold text-black">Manager Name</label>
                                        <input type="text" class="form-control" name="gerant_name[]" placeholder="Manager Name" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gerant_email_1" class="font-weight-bold text-black">Manager Email</label>
                                        <input type="email" class="form-control" name="gerant_email[]" placeholder="Manager Email" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gerant_phone_1" class="font-weight-bold text-black">Manager Phone</label>
                                        <input type="text" class="form-control" name="gerant_phone[]" placeholder="Manager Phone" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary" style="background-color: #00337C; border-color: #00337C;">Save</button>
                    <button type="button" class="btn btn-success" id="addManagerBtn" style="background-color: #03C988; border-color: #03C988;">Add More Managers</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript to add more managers -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let managerCount = 1;

            document.getElementById('addManagerBtn').addEventListener('click', function() {
                managerCount++;

                const newManagerFields = `
                    <div class="manager-group mt-4">
                        <strong>Manager ${managerCount}</strong>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gerant_name_${managerCount}" class="font-weight-bold text-black">Manager Name</label>
                                    <input type="text" class="form-control" name="gerant_name[]" placeholder="Manager Name" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gerant_email_${managerCount}" class="font-weight-bold text-black">Manager Email</label>
                                    <input type="email" class="form-control" name="gerant_email[]" placeholder="Manager Email" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gerant_phone_${managerCount}" class="font-weight-bold text-black">Manager Phone</label>
                                    <input type="text" class="form-control" name="gerant_phone[]" placeholder="Manager Phone" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                document.getElementById('managersContainer').insertAdjacentHTML('beforeend', newManagerFields);
            });
        });
    </script>
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
