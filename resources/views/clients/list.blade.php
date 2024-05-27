@extends('layouts.caissier')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->

    <a href="{{ route('gerantClients.create') }}" class="btn btn-primary mb-3" style="background-color: #00337C; border-color: #00337C;">Add Clients</a>

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
                            <form action="{{ route('clients.destroy', $client->id) }}" method="post" style="display: inline;" id="deleteForm-{{ $client->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" style="background-color: #F05713; border-color: #F05713;" onclick="confirmDelete(event, {{ $client->id }})">Delete</button>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <!-- SweetAlert Script -->
      <script>
        function confirmDelete(event, clientId) {
            event.stopPropagation(); // Stop the click event from propagating to the row
            Swal.fire({
                title: 'Are you sure to delete the client?',
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
                        'The client has been deleted.',
                        'success'
                    )
                    document.getElementById(`deleteForm-${clientId}`).submit();
                }
            })
        }
    </script>

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
