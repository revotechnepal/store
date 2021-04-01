@extends('backend.layouts.app')

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
    <a href="{{route('admin.ledgergenerator')}}" class="btn btn-primary">Generate Monthly Report</a>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    {{-- <h2>Ledger for the month of {{date('F, Y')}}</h2> --}}
                    <h2>Entry New Ledger Record</h2>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.ledger.store')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Entry Date:</label>
                                    <input type="date" name="date" class="form-control">
                                    @error('date')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="particulars">Particulars / Headings:</label>
                                    <input type="particulars" name="particulars" class="form-control" placeholder="Heading for sales or purchase..">
                                    @error('particulars')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount (In Rs.):</label>
                                    <input type="amount" name="amount" class="form-control" placeholder="Amount (In Rs.)">
                                    @error('amount')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Amount Type:</label>
                                    <select name="type" class="form-control">
                                        <option value="">--Select amount type--</option>
                                        <option value="debit">Income</option>
                                        <option value="credit">Expense</option>
                                    </select>
                                    @error('type')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Ledger for the month of {{date('F, Y')}}</h2>
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
                                    <td>{{date('F 1, Y')}}</td>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
