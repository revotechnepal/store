@extends('backend.layouts.app')

@push('styles')
{{-- <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/> --}}
{{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" integrity="sha256-b5ZKCi55IX+24Jqn638cP/q3Nb2nlx+MH/vMMqrId6k=" crossorigin="anonymous" /> --}}
@endpush

@section('content')
<div class="right_col" role="main">
        <h1>Edit User Info <a href="{{route('admin.user.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Users</a></h1>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h2>Edit Basic Info</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.user.update', $user->id)}}" method="POST" class="bg-light p-3">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Full Name : </label>
                                            <input type="text" name="name" class="form-control" value="{{@old('name')?@old('name'):$user->name}}" placeholder="User Full Name">
                                            @error('name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Email : </label>
                                            <input type="text" name="email" class="form-control" value="{{@old('email')?@old('email'):$user->email}}" placeholder="Email Address">
                                            @error('email')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="role_id">Role: </label>
                                            <select name="role_id" class="form-control" id="">
                                                <option value="">--Select a Role--</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{$role->id}}"{{$role->id == $user->role_id?'selected':''}}>{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-success mt-3" name="updatedetails">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h2>Edit Password</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.user.update', $user->id)}}" method="POST" class="bg-light p-3">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="oldpassword">Old Password : </label>
                                            <input type="password" name="oldpassword" class="form-control" value="{{@old('oldpassword')}}" placeholder="Enter Old Password">
                                            @error('oldpassword')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="new_password">New Password : </label>
                                            <input type="password" name="new_password" class="form-control" value="{{@old('new_password')}}" placeholder="Enter New Password">
                                            @error('new_password')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="new_password_confirmation">Confirm Password : </label>
                                            <input type="password" name="new_password_confirmation" class="form-control" value="{{@old('new_password_confirmation')}}" placeholder="Re-type New Password">
                                            @error('new_password_confirmation')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-success mt-3" name="updatepassword">Submit</button>
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

