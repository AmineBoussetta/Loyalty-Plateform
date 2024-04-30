@extends('layouts.caissier')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->

    <div class="card">
        <div class="card-body">
            <form action="{{ route('gerantPrograms.store') }}" method="post">
                @csrf

                <div class="form-group">
                  <label for="name">Program Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Program name" autocomplete="off" value="{{ old('name') }}">
                  @error('name')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="expiration_date">Expiration date</label>
                  <input type="date" class="form-control @error('expiration_date') is-invalid @enderror" name="expiration_date" id="expiration_date" placeholder="Expiration date" autocomplete="off" value="{{ old('expiration_date') }}">
                  @error('expiration_date')
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
                    <label for="reward">Reward</label>
                    <input type="text" class="form-control @error('reward') is-invalid @enderror" name="reward" id="reward" placeholder="Reward" autocomplete="off" value="{{ old('reward') }}">
                    @error('reward')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" class="form-control @error('status') is-invalid @enderror" name="status" id="status" placeholder="Active" autocomplete="off" value="{{ old('status') }}" readonly>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('gerantPrograms.index') }}" class="btn btn-default">Back to list</a>

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