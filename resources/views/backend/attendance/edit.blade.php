@extends('backend.layouts.app')
@push('styles')

@endpush
@section('content')
<div class="right_col" role="main">
        <h1>Edit Staff Attendance => {{$attendance->staff->name}} <a href="{{route('admin.attendance.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Back</a></h1>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('admin.attendance.update', $attendance->id)}}" method="POST" class="bg-light p-3">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="attendance">Today's Attendance: </label>
                                            <select name="attendance" class="form-control">
                                                <option value="">--Select an option--</option>
                                                <option value="present">Present</option>
                                                <option value="paid_leave">Paid Leave</option>
                                                <option value="unpaid_leave">Absent</option>
                                            </select>
                                            @error('attendance')
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

@endpush

