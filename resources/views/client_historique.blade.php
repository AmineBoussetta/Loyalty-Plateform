@extends('layouts.client')

@section('main-content')

<div class="container">
        <h1>Points History</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Fidelity Card Number</th>
                    <th>Total Points</th>
                    <th>Points Spent</th>
                    <th>Points Remaining</th>
                    <th>Transaction ID</th>
                    <th>Program Type</th>
                    
                </tr>
            </thead>
            <tbody>
            
            @foreach ($carteFidelites as $carteFidelite)
                @foreach ($transactionDetails as $tran)
                    @if ($tran['transaction']->carte_fidelite_id == $carteFidelite->id)
                        <tr>
                            <td>{{ $carteFidelite->commercial_ID }}</td>
                            <td>{{ $carteFidelite->points_sum }}</td>
                            <td>{{ $tran['points_spent'] }}</td>
                            <td>{{ $carteFidelite->points_sum - $tran['points_spent'] }}</td>
                            <td>{{ $tran['transaction']->transaction_id }}</td>
                            <td>{{ $tran['program']->name }}</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
            
            </tbody>
        </table>
    </div>
    @endsection