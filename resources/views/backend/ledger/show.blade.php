@extends('backend.layouts.app')

{{-- @push('styles')
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
@endpush --}}

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
{{-- <h1><a href="{{route('admin.ledger.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Back</a></h1> --}}

    <div class="card">
        <div class="card-body">
            <form action="{{route('admin.ledgerreport')}}" method="GET">
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
        </div>
    </div>
</div>
@endsection
@push('scripts')

{{-- <script>
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
</script> --}}
@endpush

