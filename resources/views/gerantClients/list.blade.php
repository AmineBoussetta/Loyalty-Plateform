@extends('layouts.gerant')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->

    <a href="{{ route('gerantClients.create') }}" class="btn btn-primary mb-3">Add Clients</a>

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
                <th>Card ID</th>

            </tr>
        </thead>
        <tbody>
            @forelse ($gerantClients as $gerantClient)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $gerantClient->name }}</td>
                    <td>{{ $gerantClient->email }}</td>
                    <td>{{ $gerantClient->phone }}</td>
                    <td>{{ optional($gerantClient->card)->commercial_ID }}</td> <!-- Display the associated card ID -->
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('gerantClients.index', $gerantClient->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a><!-- change gerantClients.index to .edit-->
                            <form action="{{ route('gerantClients.index', $gerantClient->id) }}" method="post" style="display: inline;"><!-- change gerantClients.index to .destroy -->
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this client?')">Delete</button>
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