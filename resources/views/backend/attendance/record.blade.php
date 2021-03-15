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
            @if(session()->has('failure'))
                <div class="alert alert-danger" style="position: none; margin-top: 4rem;">
                    {{ session()->get('failure') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @php
                $attendance = DB::table('attendances')->where('date', date('F j, Y'))->get();
            @endphp
            @if (count($attendance) == 0)
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
                                        <th>Entry Time</th>
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
                                                    <input type="hidden" name="staffname[]" value="{{$staff->id}}">
                                                </td>
                                                <td>
                                                    <input type="radio" class="form-control" value="1" style="font-size: 5px;" name="{{$staff->id}}">
                                                </td>
                                                <td>
                                                    <input type="radio" class="form-control" value="2" style="font-size: 5px;" name="{{$staff->id}}">
                                                </td>
                                                <td>
                                                    <input type="radio" class="form-control" value="3" style="font-size: 5px;" name="{{$staff->id}}">
                                                </td>
                                                <td>
                                                    <input type="time" class="form-control" name="time{{$staff->id}}">
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
            @elseif(count($attendance) > 0)
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Record Today's Attendance ({{date('F j, Y')}})</h3>
                        <p>(Attendance for today is done)</p>
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
                                        <th>Entry Time</th>
                                        <th>Exit Time</th>
                                    </tr>
                                </thead>
                                <form action="{{route('admin.updateexit')}}" method="POST">
                                    @csrf
                                    @method('POST')

                                    @foreach ($attendance as $staffattendance)
                                        <tbody>
                                            <tr>
                                                <td>
                                                    @php
                                                        $staff = DB::table('staff')->latest()->where('id', $staffattendance->staff_id)->first();
                                                    @endphp
                                                    {{$staff->name}}
                                                    <input type="hidden" name="attendances[]" value="{{$staffattendance->id}}">
                                                </td>
                                                <td>
                                                    <input type="radio" class="form-control" value="1"{{$staffattendance->present == 1?'checked':''}} style="font-size: 5px;" name="{{$staff->id}}" disabled>
                                                </td>
                                                <td>
                                                    <input type="radio" class="form-control" value="2"{{$staffattendance->paid_leave == 1?'checked':''}} style="font-size: 5px;" name="{{$staff->id}}" disabled>
                                                </td>
                                                <td>
                                                    <input type="radio" class="form-control" value="3"{{$staffattendance->unpaid_leave == 1?'checked':''}} style="font-size: 5px;" name="{{$staff->id}}" disabled>
                                                </td>
                                                <td>
                                                        @if($staffattendance->entry_time == null)
                                                            -
                                                        @else
                                                            {{date('h:i a', strtotime($staffattendance->entry_time))}}
                                                        @endif

                                                </td>
                                                <td>
                                                    @if($staffattendance->exit_time == null && $staffattendance->present == 1)
                                                        <input type="time" class="form-control" name="exit_time{{$staffattendance->id}}">
                                                    @elseif($staffattendance->paid_leave == 1 || $staffattendance->unpaid_leave == 1 || $staffattendance->exit_time == null)
                                                        -
                                                        <input type="hidden" class="form-control" name="exit_time{{$staffattendance->id}}" value="">
                                                    @elseif($staffattendance->exit_time != null)
                                                        {{date('h:i a', strtotime($staffattendance->exit_time))}}
                                                        <input type="hidden" class="form-control" name="exit_time{{$staffattendance->id}}" value="{{$staffattendance->exit_time}}">
                                                    @endif
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


                @elseif($exit == 0)
                    {{dd($exit)}}
            @endif

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
                                <th class="text-center">Entry Time</th>
                                <th class="text-center">Exit Time</th>
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
              {data: 'entry_time', name: 'entry_time'},
              {data: 'exit_time', name: 'exit_time'},
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
