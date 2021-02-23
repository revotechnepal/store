@extends('backend.layouts.app')

@push('styles')
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
        <h1>Edit Position <a href="{{route('admin.position.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Positions</a></h1>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('admin.position.update', $position->id)}}" method="POST" class="bg-light p-3">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Position: </label>
                                            <input type="text" name="name" class="form-control" value="{{@old('name')?@old('name'):$position->name}}" placeholder="Eg: CEO">
                                            @error('name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group mt-2">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="switch">
                                                        <input type="hidden" name="make_role" value="0" class="fonr-control">
                                                        <input type="checkbox" id="slider" name="make_role" value="1"{{$position->make_role == 1?'checked':''}} class="fonr-control">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <label for="" style="font-size: 20px;">Make role (for this position)</label>&nbsp;
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-12">
                                        <div class="form-group mt-2">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="switch">
                                                        <input type="hidden" name="make_role" value="0" class="fonr-control">
                                                        <input type="checkbox" id="slider" name="make_role" value="1" class="fonr-control">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <label for="" style="font-size: 20px;">Make role (for this position)</label>&nbsp;
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection

