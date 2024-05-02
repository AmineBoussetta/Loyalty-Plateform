@extends('layouts.caissier')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>

    <!-- Main Content goes here -->

    <div class="card">
        <div class="card-body">
            <form action="{{ route('transactions.store') }}" method="post">
                @csrf

                  
                  

                  <div class="form-group">
                    <label for="client_id">Transaction ID</label>
                    <input type="text" class="form-control @error('client_id') is-invalid @enderror" name="client_id" id="client_id" placeholder="Transaction Id" autocomplete="off" value="{{ old('client_id') }}">
                    @error('client_id')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="client_id">Client ID</label>
                    <input type="text" class="form-control @error('client_id') is-invalid @enderror" name="client_id" id="client_id" placeholder="Client Id" autocomplete="off" value="{{ old('client_id') }}">
                    @error('client_id')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
  
                  <div class="form-group">
                    <label for="type">Type of Transaction</label>
                    <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                      <option disabled selected>Select a type</option>
                        <option value="Achat" {{ old('type') == 'Achat' ? 'selected' : '' }}>Achat</option>
                        <option value="Remboursement" {{ old('type') == 'Remboursement' ? 'selected' : '' }}>Remboursement</option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" placeholder="Amount" autocomplete="off" value="{{ old('amount') }}">
                    @error('amount')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="transaction_date">Transaction Date</label>
                    <input type="date" class="form-control datepicker @error('transaction_date') is-invalid @enderror" name="transaction_date" id="transaction_date" placeholder="Select Transaction Date" autocomplete="off" value="{{ old('transaction_date') }}">
                    @error('transaction_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                  </div>
  
                  
                 
                          

                  <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Description" autocomplete="off" value="{{ old('description') }}">
                    @error('description')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="payment_method">Payment Method</label>
                    <select class="form-control @error('payment_method') is-invalid @enderror" name="payment_method" id="payment_method">
                      <option disabled selected>Select Payment Method</option>
                        <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Par Chèque" {{ old('payment_method') == 'Par Chèque' ? 'selected' : '' }}>Par chèque</option>
                        <option value="Card" {{ old('payment_method') == 'Card' ? 'selected' : '' }}>Card</option>
                    </select>
                    @error('payment_method')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="status">Status</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="status" name="status" {{ old('status') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status"></label>
                    </div>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    </div>
  
                  <button type="submit" class="btn btn-primary">Save</button>
                  <a href="{{ route('transactions.index') }}" class="btn btn-default">Back to list</a>
  
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


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
