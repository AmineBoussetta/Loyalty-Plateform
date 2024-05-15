@extends('layouts.caissier')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Transactions') }}</h1>

    <!-- Search Bar -->
    <form action="{{ route('caissierTransaction.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search transactions..." value="{{ request()->query('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-outline-primary">Search</button>
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
                <th>No</th>
                <th>Transaction Date</th>
                <th>Amount</th>
                <th>Points Added</th>
                <th>Client Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr onclick="window.location='{{ route('caissierTransaction.edit', $transaction->id) }}';" style="cursor:pointer;">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->transaction_date }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>+ {{ $transaction->points }}</td>
                    <td>{{ $transaction->carteFidelite->holder_name ?? 'N/A' }}</td>
                    <td>
                        <div class="d-row">
                            <form action="{{ route('caissierTransaction.destroy', $transaction->id) }}" method="post" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this transaction?')" style="background-color: #F05713; border-color: #F05713;">Delete</button>
                            </form>
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
                    <td colspan="6" class="text-center">No transactions found.</td>
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