@extends('backend.layouts.app')

@section('content')
<div class="right_col" role="main">
        <h1>Staff Profile <a href="{{route('admin.staff.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Staffs</a></h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <img src="{{Storage::disk('uploads')->url($staff->image)}}" alt="{{$staff->name}}" class="img-circle profile_img" style="height: 250px;">
                                </div>

                                <div class="col-md-7 mt-5 text-center">
                                    <b style="font-size: 40px;">{{$staff->position->name}}</b><br>
                                    <b style="font-size: 30px;">{{$staff->name}}</b><br>
                                    <p style="font-size: 20px;">{{$staff->email}}<br>
                                        +977 {{$staff->phone}}
                                    </p>

                                    @if ($user == null)

                                    @else
                                        <p style="font-size: 15px;">Role (Dashboard):
                                            {{$user->role->name}}
                                        </p>
                                    @endif

                                </div>
                                <hr>

                                <div class="col-md-12 mt-5">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="font-weight: bolder">Document Name</th>
                                                    <th style="font-weight: bolder">Document Link</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>National Id (pdf)</td>
                                                    <td><a href="{{Storage::disk('uploads')->url($staff->national_id)}}" target="_blank">Click Here</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Documents (Resume/ CV) (pdf)</td>
                                                    <td><a href="{{Storage::disk('uploads')->url($staff->document)}}" target="_blank">Click Here</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Contract/Agreement (pdf)</td>
                                                    <td><a href="{{Storage::disk('uploads')->url($staff->contract)}}" target="_blank">Click Here</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="{{route('admin.staff.edit', $staff->id)}}" class="btn btn-primary">Edit Info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection

