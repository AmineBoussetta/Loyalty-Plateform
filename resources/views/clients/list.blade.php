@extends('layouts.caissier')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('clients.index') }}" class="mb-4">
        <div class="row">
            <div class="form-group col-md-10 mb-2">
                <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone number" value="{{ request()->query('search') }}">
            </div>
            <div class="form-group col-md-2 mb-2">
                <button type="submit" class="btn btn-outline-primary w-100">Search</button>
            </div>
        </div>
    </form>

    <!-- Main Content goes here -->

    <a href="{{ route('clients.create') }}" class="btn btn-primary mb-3"  style="background-color: #00337C; border-color: #00337C;">Add Clients</a>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>No</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone number</th>
                <th>Money Spent</th>
                <th>Commercial ID</th>
                <th>Fidelity Card Points</th>
                <th>Fidelity Card Money</th>

            </tr>
        </thead>
        <tbody>
            @forelse ($clients as $client)
            <tr onclick="window.location='{{ route('clients.edit', $client->id) }}';" style="cursor:pointer;">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->money_spent }}</td>
                    <td>
                        @if ($client->carteFidelite)
                            {{ $client->carteFidelite->commercial_ID }}
                        @else
                        <a href="{{ route('carte_fidelite.create') }}" class="btn btn-primary">Create Card</a>
                        @endif
                    </td>
                    <td>
                        @if ($client->carteFidelite)
                            {{ optional($client->carteFidelite)->points_sum }}
                        @else
                            No Card
                        @endif
                    </td>
                        
                    <td>
                        @if ($client->carteFidelite)
                            {{ optional($client->carteFidelite)->money }}                            
                        @else
                            No Card
                        @endif
                    </td>

                    <td>
                        <div class="d-flex">
                            <form action="{{ route('clients.destroy', $client->id) }}" method="post" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this client?')" style="background-color: #F05713; border-color: #F05713;">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No clients found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $clients->links() }}

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