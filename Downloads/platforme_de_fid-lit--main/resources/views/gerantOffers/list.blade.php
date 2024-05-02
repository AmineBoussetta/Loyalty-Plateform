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

    <a href="{{ route('gerantOffers.index') }}" class="btn btn-primary mb-3">Add Offers</a>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>No</th>
                <th>x</th>
                <th>x</th>
                <th>x</th>
                <th>x</th>

            </tr>
        </thead>
        <tbody>
            {{-- @forelse ($offers as $offer)
                <tr>
                    <td>{{  }}</td>
                    <td>{{  }}</td>
                    <td>{{  }}</td>
                    <td>{{  }}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('gerantOffers.index', $gerantOffers->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a><!-- change gerantClients.index to .edit-->
                            <form action="{{ route('gerantOffers.index', $gerantOffers->id) }}" method="post" style="display: inline;"><!-- change gerantClients.index to .destroy -->
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
            @endforelse --}}
        </tbody>
    </table>

    {{ $offers->links() }}

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