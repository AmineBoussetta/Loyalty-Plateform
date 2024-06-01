@extends('layouts.client')

@section('main-content')

<div class="container">
        <h1>Historique des points</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>N° Carte Fidelite</th>
                    <th>Total des Points</th>
                    <th>Points Spent</th>
                    <th>Points reste</th>
                    <th>Type Programme</th>
                    
                </tr>
            </thead>
            <tbody>
            @foreach ($carteFidelites as $carteFidelite)
               
                <tr>
                    <td>{{ $carteFidelite->commercial_ID }}</td>
                    <td>{{ $carteFidelite->points_sum }}</td>
                    <td>{{ $carteFidelite->points_sum }}</td>
                    <td>{{ $carteFidelite->points_sum }}</td>
                    <td>{{ $carteFidelite->fidelity_program }}</td>
                                               
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endsection