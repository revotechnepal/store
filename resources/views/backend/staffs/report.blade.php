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
                <h3>Monthly Salary Report</h3>
            </div>
            <div class="card-body">

                <form action="{{route('admin.salaryreportgenerate')}}" method="GET">
                    @csrf
                    @method('GET')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="month">Select a year and month to filter:</label>
                                <input type="month" name="monthyear" value="2020-05" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 mt-4 text-left">
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </div>
                    </div>
                </form>

                    {{-- {{$staffreport->staff->name}} --}}
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush