@extends('layouts.client')

@section('main-content')
<div class="container">
        <h1>Historique des transactions</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>N° Transaction</th>
                    
                    
                    <th>Amount Spent</th>
                    <th>Method of Payment</th>
                    <th>Points Won</th>
                    <th>ID Caissier</th> 
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
                        <td>{{  $transaction->caissier_id }}</td>
                        <td>{{ $transaction->transaction_date  }}</td>
                    
                        
             
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    @endsection
