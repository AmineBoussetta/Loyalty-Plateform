@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Edit Company') }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('companies.update', $company->id) }}" method="post">
                @csrf
                @method('patch')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Company Name" value="{{ old('name') ?? $company->name }}">
                </div>

                <div class="form-group">
                    <label for="abbreviation">Abbreviation</label>
                    <input type="text" class="form-control" name="abbreviation" id="abbreviation" placeholder="Abbreviation" value="{{ old('abbreviation') ?? $company->abbreviation }}">
                </div>

                <div class="form-group">
                    <label for="default_currency">Default Currency</label>
                    <input type="text" class="form-control" name="default_currency" id="default_currency" placeholder="Default Currency" value="{{ old('default_currency') ?? $company->default_currency }}">
                </div>

                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" class="form-control" name="country" id="country" placeholder="Country" value="{{ old('country') ?? $company->country }}">
                </div>

                <div class="form-group">
                    <label for="tax_id">Tax ID</label>
                    <input type="text" class="form-control" name="tax_id" id="tax_id" placeholder="Tax ID" value="{{ old('tax_id') ?? $company->tax_id }}">
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="{{ old('phone') ?? $company->phone }}">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') ?? $company->email }}">
                </div>

                <div class="form-group">
                    <label for="website">Website</label>
                    <input type="text" class="form-control" name="website" id="website" placeholder="Website" value="{{ old('website') ?? $company->website }}">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Description">{{ old('description') ?? $company->description }}</textarea>
                </div>

                @if($company->gerants->isNotEmpty())
                <div id="gerantContainer">
                    @foreach($company->gerants as $index => $gerant)
                        <div class="gerant">
                            <h3>Gerant {{ $index + 1 }}</h3>
                            <div class="form-group">
                                <label for="gerant_name_{{ $index }}">Name</label>
                                <input type="text" class="form-control" name="gerant_name[]" id="gerant_name_{{ $index }}" placeholder="Gerant Name" value="{{ old('gerant_name.' . $index) ?? $gerant->name }}">
                            </div>
                            <div class="form-group">
                                <label for="gerant_email_{{ $index }}">Email</label>
                                <input type="email" class="form-control" name="gerant_email[]" id="gerant_email_{{ $index }}" placeholder="Gerant Email" value="{{ old('gerant_email.' . $index) ?? $gerant->email }}">
                            </div>
                            <div class="form-group">
                                <label for="gerant_phone_{{ $index }}">Phone</label>
                                <input type="text" class="form-control" name="gerant_phone[]" id="gerant_phone_{{ $index }}" placeholder="Gerant Phone" value="{{ old('gerant_phone.' . $index) ?? $gerant->phone }}">
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                    <p>No gerants found.</p>
                @endif

                <button type="submit" class="btn btn-primary" style="background-color: #00337C; border-color: #00337C;">Save</button>
                <a href="{{ route('companies.index') }}" class="btn btn-default">Back to list</a>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('addGerant').addEventListener('click', function() {
        var gerantContainer = document.querySelector('#gerantContainer');
        var gerantFields = gerantContainer.querySelectorAll('.gerant');
        var newGerantIndex = gerantFields.length;

        var newGerant = document.createElement('div');
        newGerant.className = 'gerant';
        newGerant.innerHTML = `
            <h3>Gerant ${newGerantIndex + 1}</h3>
            <div class="form-group">
                <label for="gerant_name_${newGerantIndex}">Name</label>
                <input type="text" class="form-control" name="gerant_name[]" id="gerant_name_${newGerantIndex}" placeholder="Gerant Name">
            </div>
            <div class="form-group">
                <label for="gerant_email_${newGerantIndex}">Email</label>
                <input type="email" class="form-control" name="gerant_email[]" id="gerant_email_${newGerantIndex}" placeholder="Gerant Email">
            </div>
            <div class="form-group">
                <label for="gerant_phone_${newGerantIndex}">Phone</label>
                <input type="text" class="form-control" name="gerant_phone[]" id="gerant_phone_${newGerantIndex}" placeholder="Gerant Phone">
            </div>
        `;
        gerantContainer.appendChild(newGerant);
    });
</script>
@endpush