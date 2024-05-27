@extends('layouts.gerant')

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
<!-- Date Filter Form -->
<form method="GET" action="{{ route('home_gerant') }}">
    <div class="row align-items-end">
        <div class="col-md-2">
            <div class="form-group">
                <label for="start_date">Start Date :</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="end_date">End Date :</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
        </div>
        <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block ml-2" style="background-color: #5CE1E6; border-color: #5CE1E6; font-size: 17px;" >Apply Filter</button>
            </div>
        </div>
       
           
       
    
</form>


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
                <span class="card-label fw-bold text-gray-800">Programs vs Fidelity Cards </span><br>
                <div class='py-2'></div>
                <span class="text-gray-400 mt-1 fw-semibold fs-6">Fidelity cards used per program</span>
            </h3>
            <!--end::Title-->
            <div class="col-lg-12 mb-4">
                <canvas id="programFidelityCardsChart" style="width: 100%; height: 450px;"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6">
        <div class="row">
            <div class="col-xl-12 ">
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">Client Statistics </span><br>
                        <div class='py-2'></div>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Client per month</span>
                    </h3>
                    <!--end::Title-->
                    <div class="col-lg-12 mb-4">
                        <canvas id="clientChart" style="width: 100%; height: 200px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 mt-3">
                <div class="card-header pt-7 mb-3" >
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">Fidelity Cards Statistics </span><br>
                        <div class='py-2'></div>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Cards per month</span>
                    </h3>
                    <!--end::Title-->
                    <div class="col-lg-12 mb-4">
                        <canvas id="fidelityCardsChart" style="width: 100%; height: 200px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-xl-12">
        <div class="card-header pt-7">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-800">Total Money Spent by Clients Monthly</span><br>
                <div class='py-2'></div>
                <span class="text-gray-400 mt-1 fw-semibold fs-1">Total money spent by all clients per month</span>
            </h3>
            <!--end::Title-->
            <div class="col-lg-12 mb-4">
                <canvas id="moneySpentMonthlyChart" style="width: 100%; height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>


<!-- Add Chart.js script here -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- JavaScript code to create the charts -->
<script>
    // Client Chart
    var ctxClient = document.getElementById('clientChart').getContext('2d');
    var clientData = {
        labels: {!! json_encode($clientsData->pluck('month')->map(function($month) {
            return date('M', strtotime($month . '-01'));
        })) !!},
        datasets: [{
            label: 'Number of Clients',
            data: {!! json_encode($clientsData->pluck('count')) !!},
            backgroundColor: 'rgba(54, 162, 235, 1)',
            borderColor: 'rgba(54, 162, 132, 1)',
            borderWidth: 1
        }]
    };
    var clientChart = new Chart(ctxClient, {
        type: 'line',
        data: clientData,
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
            fill: {
                target: 'origin',
                above: '#d2e9f3',
                below: 'rgba(135, 162, 251, 0.1)'
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: false
                }
            }
        }
    });

    // Fidelity Cards Chart
    var ctxFidelity = document.getElementById('fidelityCardsChart').getContext('2d');
    var fidelityCardsData = {
        labels: {!! json_encode($fidelityCardsData->pluck('month')->map(function($month) {
            return date('M', strtotime('2023-' . $month . '-01'));
        })) !!},
        datasets: [{
            label: 'Number of Fidelity Cards',
            data: {!! json_encode($fidelityCardsData->pluck('count')) !!},
            backgroundColor: '#FFD52B',
            borderColor: '#FFD52B',
            borderWidth: 1
        }]
    };
    var fidelityCardsChart = new Chart(ctxFidelity, {
        type: 'line',
        data: fidelityCardsData,
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
            fill: {
                target: 'origin',
                above: '#FFF0B5',
                below: 'rgba(0, 99, 132, 0.1)'
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: false
                }
            }
        }
    });

    // Top Clients Chart
    var ctxTopClients = document.getElementById('topClientsChart').getContext('2d');
    var topClientsData = {
        labels: {!! json_encode($topClients->pluck('holder_name')) !!},
        datasets: [{
            label: 'Points',
            data: {!! json_encode($topClients->pluck('points_sum')) !!},
            backgroundColor: 'rgba(222, 255, 179, 1)', // Background color #DEFFB3
            borderColor: 'rgba(86, 141, 14, 1)', // Border color #568D0E
            borderWidth: 1
        }]
    };
    var topClientsChart = new Chart(ctxTopClients, {
        type: 'bar',
        data: topClientsData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { display: false },
                    ticks: {
                        stepSize: 1
                    }
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

    // Program Cards Chart
var ctxProgramCards = document.getElementById('programFidelityCardsChart').getContext('2d');
var programCardsData = {
    labels: {!! json_encode($programsData->pluck('name')) !!},
    datasets: [{
        label: 'Number of Cards',
        data: {!! json_encode($programsData->pluck('carte_fidelites_count')) !!},
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)', // Red
            'rgba(54, 162, 235, 0.2)', // Blue
            'rgba(255, 206, 86, 0.2)', // Yellow
            'rgba(75, 192, 192, 0.2)', // Green
            'rgba(153, 102, 255, 0.2)', // Purple
            'rgba(255, 159, 64, 0.2)' // Orange
            // Add more colors as needed
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)', // Red
            'rgba(54, 162, 235, 1)', // Blue
            'rgba(255, 206, 86, 1)', // Yellow
            'rgba(75, 192, 192, 1)', // Green
            'rgba(153, 102, 255, 1)', // Purple
            'rgba(255, 159, 64, 1)' // Orange
            // Add more colors as needed
        ],
        borderWidth: 1
    }]
};
var programCardsChart = new Chart(ctxProgramCards, {
    type: 'doughnut',
    data: programCardsData,
    options: {
        plugins: {
            legend: {
                display: true,
                position: 'bottom'
            },
            title: {
                display: false
            }
        }
    }
});

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
