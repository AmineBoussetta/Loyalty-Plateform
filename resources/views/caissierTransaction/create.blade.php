@extends('layouts.caissier')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->
    <form action="{{ route('caissierTransaction.store') }}" method="post">
        <div class="card">
            <div class="card-body">
                    @csrf
                    <h3>Transaction Details</h3>
                    <hr>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="transaction_id">Transaction ID</label>
                                <input type="text" class="form-control @error('transaction_id') is-invalid @enderror" name="transaction_id" id="transaction_id" placeholder="{{ $transactionId }}" autocomplete="off" value="{{ old('transaction_id') }}" readonly>
                                @error('transaction_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="carte_fidelite_id">Loyalty Card ID</label>
                                <input type="text" class="form-control @error('carte_fidelite_id') is-invalid @enderror" name="carte_fidelite_id" id="carte_fidelite_id" placeholder="Loyalty Card ID" autocomplete="off" value="{{ old('carte_fidelite_id') }}">
                                @error('carte_fidelite_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="transaction_date">Transaction Date</label>
                                <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" name="transaction_date" id="transaction_date" placeholder="Transaction Date" autocomplete="off" value="{{ old('transaction_date') }}">
                                @error('transaction_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" placeholder="Amount" autocomplete="off" value="{{ old('amount') }}">
                                @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select class="form-control @error('payment_method') is-invalid @enderror" name="payment_method" id="payment_method">
                            <option value="">Select Payment Method</option>
                            <option value="cash">Cash</option>
                            <option value="fidelity_points">Fidelity Points</option>
                        </select>
                        @error('payment_method')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('caissierTransaction.index') }}" class="btn btn-default">Back to list</a>
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
