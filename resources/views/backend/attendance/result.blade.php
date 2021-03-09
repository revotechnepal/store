@extends('backend.layouts.app')
@push('styles')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        * {
          box-sizing: border-box;
        }

        #myInput {
          background-image: url('/uploads/search.png');
          background-position: 10px 10px;
          background-repeat: no-repeat;
          width: 100%;
          font-size: 13px;
          padding: 12px 20px 12px 40px;
          border: 1px solid grey;
          margin-bottom: 12px;
        }
        </style>
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

        <h2 class="text-center">Total working days for this month ({{date('F')}}) = 30</h2>

        <div class="card">
            <div class="card-header text-center">
                <h3>Monthly Attendance Report</h3>
            </div>
            <div class="card-body">

                <form action="{{route('admin.reportgenerator')}}" method="GET">
                    @csrf
                    @method('GET')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="month">Select a year and month to filter:</label>
                                @php
                                    $today = date('Y-m');
                                @endphp
                                <input type="month" name="monthyear" value="{{$today}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 mt-4 text-left">
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </div>
                    </div>
                </form>

                <hr>

                {{-- {{dd(count($requireattendance))}} --}}

                @if (count($requireattendance) == 0)
                    <div class="col-md-12 mt-5 text-center">
                        <p style="font-size: 20px;">Sorry, We could't find the data.</p>
                    </div>
                @else

                <h3 class="text-center mt-5">Monthly Attendance Report for the month {{$datetoselect}}</h3>
                <h2 class="text-center mt-3">Total working days = 30</h2>

                <div class="row mt-3">
                    <div class="div col-6"></div>
                    <div class="div col-6">
                        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for staff names.." title="Type in a name">
                    </div>
                </div>

                    <div class="table-responsive text-center mt-4">
                        <table class="table" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Staff Name</th>
                                    <th>Present (Days)</th>
                                    <th>Paid Leave (Days)</th>
                                    <th>Unpaid Leave (Days)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffs as $staff)
                                    @php
                                        $presentdays = 0;
                                        $paid_leave = 0;
                                        $unpaid_leave = 0;
                                        $monthlyinfo = DB::table('attendances')->where('staff_id', $staff->id)->where('monthyear', $datetoselect)->get();
                                        foreach ($monthlyinfo as $info) {
                                            $presentdays = $presentdays + $info->present;
                                            $paid_leave = $paid_leave + $info->paid_leave;
                                            $unpaid_leave = $unpaid_leave + $info->unpaid_leave;
                                        }
                                    @endphp

                                    <tr>
                                        <td>{{$staff->name}}</td>
                                        <td>{{$presentdays}}</td>
                                        <td>{{$paid_leave}}</td>
                                        <td>{{$unpaid_leave}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                {{-- @else
                    <div class="col-md-12 mt-5 text-center">
                        <h3>Report of {{$staffinfo->staff->name}} for {{$staffinfo->monthyear}}</h3>

                        <p style="font-size:20px;">Total working Days : {{count($staffreport)}}<br>
                        @php
                            $present = 0;
                            $paid_leave = 0;
                            $unpaid_leave = 0;
                            foreach ($staffreport as $report){
                                $present = $present + $report->present;
                                $paid_leave = $paid_leave + $report->paid_leave;
                                $unpaid_leave = $unpaid_leave + $report->unpaid_leave;
                            }
                        @endphp

                        Present (Days) : {{$present}}<br>
                        Paid Leave (Days) : {{$paid_leave}}<br>
                        Unpaid Leave (Days) : {{$unpaid_leave}}</p>

                    </div>
                @endif --}}
            </div>
        </div>
    </div>
@endsection
@push('scripts')

<script>
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>
@endpush
