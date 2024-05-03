@extends('layouts.gerant')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->

    <a href="{{ route('gerantCF.create') }}" class="btn btn-primary mb-3">Ajouter une carte</a>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>Identifiant Commercial</th>
                <th>Somme de points</th>
                <th>Tier</th>
                <th>Nom du deteneur</th>
                <th>Programme de fidelite</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cartes as $carte)
                <tr>
                    <td>{{ $carte->commercial_ID }}</td>
                    <td>{{ $carte->points_sum }}</td>
                    <td>{{ $carte->tier }}</td>
                    <td>{{ $carte->client->name ?? 'No holder' }}</td> {{-- still needs fixing --}}
     
                    
                    <td>{{ $carte->fidelity_program }}</td>
                    <td>
                        <a href="{{ route('gerantCF.edit', $carte->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
                        <form action="{{ route('gerantCF.destroy', $carte->id) }}" method="post" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this client?')">Delete</button>
                        </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No card found.</td>
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
@endpush