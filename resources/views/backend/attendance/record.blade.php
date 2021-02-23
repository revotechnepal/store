@extends('backend.layouts.app')
@push('styles')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="right_col" role="main">
            @if(session()->has('success'))
                <div class="alert alert-success" style="position: none; margin-top: 4rem;">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        <div class="card">
            <div class="card-header text-center">
                <h3>Record Today's Attendance ({{date('F j, Y')}})</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Staff Name</th>
                                <th>Present</th>
                                <th>Paid Leave</th>
                                <th>Unpaid Leave</th>
                            </tr>
                        </thead>
                        <form action="{{route('admin.attendance.store')}}" method="POST">
                            @csrf
                            @method('POST')

                            @foreach ($staffs as $staff)
                                <tbody>
                                    <tr>
                                        <td>
                                            {{$staff->name}}
                                            <input type="hidden" name="staffname[]" class="form-contdol text-center" value="{{$staff->id}}">
                                        </td>
                                        <td>
                                            <input type="hidden" class="form-control" value="0" name="present[]">
                                            <input type="checkbox" class="form-control" value="{{$staff->id}}" style="font-size: 5px;" name="present[]">
                                        </td>
                                        <td>
                                            <input type="hidden" class="form-control" value="0" name="paid_leave[]">
                                            <input type="checkbox" class="form-control" value="{{$staff->id}}" style="font-size: 5px;" name="paid_leave[]">
                                        </td>
                                        <td>
                                            <input type="hidden" class="form-control" value="0" name="unpaid_leave[]">
                                            <input type="checkbox" class="form-control" value="{{$staff->id}}" style="font-size: 5px;" name="unpaid_leave[]">
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                    </table>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                </div>
            </div>
        </div>

            <div class="card mt-3">
                <div class="card-header text-center">
                    <h3>Today's Attendance ({{date('F j, Y')}})</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered yajra-datatable text-center">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Staff Name</th>
                                <th class="text-center">Attendance Status</th>
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
          ajax: "{{ route('admin.attendance.create') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'staffname', name: 'staffname'},
              {data: 'status', name: 'status'},
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
