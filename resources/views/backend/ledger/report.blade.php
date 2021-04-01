@extends('backend.layouts.app')

@section('content')
<div class="right_col" role="main">
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
    <hr>
    <div class="row mt-3">
        <div class="col-md-12">
            @if (count($ledger) == 0)
                <div class="col-md-12 mt-5 text-center">
                    <p style="font-size: 20px;">Sorry, We don't have the data for {{date('F, Y', strtotime($givendate))}}.</p>
                </div>
            @else
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Ledger for the month of {{date('F, Y', strtotime($givendate))}}</h2>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive text-center">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <th>Date</th>
                                    <th>Particulars</th>
                                    <th>Debit Amount (Rs.)</th>
                                    <th>Credit Amount (Rs.)</th>
                                    <th>Balance (Rs.)</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{date('F 1, Y', strtotime($givendate))}}</td>
                                        <td>Opening Balance</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>{{$opening_balance}}</td>
                                    </tr>
                                    @foreach ($ledger as $ledgeritem)
                                        <tr>
                                            <td>{{$ledgeritem->date}}</td>
                                            <td>{{$ledgeritem->particulars}}</td>
                                            <td>
                                                @if ($ledgeritem->debit_amount == 0)
                                                    -
                                                @else
                                                    {{$ledgeritem->debit_amount}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ledgeritem->credit_amount == 0)
                                                    -
                                                @else
                                                    {{$ledgeritem->credit_amount}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ledgeritem->balance < 0)
                                                    ({{-1 * $ledgeritem->balance}})
                                                @elseif($ledgeritem->balance >= 0)
                                                    {{$ledgeritem->balance}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>{{date('F j, Y', strtotime("last day of $givendate"))}}</td>
                                        <td>Closing Balance</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>{{$closing_balance}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
