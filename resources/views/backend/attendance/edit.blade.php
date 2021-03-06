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
                                                <option value="present"{{$attendance->present == 1?'selected':''}}>Present</option>
                                                <option value="paid_leave"{{$attendance->paid_leave == 1?'selected':''}}>Paid Leave</option>
                                                <option value="unpaid_leave"{{$attendance->unpaid_leave == 1?'selected':''}}>Absent</option>
                                            </select>
                                            @error('attendance')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="entry_time">Entry Time:</label>
                                            <input type="time" class="form-control" value="{{@old('entry_time')?@old('entry_time'):$attendance->entry_time}}" name="entry_time">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exit_time">Exit Time:</label>
                                            <input type="time" class="form-control" value="{{@old('exit_time')?@old('exit_time'):$attendance->exit_time}}" name="exit_time">
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

