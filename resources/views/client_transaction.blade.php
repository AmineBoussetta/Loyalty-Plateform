@extends('layouts.client')

@section('main-content')
<div class="container">
        <h1>Transaction History</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Transaction Number</th>
                    
                    
                    <th>Amount Spent</th>
                    <th>Method of Payment</th>
                    <th>Points Earned</th>
                    <th>Cashier ID</th> 
                    <th>Date of Transaction</th>                   
                </tr>
            </thead>
            <tbody>
            @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->transaction_id  }}</td>
                        
                        <td>{{ $transaction->amount_spent  }}</td>
                        <td>{{  $transaction->payment_method }}</td>
                        <td>{{ $transaction->points  }}</td>
                        <td>{{  $transaction->Caissier_ID }}</td>
                        <td>{{ $transaction->transaction_date  }}</td>
                    
                        
             
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    @endsection
