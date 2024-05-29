@extends('layouts.gerant')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Inactive Programs') }}</h1>

    <form method="GET" action="{{ route('gerantPrograms.inactive') }}" class="mb-4">
        <div class="row">
            <div class="form-group col-md-10 mb-2">
                <input type="text" name="search" class="form-control" placeholder="Search by Program name" value="{{ request()->query('search') }}">
            </div>
            <div class="form-group col-md-2 mb-2">
                <button type="submit" class="btn btn-outline-primary w-100">Search</button>
            </div>
        </div>
    </form>

    <div class="mb-3">
        <a href="{{ route('gerantPrograms.index') }}" class="btn btn-primary"><span class="sort-indicator">←</span> Go back to Active Programs</a>
    </div>

    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Starting date</th>
                <th>Ending date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($inactivePrograms as $program)
                <tr onclick="window.location='{{ route('gerantPrograms.edit', $program->id) }}';" style="cursor:pointer;">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $program->name }}</td>
                    <td>{{ $program->start_date }}</td>
                    <td>{{ $program->expiry_date }}</td>
                    <td>
                        <div class="d-flex">
                            <form action="{{ route('gerantPrograms.activate', $program->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-warning mr-2">
                                        Activate
                                </button>
                            </form>
                            <form action="{{ route('gerantPrograms.destroy', $program->id) }}" method="post" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this program?')">Delete</button>
                            </form>
                            
                            
                        </div>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No inactive programs found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $inactivePrograms->links() }}
@endsection