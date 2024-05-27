@extends('layouts.gerant')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->

    <a href="{{ route('gerantPrograms.create') }}" class="btn btn-primary mb-3" style="background-color: #00337C; border-color: #00337C;">Add program</a>
    <a href="{{ route('gerantPrograms.inactive') }}" class="btn btn-warning mb-3"  style="background-color: #5CE1E6; border-color: #5CE1E6;">View Inactive Programs</a>


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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($programs as $program)
                <tr onclick="window.location='{{ route('gerantPrograms.edit', $program->id) }}';" style="cursor:pointer;">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $program->name }}</td>
                    <td>
                        <div class="d-flex">
                            <form action="{{ route('gerantPrograms.toggleStatus', $program->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-warning mr-2" style="background-color: #03C988; border-color: #03C988;">
                                    @if ($program->status === 'active')
                                        Deactivate
                                    @else
                                        Activate
                                    @endif
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No programs found.</td>
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
