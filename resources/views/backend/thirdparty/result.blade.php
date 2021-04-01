@extends('backend.layouts.app')

@push('styles')
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
<h1>{{$thirdParty->name}} <a href="{{route('admin.thirdparty.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Our Suppliers</a></h1>

<div class="card">
    <div class="card-body">
        <form action="{{route('admin.generatereport')}}" method="GET">
            @csrf
            @method('GET')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="month">Select a year and month to filter:</label>
                        @php
                            $today = date('Y-m');
                        @endphp
                        <input type="hidden" name="thirdparty" value="{{$thirdParty->id}}">
                        <input type="month" name="monthyear" value="{{$today}}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6 mt-4 text-left">
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </div>
            </div>
        </form>
        <hr>
        @if (count($expenses) == 0)
            <div class="col-md-12 mt-5 text-center">
                <p style="font-size: 20px;">Sorry, We don't have the data.</p>
            </div>
        @else

        <h3 class="text-center mt-5">Expenses and Dues for {{$datetoselect}}</h3>

        <div class="row mt-3">
            <div class="div col-6"></div>
            <div class="div col-6">
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search by date.." title="Type in a date">
            </div>
        </div>

            <div class="table-responsive text-center mt-4">
                <table class="table table-bordered" id="myTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Transaction Date</th>
                            <th>Purpose</th>
                            <th>Bill Amount</th>
                            <th>Paid Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr>
                                <td>{{date('F j, Y', strtotime($expense->purchase_date))}}</td>
                                <td>{{$expense->purpose}}</td>
                                <td>
                                    Rs. {{$expense->bill_amount}}
                                </td>
                                <td>Rs. {{$expense->paid_amount}}</td>
                            </tr>
                        @endforeach

                        @php
                            $totalbillamount = 0;
                            $totalpaidamount = 0;
                            foreach($expenses as $expense){
                                $totalbillamount = $totalbillamount + $expense->bill_amount;
                                $totalpaidamount = $totalpaidamount + $expense->paid_amount;
                            }
                        @endphp

                        <tr>
                            <td colspan="3" style="font-weight: bold">Total Bill Amount</td>
                            <td>Rs. {{$totalbillamount}}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="font-weight: bold">Total Paid Amount</td>
                            <td>Rs. {{$totalpaidamount}}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        @endif
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

