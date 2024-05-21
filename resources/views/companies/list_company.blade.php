@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <div>
            <h1 class="h3 mb-4 text-gray-800">{{ $title ?? __('Blank Page') }}</h1>
        </div>
        <div>
            <form class="form-inline">
                <div class="input-group">
                 <input type="text" id="companySearch" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                    <button class="btn btn-primary" type="button" style="background-color: #00337C; border-color: #00337C;">
                    <i class="fas fa-search fa-sm"></i>
                    </button>

                    </div>
                    <!-- JavaScript code goes here -->
         <!-- JavaScript code -->
         <script src="https://code.jquery.com/jquery-latest.min.js"></script>
         <script src="public/js/external.js"></script>

         <script>
$(document).ready(function() {
    $('#companySearch').on('keyup', function () {
        var query = $(this).val().trim();
        if (query!== '') {
            $.ajax({
                url: '{{ route("search_companies") }}',
                type: 'GET',
                data: {
                    'query': query
                },
                success: function (data) {
                    updateCompaniesTable(data);
                }
            });
        } else {
            updateCompaniesTable([]); // Clear the table if the search query is empty
        }
    });

    // Define the updateCompaniesTable function in JavaScript
    function updateCompaniesTable(companies) {
        var tbody = $('.table tbody'); // Get the table body
        tbody.empty(); // Clear the existing rows

        // Loop through the companies and create table rows
        companies.forEach(function(company) {
            var row = `
                <tr>
                    <td>${company.id}</td>
                    <td>${company.name}</td>
                    <td>`;
            // Iterate over managers and append each to the row
            company.managers.forEach(function(manager) {
                row += `<div><strong>${manager}</strong></div>`;
            });
            row += `</td>
                    <td>`;
            // Iterate over actions and append each to the row
            company.actions.forEach(function(action) {
                row += `<button class="btn btn-${action}" data-action="${action}" style="${action === 'edit' ? 'background-color: #00337C; border-color: #00337C; color: white;' : 'background-color: #F05713; border-color: #F05713; color: white;'}">${action}</button>`;
            });
            row += `</td>
                </tr>
            `;
            tbody.append(row);
        });

        // Re-attach event listeners to the newly created buttons
        $('.btn-edit,.btn-delete').off('click').on('click', function() {
            var action = $(this).data('action');
            if (action === 'edit') {
                // Handle edit action
                console.log('Edit button clicked');
                // Redirect to the edit page
                var companyId = $(this).closest('tr').find('td:first').text(); // Get the company ID
                window.location.href = `/companies/${companyId}/edit_company`; // Corrected URL
            } else if (action === 'delete') {
                // Handle delete action
                console.log('Delete button clicked');
                var companyId = $(this).closest('tr').find('td:first').text(); // Get the company ID

                // Submit the form to delete the company
                $(this).closest('form').submit();
            }
        });
    }
});

</script>


                </div>
            </form>
        


        </div>
    </div>
    <!-- Main Content goes here -->
    
    <a href="{{ route('companies.create') }}" class="btn btn-primary mb-3 "  style="background-color: #00337C; border-color: #00337C;">New company</a>

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
                <th>Managers</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $company->name }}</td>
                    <td>
                        @forelse ($company->gerants as $index => $gerant)
                            <div><strong>M{{ $index + 1 }}</strong>: {{ $gerant->name }}</div>
                        @empty
                            <div>No managers</div>
                        @endforelse
                    </td>
                    <td>
                       
                            <a href="{{ route('companies.edit_company', ['company' => $company->id]) }}" class="btn btn-primary" style="background-color: #00337C; border-color: #00337C;">Edit</a>
                       
                        
                            <form action="{{ route('companies.destroy', ['company' => $company->id]) }}" method="POST" style="display: inline;" id="deleteForm">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" id="deleteButton" style="background-color: #F05713; border-color: #F05713;" onclick="confirmDelete(event)">Delete</button>
                            </form>
                        
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

     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <!-- SweetAlert Script -->
      <script>
       
       function confirmDelete(e) {
        e.preventDefault()            
            Swal.fire({
                title: 'Are you sure to delete the company?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00337C',
                cancelButtonColor: '#F05713',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'The Company has been deleted.',
                        'success'
                    )
                    document.getElementById('deleteForm').submit();
                }
            })
        };
    </script>
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
