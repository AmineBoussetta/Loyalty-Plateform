@extends('layouts.gerant')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>
    
    <form method="GET" action="{{ route('gerantCaissiers.index', $gerant) }}" class="mb-4">
        <div class="row">
            <div class="form-group col-md-10 mb-2">
                <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone number" value="{{ request()->query('search') }}">
            </div>
            <div class="form-group col-md-2 mb-2">
                <button type="submit" class="btn btn-outline-primary w-100">Search</button>
            </div>
        </div>
    </form>

    <a href="{{ route('gerantCaissiers.create', ['gerant' => $gerant]) }}" class="btn btn-primary mb-3">Add Cashier</a>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>Cashier_ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone number</th>
                <th>Company Name</th>
                <th>Action</th>
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
        <td>
            <div class="d-flex">
                <a href="{{ route('gerantCaissiers.edit', ['gerant' => $gerant, 'caissierID' => $gerantCaissier->Caissier_ID]) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
               <form id="deleteForm-{{ $gerantCaissier->Caissier_ID }}" action="{{ route('gerantCaissiers.destroy', ['gerant' => $gerant, 'caissierID' => $gerantCaissier->Caissier_ID]) }}" method="post" style="display: inline;">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger" style="background-color: #F05713; border-color: #F05713;" onclick="confirmDelete(event, '{{ $gerantCaissier->Caissier_ID }}')">Delete</button>
</form>

            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center">No cashier found.</td>
    </tr>
@endforelse

        </tbody>
    </table>

    {{ $gerantCaissiers->links() }}

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
<script>
    function confirmDelete(event, caissierID) {
        event.preventDefault();
        event.stopPropagation();
        Swal.fire({        title: 'Are you sure to delete this cashier?',    
                text: "You won't be able to revert this!",     
                icon: 'warning',       
                showCancelButton: true,  
                confirmButtonColor: '#00337C',
                cancelButtonColor: '#F05713',     
                confirmButtonText: 'Yes, delete it!'}).then((result) => {        
                    if (result.isConfirmed) 
                    {   Swal.fire('Deleted!','The cashier has been deleted.', 'success');    
                       document.getElementById(`deleteForm-${caissierID}`).submit();  }  
                      });}
    
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
