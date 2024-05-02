@extends('layouts.gerant')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Inactive Programs') }}</h1>

    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Expiration Date</th>
                <th>Tier</th>
                <th>Reward</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($inactivePrograms as $program)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $program->name }}</td>
                    <td>{{ $program->expiration_date }}</td>
                    <td>{{ $program->tier }}</td>
                    <td>{{ $program->reward }}</td>
                    <td>{{ $program->status }}</td>
                    <td>
                        <!-- Add form to submit for activating the program -->
                        <form action="{{ route('gerantPrograms.activate', $program->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Activate</button>
                        </form>
                    </td>
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