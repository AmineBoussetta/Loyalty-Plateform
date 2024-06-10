@extends('layouts.caissier')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Cancelled Transactions List') }}</h1>

    <form action="{{ route('caissierTransaction.cancelledTransactions') }}" method="GET" class="mb-4">
        <div class="form-row align-items-center">
            <!-- Card Filter Dropdown -->
            <div class="form-group col-md-2 mb-2">
                <select name="cardFilter" class="form-control custom-select">
                    <option value="" {{ request()->query('cardFilter') == '' ? 'selected' : '' }}>All Transactions</option>
                    <option value="withCard" {{ request()->query('cardFilter') == 'withCard' ? 'selected' : '' }}>With Card</option>
                    <option value="withoutCard" {{ request()->query('cardFilter') == 'withoutCard' ? 'selected' : '' }}>Without Card</option>
                </select>
            </div>
            <!-- Search Bar -->
            <div class="form-group col-md-3 mb-2">
                <input type="text" name="search" class="form-control" placeholder="Search by: TRANS-ID, amount, client" value="{{ request()->query('search') }}">
            </div>
            <!-- Search Date -->
            <div class="form-group col-md-3 mb-2">
                <input type="date" name="searchDate" class="form-control" value="{{ request()->query('searchDate') }}">
            </div>
            <!-- Search Button -->
            <div class="form-group col-md-2 mb-2">
                <button type="submit" class="btn btn-outline-primary w-100">Apply Filter</button>
            </div>
            <!-- Clear Button -->
            <div class="form-group col-md-2 mb-2">
                <a href="{{ route('caissierTransaction.cancelledTransactions') }}" class="btn btn-outline-secondary w-100">Clear Filter</a>
            </div>
        </div>
    </form>


    <div class="mb-3">
        <a href="{{ route('caissierTransaction.index') }}" class="btn btn-primary" style="background-color: #00337C; border-color: #00337C;"><span class="sort-indicator" >←</span> Go back to Active Transactions</a>
    </div>

    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Status</th>
                <th>Transaction Date</th>
                <th>Amount</th>
                <th>Points Added/Deducted from the Card</th>
                <th>Money Added/Deducted from the Card</th>
                <th>Client</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cancelledTransactions as $cancelledTransaction)
                    <tr onclick="window.location='{{ route('caissierTransaction.edit', $cancelledTransaction->id) }}';" style="cursor:pointer;">
                        <td>{{ $cancelledTransaction->transaction_id }}</td>
                        <td>{{ $cancelledTransaction->status }}</td>
                        <td>{{ $cancelledTransaction->transaction_date }}</td>
                        <td>{{ $cancelledTransaction->amount }}</td>
                        <td>
                            @if ($cancelledTransaction->carteFidelite)
                                @if ($cancelledTransaction->payment_method == 'fidelity_points')
                                    {{ $cancelledTransaction->points }}
                                @else
                                    + {{ $cancelledTransaction->points }}
                                @endif
                            @else
                                No Card
                            @endif
                        </td>
                        <td>
                            @if ($cancelledTransaction->carteFidelite)
                                @if ($cancelledTransaction->payment_method == 'fidelity_points')
                                    - {{ $cancelledTransaction->amount }}
                                @else
                                    + {{ $cancelledTransaction->points * $cancelledTransaction->carteFidelite->program->conversion_factor }}
                                @endif
                            @else
                                No Card
                            @endif
                        </td>
                        <td>
                            @if ($cancelledTransaction->carteFidelite)
                                {{ $cancelledTransaction->carteFidelite->client->name }} ({{ $cancelledTransaction->carteFidelite->tier }})
                            @else
                                {{ $cancelledTransaction->client->name }}
                            @endif
                        </td>
                        <td>
                            <div class="d-inline">
                                <form action="{{ route('caissierTransaction.reactivate', $cancelledTransaction->id) }}" method="POST" style="display:inline-block; margin-right: 10px;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure to reactivate this transaction?')">Amend</button>
                                </form>
                                <form action="{{ route('caissierTransaction.permanentDelete', $cancelledTransaction->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this transaction permanently?')">Permanent Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No inactive programs found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $cancelledTransactions->links() }}
@endsection