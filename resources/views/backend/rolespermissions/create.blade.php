@extends('backend.layouts.app')
@section('content')
<div class="right_col" role="main">
    @if(session()->has('failure'))
    <div class="alert alert-danger" style="position: none; margin-top: 4rem;">
        {{ session()->get('failure') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session()->has('success'))
    <div class="alert alert-success" style="position: none; margin-top: 4rem;">
        {{ session()->get('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
    <h1 class="mb-3">Create New Role Permissions <a href="{{route('admin.rolepermission.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Permissions</a></h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <form action="{{route('admin.rolepermission.store')}}" method="POST" class="p-3">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_id" style="font-size: 20px">Role:</label>
                                <select name="role" class="form-control">
                                    <option value="">--Select a Role--</option>
                                    @foreach ($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userpermission" style="font-size: 20px;">User and Position Permissions:</label>
                                </div>
                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="1" name="permission[]">
                                            <label class="form-check-label">
                                                View Users
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="2" name="permission[]">
                                            <label class="form-check-label">
                                                Manage Users
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group ml-3">
                                            <input class="form-check-input" type="checkbox" value="3" name="permission[]">
                                            <label class="form-check-label">
                                                Manage Positions
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="staffpermission" style="font-size: 20px;">Staff Permissions:</label>
                                </div>
                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="4" name="permission[]">
                                            <label class="form-check-label">
                                                Manage Staff
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="5" name="permission[]">
                                            <label class="form-check-label">
                                                Manage Staff Salary
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="6" name="permission[]">
                                            <label class="form-check-label">
                                                Staff Salary Report
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="7" name="permission[]">
                                            <label class="form-check-label">
                                                Manage Staff Attendance
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="clientpermission" style="font-size: 20px;">Project and Client Permissions:</label>
                                </div>
                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="8" name="permission[]">
                                            <label class="form-check-label">
                                                View Clients
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="9" name="permission[]">
                                            <label class="form-check-label">
                                                Manage Clients
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="10" name="permission[]">
                                            <label class="form-check-label">
                                                View Projects
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="11" name="permission[]">
                                            <label class="form-check-label">
                                                Manage Projects
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="12" name="permission[]">
                                            <label class="form-check-label">
                                                Manage Project Category
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="otherpermission" style="font-size: 20px;">Other Permissions:</label>
                                </div>
                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="13" name="permission[]">
                                            <label class="form-check-label">
                                                Manage Third Parties
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="14" name="permission[]">
                                            <label class="form-check-label">
                                                Manage Purchase Records
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="15" name="permission[]">
                                            <label class="form-check-label">
                                                Manage Visitors
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="16" name="permission[]">
                                            <label class="form-check-label">
                                                Manage Permissions
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group ml-3">

                                            <input class="form-check-input" type="checkbox" value="17" name="permission[]">
                                            <label class="form-check-label">
                                                Send Email
                                            </label>
                                            @error('permission[]')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                            </div>
                        </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection



