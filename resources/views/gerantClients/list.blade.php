@extends('layouts.gerant')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('gerantClients.index', $gerant) }}" class="mb-4">
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

    <a href="{{ route('gerantClients.create', $gerant) }}" class="btn btn-primary mb-3" style="background-color: #00337C; border-color: #00337C;">Add Client</a>  
    <div class="mb-4">
        <form action="{{ route('gerantClients.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="file" class="col-form-label">Or you can choose an Excel file to import clients:</label>
            <div class="form-group row">
                
                <div class="col-sm-7">
                    <div class="custom-file">
                        <input type="file" name="file" id="file" class="custom-file-input" required>
                        <label class="custom-file-label" for="file">Choose file</label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-success" style="background-color: #00337C; border-color: #00337C;">Import Clients</button>
                </div>
            </div>
        </form>
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
            @forelse ($gerantClients as $gerantClient)
            <tr onclick="window.location='{{ route('gerantClients.edit', $gerantClient->id) }}';" style="cursor:pointer;">                    
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $gerantClient->name }}</td>
                    <td>{{ $gerantClient->email }}</td>
                    <td>{{ $gerantClient->phone }}</td>
                    <td>{{ $gerantClient->money_spent }} <span style="bold">TND</span></td>
                    <td>
                        @if ($gerantClient->carteFidelite)
                            {{ $gerantClient->carteFidelite->commercial_ID }}
                        @else
                            <a href="{{ route('gerantCF.create') }}" class="btn btn-outline-primary">Create Card</a>
                        @endif
                    </td>
                    <td>
                        @if ($gerantClient->carteFidelite)
                            {{ optional($gerantClient->carteFidelite)->points_sum }}
                        @else
                            No Card
                        @endif
                    </td>
                        
                    <td>
                        @if ($gerantClient->carteFidelite)
                            {{ optional($gerantClient->carteFidelite)->money }}   <span style="color: green;font-weight : bold">TND</span>                         
                        @else
                            No Card
                        @endif
                    </td>
                    <td>
                        <div class="d-flex">
                            <form action="{{ route('gerantClients.destroy', $gerantClient->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this client?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No clients found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $gerantClients->links() }}

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
