@extends('layouts.gerant')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('gerantCF.index') }}" class="mb-4">
        <div class="form-row align-items-center">
            <div class="form-group col-md-4 mb-2">
                <input type="text" name="search" class="form-control" placeholder="Search by Commercial ID or holder name" value="{{ request()->query('search') }}">
            </div>
            <div class="form-group col-md-2 mb-2">
                <select name="program" class="form-control">
                    <option value="">All Programs</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}" {{ request()->query('program') == $program->id ? 'selected' : '' }}>
                            {{ $program->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2 mb-2">
                <select name="tier" class="form-control">
                    <option value="">All Tiers</option>
                    <option value="classic" {{ request()->query('tier') == 'classic' ? 'selected' : '' }}>Classic</option>
                    <option value="premium" {{ request()->query('tier') == 'premium' ? 'selected' : '' }}>Premium</option>
                </select>
            </div>
            <div class="form-group col-md-2 mb-2">
                <button type="submit" class="btn btn-outline-primary w-100">Apply Filter(s)</button>
            </div>
            <!-- Clear Button -->
            <div class="form-group col-md-2 mb-2">
                <a href="{{ route('gerantCF.index') }}" class="btn btn-outline-secondary w-100">Clear Filter(s)</a>
            </div>
        </div>
    </form>
    

    <!-- Main Content goes here -->

    <a href="{{ route('gerantCF.create') }}" class="btn btn-primary mb-3" style="background-color: #00337C; border-color: #00337C;">Add Card</a>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>Commercial ID</th>
                <th>Holder Name</th>
                <th>Fidelity Program</th>
                <th>Tier</th>
                <th>Total Points</th>
                <th>Converted Points</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cartes as $carte)
            <tr onclick="window.location='{{ route('gerantCF.edit', $carte->id) }}';" style="cursor:pointer;">
                    <td>{{ $carte->commercial_ID }}</td>
                    <td>{{ $carte->client->name}}</td>
                    <td>
                        @if ($carte->program->status === 'inactive')
                            {{ $carte->program->name }} (Program Inactive)
                        @else
                            {{ $carte->program->name }}
                        @endif
                    </td>
                    <td>{{ $carte->tier }}</td>
                    <td>{{ $carte->points_sum }}</td>
                    <td>
                        @if ($carte->money > 0)
                            {{ $carte->money}}
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('gerantCF.destroy', $carte) }}" method="post" style="display: inline;" id="deleteForm-{{ $carte->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(event, {{ $carte->id }})" style="background-color: #F05713; border-color: #F05713;">Delete</button>
                        </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No card found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $cartes->links() }}

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

    <!-- SweetAlert Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event, carteId) {
            event.stopPropagation(); // Stop the click event from propagating to the row
            Swal.fire({
                title: 'Are you sure to delete this card?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00337C',
                cancelButtonColor: '#F05713',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'The card has been deleted.',
                        'success'
                    )
                    document.getElementById(`deleteForm-${carteId}`).submit();
                }
            })
        }
    </script>
@endpush
