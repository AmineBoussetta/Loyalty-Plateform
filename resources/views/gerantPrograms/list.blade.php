@extends('layouts.gerant')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <form method="GET" action="{{ route('gerantPrograms.index') }}" class="mb-4">
        <div class="form-row align-items-center">
            <div class="form-group col-md-5 mb-2">
                <input type="text" name="search" class="form-control" placeholder="Search by Program name" value="{{ request()->query('search') }}">
            </div>
            <div class="form-group col-md-3 mb-2 position-relative">
                <label for="start_date" class="sr-only">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request()->query('start_date') }}">
                <span class="form-placeholder">Start Date</span>
                <hr class="form-line">
            </div>
            <div class="form-group col-md-2 mb-2">
                <button type="submit" class="btn btn-outline-primary w-100">Apply Filter(s)</button>
            </div>
            <!-- Clear Button -->
            <div class="form-group col-md-2 mb-2">
                <a href="{{ route('gerantPrograms.index') }}" class="btn btn-outline-secondary w-100">Clear Filter(s)</a>
            </div>
        </div>
    </form>

    <style>
        .position-relative {
            position: relative;
        }
        .form-placeholder {
            position: absolute;
            top: -15px; /* Adjust this value as needed */
            left: 1px;
            transform: translateY(-50%);
            pointer-events: none;
            opacity: 0.6;
            background-color: white; /* Ensure the line doesn't overlap the text */
            padding: 0 5px; /* Add padding to the placeholder */
        }
        .form-line {
            position: absolute;
            top: 0;
            width: 100%;
            border-top: 1px solid #ccc;
            margin: 0;
        }
    </style>

    <!-- Main Content goes here -->

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('gerantPrograms.create') }}" class="btn btn-primary" style="background-color: #00337C; border-color: #00337C;">Add Program</a>
        <a href="{{ route('gerantPrograms.inactive') }}" class="btn btn-secondary">Switch to Inactive Programs <span class="sort-indicator">→</span></a>
    </div>


    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Starting date</th>
                <th>Ending date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($programs as $program)
                <tr onclick="window.location='{{ route('gerantPrograms.edit', $program->id) }}';" style="cursor:pointer;">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $program->name }}</td>
                    <td>{{ $program->start_date }}</td>
                    <td>{{ $program->expiry_date }}</td>
                    <td>
                        <div class="d-flex">
                            <form action="{{ route('gerantPrograms.toggleStatus', $program->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-secondary" >
                                    @if ($program->status === 'active')
                                        Deactivate
                                    @else
                                        Activate
                                    @endif
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No programs found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $programs->links() }}

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
