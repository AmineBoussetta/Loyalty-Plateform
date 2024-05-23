@extends('layouts.caissier')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Edit Transaction') }}</h1>

    <!-- Main Content goes here -->

    <div class="card">
        <div class="card-body">
            <form action="{{ route('caissierTransaction.update', $transaction->id) }}" method="post">
                @csrf
                @method('put')

                <h3>{{ $title }}</h3>
                <hr>
                    
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="transaction_id">Transaction ID</label>
                        <input type="text" class="form-control" name="transaction_id" value="{{ $transaction->transaction_id }}" readonly>
                        @error('transaction_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="transaction_date">Transaction Date</label>
                        <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" name="transaction_date" value="{{ date('Y-m-d') }}" required>
                        @error('transaction_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" name="amount" value="{{ old('amount', $transaction->amount) }}" required>
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="amount_spent">Amount Spent</label>
                        <input type="number" class="form-control" name="amount_spent" value="{{ old('amount_spent', $transaction->amount_spent) }}" required>
                        @error('amount_spent')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="client_id">Client</label>
                    <select class="form-control" name="client_id" required>
                        <option value="">Select Client</option>
                        <optgroup label="Clients with Fidelity Card">
                            @foreach ($clientsWithCard as $client)
                                <option value="{{ $client->id }}" {{ $transaction->client_id == $client->id ? 'selected' : '' }} data-carte-fidelite-id="{{ $client->carteFidelite->id }}">
                                    {{ $client->name }} ({{ $client->carteFidelite->commercial_ID }})
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Clients without Fidelity Card">
                            @foreach ($clientsWithoutCard as $client)
                                <option value="{{ $client->id }}" {{ $transaction->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                    @error('client_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="payment_method">Payment Method</label>
                    <select class="form-control" name="payment_method">
                        <option value="cash" {{ old('payment_method', $transaction->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="fidelity_points" {{ old('payment_method', $transaction->payment_method) == 'fidelity_points' ? 'selected' : '' }}>Fidelity Points</option>
                    </select>
                    @error('payment_method')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <input type="hidden" name="carte_fidelite_id" id="carte_fidelite_id" value="{{ $transaction->carte_fidelite_id ?? '' }}">
                <button type="submit" class="btn btn-primary"  style="background-color: #00337C; border-color: #00337C;">Save</button>
                <a href="{{ route('caissierTransaction.index') }}" class="btn btn-default">Back to list</a>

            </form>
        </div>
    </div>

    <script>
        document.querySelector('select[name="client_id"]').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var carteFideliteId = selectedOption.getAttribute('data-carte-fidelite-id');
            document.getElementById('carte_fidelite_id').value = carteFideliteId || '';
        });

        // Set the initial value for carte_fidelite_id on page load
        document.addEventListener('DOMContentLoaded', function() {
            var selectedOption = document.querySelector('select[name="client_id"] option:checked');
            var carteFideliteId = selectedOption.getAttribute('data-carte-fidelite-id');
            document.getElementById('carte_fidelite_id').value = carteFideliteId || '';
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