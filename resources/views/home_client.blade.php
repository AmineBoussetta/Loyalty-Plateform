@extends('layouts.client')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

    @if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
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

    <div class="row mt-3">
    <div class="col-xl-12">
        <div class="card-header pt-7">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-800">Top Clients by Points</span><br>
                <div class='py-2'></div>
                <span class="text-gray-400 mt-1 fw-semibold fs-1">Clients with highest points</span>
            </h3>
            <!--end::Title-->
            <div class="col-lg-12 mb-4">
                <canvas id="topClientsChart" style="width: 100%; height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-xl-6">
        <div class="card-header pt-7">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-800">Points Spent  vs Points Remaining </span><br>
                <div class='py-2'></div>
                <span class="text-gray-400 mt-1 fw-semibold fs-6">Fidelity points used </span>
            </h3>
            <!--end::Title-->
            <div class="col-lg-12 mb-4">
                <canvas id="programFidelityCardsChart" style="width: 100%; height: 450px;"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6">
    <div class="card-header pt-7">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-800">Total Money Spent</span><br>
                <div class='py-2'></div>
                <span class="text-gray-400 mt-1 fw-semibold fs-1">Total money spent </span>
            </h3>
            <!--end::Title-->
            <div class="col-lg-12 mb-4">
                <canvas id="moneySpentMonthlyChart" style="width: 100%; height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-xl-12">
        
    </div>
</div>



<!-- Add Chart.js script here -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- JavaScript code to create the charts -->
<script>




   
// Total Money Spent by Clients Monthly Chart
var ctxMoneySpentMonthly = document.getElementById('moneySpentMonthlyChart').getContext('2d');
var moneySpentMonthlyData = {
    labels: {!! json_encode($moneySpentMonthly->pluck('month')) !!},
    datasets: [{
        label: 'Total Money Spent',
        data: {!! json_encode($moneySpentMonthly->pluck('total_money_spent')) !!},
        backgroundColor: 'rgba(255, 99, 132, 0.2)', // Red
        borderColor: 'rgba(255, 99, 132, 1)', // Red
        borderWidth: 1
    }]
};
var moneySpentMonthlyChart = new Chart(ctxMoneySpentMonthly, {
    type: 'bar',
    data: moneySpentMonthlyData,
    options: {
        scales: {
            y: {
                beginAtZero: true,
                grid: { display: false }
            },
            x: {
                grid: { display: false }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: false
            }
        },
        borderRadius: 12,
    }
});



</script>
@endsection
