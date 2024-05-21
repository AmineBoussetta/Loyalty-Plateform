@extends('layouts.caissier')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Cancelled Transactions') }}</h1>


    <div class="mb-3">
        <a href="{{ route('caissierTransaction.index') }}" class="btn btn-primary">Go Back to Active Transactions</a>
    </div>

    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>No</th>
                <th>Transaction Date</th>
                <th>Amount</th>
                <th>Points Substructed</th>
                <th>Money Substructed</th>
                <th>Client</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cancelledTransactions as $cancelledTransaction)
                <tr onclick="window.location='{{ route('gerantPrograms.edit', $cancelledTransaction->id) }}';" style="cursor:pointer;">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cancelledTransaction->transaction_date }}</td>
                    <td>{{ $cancelledTransaction->amount }}</td>
                    <td>- {{ $cancelledTransaction->points }}</td>
                    <td>- {{ $cancelledTransaction->points * $cancelledTransaction->carteFidelite->program->conversion_factor }}</td>
                    <td>{{ $cancelledTransaction->carteFidelite->holder_name }} ({{ $cancelledTransaction->carteFidelite->commercial_ID }})</td>
                    <td>{{ $cancelledTransaction->status }}</td>
                    <td>
                        <div class="d-inline">
                            <form action="{{ route('caissierTransaction.reactivate', $cancelledTransaction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure to reactivate this transaction?')">Amend</button>
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