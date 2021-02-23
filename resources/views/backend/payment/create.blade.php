@extends('backend.layouts.app')
@push('styles')

@endpush
@section('content')
<div class="right_col" role="main">
        <h1>Payment Invoice <a href="{{route('admin.payment.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Invoices</a></h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('admin.payment.store')}}" method="POST" class="bg-light p-3">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date" style="font-size: 20px;">Date:</label>
                                            <input type="date" name="date" class="form-control" value="{{@old('date')}}">
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
                                                    <option value="{{$involved->id}}">{{$involved->name}}</option>
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
                                                <option value="advance">Advance</option>
                                                <option value="regular">Regular</option>
                                                <option value="overdue">Overdue</option>
                                            </select>
                                            @error('type')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="amount" style="font-size: 20px;">Amount (In Rs.):</label>
                                            <input type="text" name="amount" class="form-control" value="{{@old('amount')}}">
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


