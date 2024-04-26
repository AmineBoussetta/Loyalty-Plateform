@extends('layouts.gerant')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->

    <a href="{{ route('clients.create') }}" class="btn btn-primary mb-3">Add programs</a>

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
                <th>Expiration Date</th>
                <th>Tier</th>
                <th>Reward</th>
                <th>Status</th>

            </tr>
        </thead>
        <tbody>
            @forelse ($programs as $program)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $program->name }}</td>
                    <td>{{ $program->expiration_date }}</td>
                    <td>{{ $program->tier }}</td>
                    <td>{{ $program->reward }}</td>
                    <td>{{ $program->status }}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('gerantProgram.edit', $program->id) }}" class="btn btn-sm btn-primary mr-2">Edit</a>
                            <form action="{{ route('gerantProgram.destroy', $program->id) }}" method="post" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this program?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No programs found.</td>
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