@extends('layouts.caissier')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->

    <div class="card">
        <div class="card-body">
            <form action="{{ route('carte_fidelite.store') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="commercial_ID">Identifiant</label>
                    <input type="text" class="form-control @error('commercial_ID') is-invalid @enderror" name="commercial_ID" id="commercial_ID" placeholder="Commercial ID" autocomplete="off" value="{{ old('commercial_ID') }}">
                    @error('commercial_ID')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
  
                  <div class="form-group">
                    <label for="points_sum">Somme de points</label>
                    <input type="text" class="form-control @error('points_sum') is-invalid @enderror" name="points_sum" id="points_sum" placeholder="Points Sum" autocomplete="off" value="{{ old('points_sum') }}">
                    @error('points_sum')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
  
                  <div class="form-group">
                    <label for="tier">Tier</label>
                    <input type="text" class="form-control @error('tier') is-invalid @enderror" name="tier" id="tier" placeholder="Tier" autocomplete="off" value="{{ old('tier') }}">
                    @error('tier')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
  
                  <div class="form-group">
                      <label for="name">Nom du détenteur</label>
                      <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name of Holder" autocomplete="off" value="{{ old('name') }}">
                      @error('name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
  
                  <button type="submit" class="btn btn-primary">Save</button>
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