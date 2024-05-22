@extends('layouts.gerant')

@section('main-content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
    <div>
        <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>
    </div>
    <div>
        <form class="form-inline">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

    <!-- Main Content goes here -->

    <a href="{{ route('gerantCaissiers.create', ['gerant' => $gerant]) }}" class="btn btn-primary mb-3">Add Caissier</a>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>Caissier_ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone number</th>
                <th>Company Name</th>
                

            </tr>
        </thead>
        <tbody>
            @forelse ($gerantCaissiers as $gerantCaissier)
                
                <tr>
                    
                    <td>{{ $gerantCaissier->Caissier_ID }}</td>
                    <td>{{ $gerantCaissier->name }}</td>
                    <td>{{ $gerantCaissier->email }}</td>
                    <td>{{ $gerantCaissier->phone }}</td>
                    <td>{{ $gerantCaissier->company_name }}</td>
                    <td>{{ optional($gerantCaissier->card)->commercial_ID }}</td> <!-- Display the associated card ID -->
                    <td>
                        
                 <div class="d-flex">
                 <a href="{{ route('gerantCaissiers.edit', ['gerant' => $gerant, 'caissierID' => $gerantCaissier->Caissier_ID]) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
            <form action="{{ route('gerantCaissiers.destroy', ['gerant' => $gerant, 'caissier' => $gerantCaissier->id]) }}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this client?')">Delete</button>
</form>

                        </div>
                    </td>
                </tr>
                
            @empty
                <tr>
                    <td colspan="4" class="text-center">No caissiers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $gerantCaissiers->links() }}

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