@extends('backend.layouts.app')

@push('styles')
{{-- <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/> --}}
{{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" integrity="sha256-b5ZKCi55IX+24Jqn638cP/q3Nb2nlx+MH/vMMqrId6k=" crossorigin="anonymous" /> --}}
@endpush

@section('content')
<div class="right_col" role="main">
        <h1>New Third Party Service <a href="{{route('admin.thirdparty.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Our Third Party Services</a></h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('admin.thirdparty.store')}}" method="POST" class="bg-light p-3">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name : </label>
                                            <input type="text" name="name" class="form-control" value="{{@old('name')}}" placeholder="Store/ Party Name">
                                            @error('name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_name">Contact Name : </label>
                                            <input type="text" name="contact_name" class="form-control" value="{{@old('contact_name')}}" placeholder="Concerned Person name">
                                            @error('contact_name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email (Optional): </label>
                                            <input type="text" name="email" class="form-control" value="{{@old('email')}}" placeholder="Email Info">
                                            @error('email')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Contact no.: </label>
                                            <input type="text" name="phone" class="form-control" value="{{@old('phone')}}" placeholder="Contact no.">
                                            @error('phone')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address: </label>
                                            <input type="text" name="address" class="form-control" value="{{@old('address')}}" placeholder="Eg: Chamati-15, Kathmandu, Nepal">
                                            @error('address')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pan">PAN (Optional): </label>
                                            <input type="text" name="pan" class="form-control" value="{{@old('pan')}}" placeholder="Third Party's PAN no.">
                                            @error('pan')
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

