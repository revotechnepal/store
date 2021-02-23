@extends('backend.layouts.app')
@push('styles')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('content')
<div class="right_col" role="main">
<!-- MAIN -->
{{-- @if (session('success'))
                <div class="col-sm-12">
                    <div class="alert  alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                </div>
            @endif --}}

            @if(session()->has('success'))
                <div class="alert alert-success" style="position: none; margin-top: 4rem;">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <h1 class="mt-3">Purchase Records <a href="{{route('admin.purchaserecord.create')}}" class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i> Entry New Record</a></h1>
            <div class="card mt-3">
                <div class="card-body table-responsive">
                    <table class="table table-bordered yajra-datatable text-center">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Purchased From</th>
                                <th class="text-center">Purchased Date</th>
                                <th class="text-center">Bill number</th>
                                <th class="text-center">Bill Amount</th>
                                <th class="text-center">Paid Amount</th>
                                <th class="text-center">Purpose</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(function () {

      var table = $('.yajra-datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('admin.purchaserecord.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'thirdparty_name', name: 'thirdparty_name'},
              {data: 'date', name: 'date'},
              {data: 'bill_number', name: 'bill_number'},
              {data: 'bill_amount', name: 'bill_amount'},
              {data: 'paid_amount', name: 'paid_amount'},
              {data: 'purpose', name: 'purpose'},
              {
                  data: 'action',
                  name: 'action',
                  orderable: true,
                  searchable: true
              },
          ]
      });

    });
  </script>
@endpush
