@extends('backend.layouts.app')
@push('styles')
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    <style>
        .switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 34px;
        }

        .switch input {
          opacity: 0;
          width: 0;
          height: 0;
        }

        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }

        .slider:before {
          position: absolute;
          content: "";
          height: 26px;
          width: 26px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }

        input:checked + .slider {
          background-color: #26B99A;
        }

        input:focus + .slider {
          box-shadow: 0 0 1px #26B99A;
        }

        input:checked + .slider:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
          border-radius: 34px;
        }

        .slider.round:before {
          border-radius: 50%;
        }
    </style>
@endpush
@section('content')
<div class="right_col" role="main">
    @if(session()->has('success'))
                <div class="alert alert-success" style="position: none; margin-top: 4rem;">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            {{-- @if($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{$error}}
                    @endforeach
                </div>
            @endif --}}
            @if(session()->has('failure'))
                <div class="alert alert-danger" style="position: none; margin-top: 4rem;">
                    {{ session()->get('failure') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        <h1>Edit Project <a href="{{route('admin.project.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Projects</a></h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('admin.project.update', $project->id)}}" method="POST" class="bg-light p-3" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="project_name">Project Name: </label>
                                            <input type="text" name="project_name" class="form-control" value="{{@old('project_name')?@old('project_name'):$project->project_name}}">
                                            @error('project_name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="completed_by">Staffs Involved: </label>
                                            <select class="form-control chosen-select" multiple name="completed_by[]">
                                                @foreach ($staff as $involved)
                                                    {{-- <option value="{{$involved->id}}"{{ (old("completed_by") == $project->completed_by ? "selected":"") }}>{{$involved->name}}</option> --}}

                                                    <option value="{{ $involved->id }}" {{ in_array($involved->id, $project->completed_by) ? "selected":"" }}>{{ $involved->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('completed_by')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="started_date">Start Date: </label>
                                            <input type="date" name="started_date" class="form-control" value="{{@old('started_date')?@old('started_date'):$project->started_date}}">
                                            @error('started_date')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="completed_date">Completion Date: </label>
                                            <input type="date" name="completed_date" class="form-control" value="{{@old('completed_date')?@old('completed_date'):$project->completed_date}}">
                                            @error('completed_date')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price">Total Cost (Rs.): </label>
                                            <input type="text" name="price" class="form-control" value="{{@old('price')?@old('price'):$project->price}}" placeholder="Cost in Rs.">
                                            @error('price')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <p style="color:green">Leave this empty if project is ongoing or cost is not finalized.</p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category">Project Category:</label>
                                            <select name="category" id="" class="form-control">
                                                <option value="">--Select a category--</option>
                                                @foreach ($category as $categoryitem)
                                                    <option value="{{$categoryitem->id}}"{{$categoryitem->id == $project->category_id?'selected':''}}>{{$categoryitem->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Description (optional):</label>
                                            <textarea name="description" class="form-control summernote" rows="6" placeholder="Details about the project...">{{$project->description}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-1 text-right">
                                        <div class="form-group">
                                            <label class="switch">
                                                @if ($project->state == 'On Process')
                                                    <input type="checkbox" id="slider" name="slider" value="1">
                                                    <span class="slider round"></span>
                                                @elseif ($project->state == 'Completed')
                                                    <input type="checkbox" id="slider" name="slider" value="1" checked>
                                                    <span class="slider round"></span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-left">
                                        <div class="form-group">
                                            <label for="" style="font-size: 25px;">Completed</label>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="screenshots">Project screenshots (Multiple images can be selected):</label>
                                            <input type="file" class="form-control" name="screenshots[]" multiple>
                                        </div>

                                        <p style="color:green">Do not select new images if you want previous ones.</p>
                                    </div> --}}

                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="card">
                        <div class="card-header">
                            <h3>Edit Project Screenshots</h3>
                        </div>
                        <div class="card-body">
                            @if (count($projectscreenshots) == 0)
                                No screenshots yet.
                            @else
                            <div class="row">
                                @foreach ($projectscreenshots as $screenshot)

                                    <div class="col-md-4 text-center mb-3">
                                        <div class="wrapp">
                                            <a href="{{Storage::disk('uploads')->url($screenshot->screenshots)}}" target="_blank" >
                                                <img src="{{Storage::disk('uploads')->url($screenshot->screenshots)}}" style="max-height: 150px;">
                                                <form action="{{route('admin.deletescreenshot', $screenshot->id)}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" data-id="{{ $screenshot->id }}" class="remove" title="Remove">x</button>
                                                </form>
                                            </a>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{route('admin.addmoreimages', $project->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <div class="row">
                                            <div class="col-md-6 mt-5">
                                                <div class="form-group">
                                                    <label for="screenshots">Add more screenshots (Multiple images can be selected):</label>
                                                    <input type="file" class="form-control" name="screenshots[]" multiple>
                                                    @error('screenshots')
                                                        <p class="text-danger">{{$message}}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                            <div class="col-md-1">
                                                <button type="submit" class="btn btn-primary form-control">Add</button>
                                            </div>
                                    </form>
                                </div>
                            </div>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

    <script>
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
    <script>
        $(document).ready(function() {
        $('.summernote').summernote({
            placeholder: 'Details about the project....',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ]
        });
        });
    </script>
@endpush


