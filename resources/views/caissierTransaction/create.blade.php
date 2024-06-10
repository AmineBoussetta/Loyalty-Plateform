@extends('layouts.caissier')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>
    <!-- Main Content goes here -->
    <form action="{{ route('caissierTransaction.store') }}" method="post">
        <div class="card">
            <div class="card-body">
                @csrf
                <h3>Create Transaction</h3>
                <hr>
                <div class="form-group">
                    <label for="transaction_id">Transaction ID</label>
                    <input type="text" class="form-control" name="transaction_id" value="{{ $transactionId }}" readonly>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                    <label for="client_id">Client</label>
                    <select class="form-control @error('client_id') is-invalid @enderror" name="client_id" required>
                        <option value="">Select Client</option>
                        <optgroup label="Clients with Fidelity Card">
                            @foreach ($clientsWithCard as $client)
                                <option value="{{ $client->id }}" data-carte-fidelite-id="{{ $client->carteFidelite->id }}">{{ $client->name }} ({{ $client->carteFidelite->commercial_ID }})</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Clients without Fidelity Card">
                            @foreach ($clientsWithoutCard as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                    @error('client_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div>
                    <div class="col-md-6">
                    <label for="payment_method">Payment Method</label>
                    <select class="form-control @error('payment_method') is-invalid @enderror" name="payment_method">
                        <option value="cash">Cash</option>
                        <option value="fidelity_points">Fidelity Points</option>
                    </select>
                    @error('payment_method')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="transaction_date">Transaction Date</label>
                    <input type="datetime-local" class="form-control @error('transaction_date') is-invalid @enderror" name="transaction_date" id="transaction_date" value="{{ $currentDateTime }}" required>
                    @error('transaction_date')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <br>
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="amount">Total Amount</label>
                        <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" name="amount" placeholder="Total Amount" required>
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="amount_spent">Amount Spent</label>
                        <input type="number" step="0.01" class="form-control @error('amount_spent') is-invalid @enderror" name="amount_spent" placeholder="Amount Spent" required>
                        @error('amount_spent')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <br>
                
                <input type="hidden" name="carte_fidelite_id" id="carte_fidelite_id">
                <button type="submit" class="btn btn-primary" style="background-color: #00337C; border-color: #00337C;">Create Transaction</button>
            </div>
        </div>
    </form>

    <script>
        document.querySelector('select[name="client_id"]').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
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
