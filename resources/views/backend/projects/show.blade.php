@extends('backend.layouts.app')

@section('content')
<div class="right_col" role="main">
        <h1>Project Information => {{$project->project_name}} <a href="{{route('admin.project.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Projects</a></h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <h3 class="mb-4">Basic Info</h3>
                                    <div class="col-md-5">
                                        <b>Project Name:</b>
                                    </div>
                                    <div class="col-md-7">
                                        {{$project->project_name}}
                                    </div>
                                    <div class="col-md-5">
                                        <b>Staffs Involved:</b>
                                    </div>
                                    <div class="col-md-7">
                                        @php
                                            $name = '';
                                            for ($i = 0 ; $i < count($project->completed_by) ; $i++) {
                                                $staff = DB::table('staff')->where('id', $project->completed_by[$i])->first();
                                                $name = $name . $staff->name .'<br>';
                                            }
                                            echo $name;
                                        @endphp
                                    </div>
                                    <div class="col-md-5">
                                        <b>Started Date:</b>
                                    </div>
                                    <div class="col-md-7">
                                        {{date('F j, Y', strtotime($project->started_date))}}
                                    </div>
                                    <div class="col-md-5">
                                        <b>Completed Date:</b>
                                    </div>
                                    <div class="col-md-7">
                                        {{date('F j, Y', strtotime($project->completed_date))}}
                                    </div>
                                    <div class="col-md-5">
                                        <b>State:</b>
                                    </div>
                                    <div class="col-md-7">
                                        {{$project->state}}
                                    </div>
                                    @if ($project->description != null)
                                        <div class="col-md-5">
                                            <b>Description:</b>
                                        </div>
                                        <div class="col-md-7">
                                            {{$project->description}}
                                        </div>
                                    @endif

                                    <div class="col-md-5">
                                        <b>Total Cost:</b>
                                    </div>
                                    <div class="col-md-7">
                                        @if ($project->price == null)
                                            Project ongoing
                                        @else
                                            Rs. {{$project->price}}
                                        @endif
                                    </div>
                                    <div class="col-md-5">
                                        <b>Category:</b>
                                    </div>
                                    <div class="col-md-7">
                                        {{$project->category->name}}
                                    </div>
                                    <a href="{{route('admin.project.edit', $project->id)}}" class="btn btn-primary mt-3">Edit Info</a>
                                </div>

                                <div class="col-md-7">
                                    <h3 class="mb-4">Project Screenshots</h3>
                                    <div class="row">
                                        @foreach ($projectimages as $image)
                                            <div class="col-md-6">
                                                <a href="http://127.0.0.1:8000/uploads/{{$image->screenshots}}" target="_blank" >
                                                    <img src="{{Storage::disk('uploads')->url($image->screenshots)}}" style="max-height: 150px;">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection

