@extends('layouts.caissier')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    {{-- {{ dd($carte) }} --}}

    <!-- Main Content goes here -->

    <div class="card">
        <div class="card-body">
            <form action="{{ route('carte_fidelite.update', ['carte' => $carte->id]) }}" method="post">

                @csrf
                @method('put')

                <div class="form-group">
                  <label for="points_sum">Total Points</label>
                  <input type="text" class="form-control @error('points_sum') is-invalid @enderror" name="points_sum" id="points_sum" placeholder="Total Points" autocomplete="off" value="{{ old('points_sum') ?? $carte->points_sum }}">
                  @error('points_sum')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                    <label for="tier">Tier</label>
                    <select class="form-control @error('tier') is-invalid @enderror" name="tier" id="tier">
                      <option disabled selected>Select a tier</option>
                        <option value="gold" {{ old('tier') == 'gold' ? 'selected' : '' }}>Gold</option>
                        <option value="silver" {{ old('tier') == 'silver' ? 'selected' : '' }}>Silver</option>
                        <option value="bronze" {{ old('tier') == 'bronze' ? 'selected' : '' }}>Bronze</option>
                    </select>
                    @error('tier')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="name">Holder Name</label>
                    <select class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                        <option disabled selected>Select a holder</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->name }}" {{ old('name') == $client->name ? 'selected' : '' }}>
                                {{ $client->name }} ({{ $client->phone }})
                            </option>
                        @endforeach
                    </select>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="fidelity_program">Fidelity Program</label>
                    <select class="form-control @error('fidelity_program') is-invalid @enderror" name="fidelity_program" id="fidelity_program">
                      <option disabled selected>Select a program</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->name }}">{{ $program->name }}</option>
                        @endforeach
                    </select>
                    @error('fidelity_program')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>

                <button type="submit" class="btn btn-primary"  style="background-color: #00337C; border-color: #00337C;">Save</button>
                <a href="{{ route('carte_fidelite.index') }}" class="btn btn-default">Back to list</a>

            </form>
        </div>
    </div>

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