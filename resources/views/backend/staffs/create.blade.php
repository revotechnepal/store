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
    @if(session()->has('failure'))
                    <div class="alert alert-danger" style="position: none; margin-top: 4rem;">
                        {{ session()->get('failure') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
        <h1>Entry New Staff <a href="{{route('admin.staff.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Staffs</a></h1>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('admin.staff.store')}}" method="POST" class="bg-light p-3" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name: </label>
                                            <input type="text" name="name" class="form-control" value="{{@old('name')}}" placeholder="Full Name">
                                            @error('name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="position">Position: </label>
                                            <select name="position" id="" class="form-control">
                                                <option value="">Select a position</option>
                                                @foreach ($position as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('position')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email: </label>
                                            <input type="text" name="email" class="form-control" value="{{@old('email')}}" placeholder="Email Address">
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
                                            <label for="image">Image (Pp): </label>
                                            <input type="file" name="image" class="form-control" value="{{@old('image')}}">
                                            @error('image')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="national_id">National Id (Citizenship/ License) (pdf): </label>
                                            <input type="file" name="national_id" class="form-control" value="{{@old('national_id')}}">
                                            @error('national_id')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="documents">Document (Resume/ CV/ Traning Certificates) (pdf): </label>
                                            <input type="file" name="documents" class="form-control" value="{{@old('documents')}}">
                                            @error('documents')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contract">Contract/ Aggrement (pdf): </label>
                                            <input type="file" name="contract" class="form-control" value="{{@old('contract')}}">
                                            @error('contract')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="allocated_salary">Allocated Salary (in Rs.): </label>
                                            <input type="text" name="allocated_salary" class="form-control" value="{{@old('allocated_salary')}}" placeholder="Allocated Salaray (in Rs.)">
                                            @error('allocated_salary')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-5">
                                        <label for="" style="font-size: 25px;">Give access to dashboard</label>&nbsp;
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <label class="switch">
                                            <input type="hidden" name="role" value="0">
                                            <input type="checkbox" name="role" value="1" id="slider">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>

                                    {{-- <div class="col-md-6" id="willappear" style="display: none;">
                                        <label for="roles">Give Role:</label>
                                        <select name="role" class="form-control">
                                            <option value="">Select a role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection

{{-- @push('scripts')
<script>
    function giveRole() {
      var row = document.getElementById("willappear");
      if (row.style.display === "none") {
        row.style.display = "block";
      } else {
        row.style.display = "none";
      }
    }
    // $(document).ready(function(){
    //     $("#slider").click(function(event){
    //         event.preventDefault();
    //     });
    // });
</script>
@endpush --}}

