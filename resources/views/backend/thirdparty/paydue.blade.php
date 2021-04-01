@extends('backend.layouts.app')

@section('content')
<div class="right_col" role="main">

    @if (session('success'))
        <div class="col-sm-12">
            <div class="alert  alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        </div>
    @endif
    <h1 class="mb-3">{{$thirdParty->name}} <a href="{{route('admin.thirdparty.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Our Suppliers</a></h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                @php
                    $olddues = DB::table('purchase_records')->where('thirdparty_name', $thirdParty->name)->where('monthyear', '!=', date('F, Y'))->get();
                    $olddueamount = 0;
                    foreach ($olddues as $dues) {
                        $olddueamount = $olddueamount + $dues->due_amount;
                    }
                    $totalbillamount = 0;
                    $totalpaidamount = 0;
                    foreach($expenserecord as $expense){
                        $totalbillamount = $totalbillamount + $expense->bill_amount;
                        $totalpaidamount = $totalpaidamount + $expense->paid_amount;
                    }
                    $dueamount = $totalbillamount - $totalpaidamount;
                @endphp
                <div class="card-header text-center">
                    <h2>Due Payment for month of {{$date}}</h2>
                </div>

                <div class="card-body">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Total Bill Amount: </p>
                            </div>
                            <div class="col-md-6">
                                <p>Rs. {{$totalbillamount}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Total Paid Amount: </p>
                            </div>
                            <div class="col-md-6">
                                <p>Rs. {{$totalpaidamount}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Due Amount: </p>
                            </div>
                            <div class="col-md-6">
                                <p>Rs. {{$dueamount}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Old Due Amount (Previous Months): </p>
                            </div>
                            <div class="col-md-6">
                                <p>Rs. {{$olddueamount}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Total Due Amount: </p>
                            </div>
                            <div class="col-md-6">
                                <p>Rs. {{$dueamount + $olddueamount}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                    <form action="{{route('admin.cleardues', $thirdParty->id)}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="bill_number">Bill number : </label>
                                    <input type="text" name="bill_number" class="form-control" value="{{@old('bill_number')}}" placeholder="Enter Bill Number">
                                    @error('bill_number')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="monthyear" value="{{$date}}">
                                    <label for="amount">Payment Amount (in Rs.)</label>
                                    <input type="text" class="form-control" name="amount" placeholder="Amount in Rs.">
                                    @error('amount')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="payment_date">Payment Date</label>
                                    <input type="date" class="form-control" name="payment_date">
                                    @error('payment_date')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
