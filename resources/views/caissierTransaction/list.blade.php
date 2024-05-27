@extends('layouts.caissier')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Transactions') }}</h1>

    <!-- Search Bar -->
    <form action="{{ route('caissierTransaction.index') }}" method="GET" class="mb-4">
        <div class="form-row align-items-center">
            <!-- Search Bar -->
            <div class="form-group col-md-4 mb-2">
                <input type="text" name="search" class="form-control" placeholder="Search transactions..." value="{{ request()->query('search') }}">
            </div>
            <div class="form-group col-md-4 mb-2">
                <input type="date" name="searchDate" class="form-control" value="{{ request()->query('searchDate') }}">
            </div>
            <!-- Search Button -->
            <div class="form-group col-md-1 mb-2">
                <button type="submit" class="btn btn-outline-primary w-100">Search</button>
            </div>
            <!-- Clear Button -->
            <div class="form-group col-md-1 mb-2">
                <a href="{{ route('caissierTransaction.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
            </div>
        </div>
        <!-- With Card Checkbox -->
        <div class="form-row align-items-center">
            <div class="form-group col-md-2 mb-2">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" name="withCard" id="customSwitch1" {{ request()->query('withCard') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="customSwitch1">
                        With Card
                    </label>
                </div>
            </div>
        </div>
        <!-- Without Card Checkbox -->
        <div class="form-row align-items-center">
            <div class="form-group col-md-2 mb-2">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" name="withoutCard" id="customSwitch2" {{ request()->query('withoutCard') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="customSwitch2">
                        Without Card
                    </label>
                </div>
            </div>
        </div>
    </form>
    
    <!-- Main Content goes here -->
    <a href="{{ route('caissierTransaction.create') }}" class="btn btn-primary mb-3" style="background-color: #00337C; border-color: #00337C;">Add Transactions</a>
    <a href="{{ route('caissierTransaction.cancelledTransactions') }}" class="btn btn-secondary mb-3">View Cancelled Transactions</a>
    
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    
    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Status</th>
                <th>Transaction Date <span class="sort-indicator">▼</span></th>
                <th>Transaction Amount</th>
                <th>Points Added/Deducted from the Card</th>
                <th>Money Added/Deducted from the Card</th>
                <th>Client</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_id }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>{{ $transaction->transaction_date }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>
                        @if ($transaction->carteFidelite)
                            @if ($transaction->payment_method == 'fidelity_points')
                                - {{ $transaction->points }}
                            @else
                                + {{ $transaction->points }}
                            @endif
                        @else
                            No Card
                        @endif
                    </td>
                    <td>
                        @if ($transaction->carteFidelite)
                            @if ($transaction->payment_method == 'fidelity_points')
                                - {{ $transaction->amount }}
                            @else
                                + {{ $transaction->points * $transaction->carteFidelite->program->conversion_factor }}
                            @endif
                        @else
                            No Card
                        @endif
                    </td>
                    <td>
                        @if ($transaction->carteFidelite)
                            {{ $transaction->carteFidelite->client->name }} ({{ $transaction->carteFidelite->tier }})
                        @else
                            {{ $transaction->client->name }}
                        @endif
                    </td>
                    <td>
                        <div class="d-row">
                            <form action="{{ route('caissierTransaction.cancel', $transaction->id) }}" method="post" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Are you sure to cancel this transaction?')">Cancel Transaction</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No transactions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $transactions->links() }}

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
