@extends('layouts.gerant')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->
    <form action="{{ route('gerantPrograms.store') }}" method="post">
        <div class="card">
            <div class="card-body">
                    @csrf
                    <h3>General</h3>
                    <hr>
                    <div class="form-row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="name">Program Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Program name" autocomplete="off" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <input type="text" class="form-control @error('status') is-invalid @enderror" name="status" id="status" placeholder="Active" autocomplete="off" value="{{ old('status') }}" readonly>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Program Starting Date</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" placeholder="Start date" autocomplete="off" value="{{ old('start_date') }}">
                                @error('start_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expiry_date">Program Expiry Date</label>
                                <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" name="expiry_date" id="expiry_date" placeholder="Expiry date" autocomplete="off" value="{{ old('expiry_date') }}">
                                @error('expiry_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tier">Tier</label>
                        <select class="form-control @error('tier') is-invalid @enderror" name="tier" id="tier">
                            <option disabled selected>Select a tier</option>
                            <option value="gold" {{ old('tier') == 'gold' ? 'selected' : '' }}>Gold</option>
                            <option value="silver" {{ old('tier') == 'silver' ? 'selected' : '' }}>Silver</option>
                            <option value="bronze" {{ old('tier') == 'bronze' ? 'selected' : '' }}>Bronze</option>
                        </select>
                        @error('tier')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <br>
                    <h3>Fidelity Points Logic</h3>
                    <hr>
                    <div class="form-group row">
                        <label for="amount" class="col-sm-2 col-form-label">Amount of Money</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" autocomplete="off" value="{{ old('amount') }}">
                            <small class="form-text text-muted">Enter the base amount of money that can be converted to points.</small>
                        </div>
                        
                    
                        <label for="points" class="col-sm-2 col-form-label">Converted to F.Points</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="points" name="points" placeholder="Enter number of converted points" autocomplete="off" value="{{ old('points') }}">
                            <small class="form-text text-muted">Enter the number of fidelity points that will be converted.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="minimum_amount" class="col-sm-2 col-form-label">Minimum Amount Spent (Optional)</label> 
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="minimum_amount" name="minimum_amount" placeholder="Enter minimum amount" autocomplete="off" value="{{ old('minimum_amount') }}">
                            <small class="form-text text-muted">Enter the minimum amount of money that needs to be spent to start converting to fidelity points.</small>
                        </div>
                    </div>

                    <br>
                    <h3>Redemption</h3>
                    <hr>

                    <div class="form-group">
                        <label for="conversion_factor">Conversion Factor</label>
                        <input type="number" class="form-control" id="conversion_factor" name="conversion_factor" placeholder="Enter conversion factor" autocomplete="off" value="{{ old('conversion_factor') }}">
                        <small class="form-text text-muted">Enter how much 1 Loyalty Point costs in base currency</small>
                    </div>
                    <br>
                    <h3>Specificities</h3>
                    <hr>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Enter specificities or notes about the program..."></textarea>
                        <small class="form-text text-muted">Provide any specific details or notes about this program.</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="background-color: #00337C; border-color: #00337C;">Save</button>
                    <a href="{{ route('gerantPrograms.index') }}" class="btn btn-default">Back to list</a>
            </div>
        </div>
    </form>


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