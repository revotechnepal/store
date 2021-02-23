@extends('backend.layouts.app')
@push('styles')

@endpush
@section('content')
<div class="right_col" role="main">
        <h1>Edit Invoice <a href="{{route('admin.payment.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Invoices</a></h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('admin.payment.update', $payment->id)}}" method="POST" class="bg-light p-3">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date" style="font-size: 20px;">Date:</label>
                                            <input type="date" name="date" class="form-control" value="{{@old('date')?@old('date'):$payment->date}}">
                                            @error('date')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="staff_id" style="font-size: 20px;">Payment To: </label>
                                            <select class="form-control" name="staff_id">
                                                <option value="">Staffs</option>
                                                @foreach ($staff as $involved)
                                                    <option value="{{$involved->id}}"{{$involved->id == $payment->staff_id?'selected':''}}>{{$involved->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('staff_id')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type" style="font-size: 20px;">Payment Type: </label>
                                            <select class="form-control" name="type">
                                                <option value="">Select a type</option>
                                                <option value="advance" @if( $payment->type == 'advance')selected @endif>Advance</option>
                                                <option value="regular" @if( $payment->type == 'regular')selected @endif>Regular</option>
                                                <option value="overdue" @if( $payment->type == 'overdue')selected @endif>Overdue</option>
                                            </select>
                                            @error('type')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="amount" style="font-size: 20px;">Amount (In Rs.):</label>
                                            <input type="text" name="amount" class="form-control" value="{{@old('amount')?@old('amount'):$payment->amount}}">
                                            @error('amount')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection

@push('scripts')

@endpush


