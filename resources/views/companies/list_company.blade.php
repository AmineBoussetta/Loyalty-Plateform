@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->
    
    <a href="{{ route('companies.create') }}" class="btn btn-primary mb-3" style="background-color: #00337C; border-color: #00337C;">New company</a>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>No</th>
                <th>Company name</th>
                <th>Manager</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($companies as $company)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $company->name }}</td>
        <td>{{ $company->managers }}</td>
        <td>
    @if (!is_null($company->id))
        <a href="{{ route('companies.edit_company', ['company' => $company->id]) }}" class="btn btn-primary" style="background-color: #00337C; border-color: #00337C;">Edit</a>
    @endif
    @if (!is_null($company->id))
        <form action="{{ route('companies.destroy', $company) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" style="background-color: #F05713; border-color: #F05713;">Delete</button>
        </form>
    @endif
</td>

    </tr>
@endforeach
    </tbody>
    </table>

    {{ $companies->links() }}

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
