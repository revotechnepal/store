@extends('backend.layouts.app')

@push('styles')
{{-- <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/> --}}
{{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" integrity="sha256-b5ZKCi55IX+24Jqn638cP/q3Nb2nlx+MH/vMMqrId6k=" crossorigin="anonymous" /> --}}
@endpush

@section('content')
<div class="right_col" role="main">
        <h1>Edit Purchase Record Info <a href="{{route('admin.purchaserecord.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Records</a></h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('admin.purchaserecord.update', $purchaseRecord->id)}}" method="POST" class="bg-light p-3">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="thirdparty_name">Purchased From : </label>
                                            <select name="thirdparty_name" class="form-control">
                                                <option value="">--Select an option--</option>
                                                @foreach ($thirdParty as $party)
                                                    <option value="{{$party->name}}"{{$party->name == $purchaseRecord->thirdparty_name?'selected':''}}>{{$party->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('thirdpaty_name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="purchase_date">Purchase Date : </label>
                                            <input type="date" name="purchase_date" class="form-control" value="{{@old('purchase_date')?@old('purchase_date'):$purchaseRecord->purchase_date}}" placeholder="Concerned Person name">
                                            @error('purchase_date')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bill_number">Bill number : </label>
                                            <input type="text" name="bill_number" class="form-control" value="{{@old('bill_number')?@old('bill_number'):$purchaseRecord->bill_number}}" placeholder="Enter Bill Number">
                                            @error('bill_number')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bill_amount">Bill Amount (Rs.) : </label>
                                            <input type="text" name="bill_amount" class="form-control" value="{{@old('bill_amount')?@old('bill_amount'):$purchaseRecord->bill_amount}}" placeholder="Total Bill amount">
                                            @error('bill_amount')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="paid_amount">Paid Amount (Rs.) : </label>
                                            <input type="text" name="paid_amount" class="form-control" value="{{@old('paid_amount')?@old('paid_amount'):$purchaseRecord->paid_amount}}" placeholder="Paid amount">
                                            @error('paid_amount')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="purpose">Purpose : </label>
                                            <textarea name="purpose" id="" cols="30" rows="10" class="form-control" placeholder="Purpose of taking service">{{$purchaseRecord->purpose}}</textarea>
                                            @error('purpose')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mt-3">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection

@push('scripts')

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha256-5YmaxAwMjIpMrVlK84Y/+NjCpKnFYa8bWWBbUHSBGfU=" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(function () {
        $('.datetimepicker').datetimepicker();
    });
</script> --}}

@endpush

