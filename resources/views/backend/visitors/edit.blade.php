@extends('backend.layouts.app')

@push('styles')
{{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" integrity="sha256-b5ZKCi55IX+24Jqn638cP/q3Nb2nlx+MH/vMMqrId6k=" crossorigin="anonymous" /> --}}
@endpush

@section('content')
<div class="right_col" role="main">
        <h1>Edit Visitor Info <a href="{{route('admin.visitor.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Visitors</a></h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('admin.visitor.update', $visitor->id)}}" method="POST" class="bg-light p-3">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name: </label>
                                            <input type="text" name="name" class="form-control" value="{{@old('name')?@old('name'):$visitor->name}}" placeholder="Full Name">
                                            @error('name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Date and Time">Date and Time of Visit</label>
                                            <input type="datetime-local" class="form-control datetimepicker" name="dateofvisit" value="{{@old('dateofvisit')?@old('dateofvisit'):$visitor->dateofvisit}}">
                                            @error('dateofvisit')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email: </label>
                                            <input type="text" name="email" class="form-control" value="{{@old('email')?@old('email'):$visitor->email}}" placeholder="Email Address">
                                            @error('email')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Contact no.: </label>
                                            <input type="text" name="phone" class="form-control" value="{{@old('phone')?@old('phone'):$visitor->phone}}" placeholder="Contact no.">
                                            @error('phone')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="concerned_with">Concerned With: </label>
                                            <select class="form-control" name="concerned_with">
                                                <option value="">Staffs</option>
                                                @foreach ($staff as $involved)
                                                    <option value="{{$involved->id}}"{{$involved->id == $visitor->concerned_with?'selected':''}}>{{$involved->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('concerned_with')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="assigned_to">Assigned To: </label>
                                            <select class="form-control" name="assigned_to">
                                                <option value="">Staffs</option>
                                                @foreach ($staff as $involved)
                                                    <option value="{{$involved->id}}"{{$involved->id == $visitor->assigned_to?'selected':''}}>{{$involved->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('assigned_to')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="reason">Reason for visiting (optional):</label>
                                        <textarea name="reason" id="" cols="30" rows="10" placeholder="Any particular reason to visit.." class="form-control">{{$visitor->reason}}</textarea>
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

