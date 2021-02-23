@extends('backend.layouts.app')
@push('styles')
    <link href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
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
        <div class="card">
            <div class="card-header text-center">
                <h3>Compose Email</h3>
            </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="mailtostaff-tab" data-toggle="tab" href="#mailtostaff" role="tab" aria-controls="mailtostaff" aria-selected="true" style="font-weight: bold; font-size: 15px;">Mail to staff</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="mailtoclient-tab" data-toggle="tab" href="#mailtoclient" role="tab" aria-controls="mailtoclient" aria-selected="false" style="font-weight: bold; font-size: 15px;">Mail to client</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="mailtothirdparty-tab" data-toggle="tab" href="#mailtothirdparty" role="tab" aria-controls="mailtothirdparty" aria-selected="false" style="font-weight: bold; font-size: 15px;">Send Mail</a>
                    </li>
                  </ul>
                  <div class="card-body">
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="mailtostaff" role="tabpanel" aria-labelledby="mailtostaff-tab">
                        <form action="{{route('admin.customer.email')}}" method="GET" id="form">
                            @csrf
                            @method('GET')
                            <div class="row">
                                <div class="col-md-1">
                                    <label for="to" style="font-size: 20px;">To:</label>
                                </div>
                                <div class="col-md-5 text-left">
                                    <div class="form-group" id="form-group">
                                        <input type="text" class="form-control" name="email[]" placeholder="example@gmail.com">
                                        @error('email')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6"><a href="" onclick="add_fieldtostaff()" class="btn btn-primary"><i class="fa fa-plus"></i> Add Receiptant</a></div>

                                <div class="col-md-1 text-right">
                                    <label for="subject" style="font-size: 20px;">Subject:</label>
                                </div>
                                <div class="col-md-5 text-left">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="subject" placeholder="Eg: Request For Approval">
                                        @error('subject')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6"></div>

                                <div class="col-md-12 mt-3">
                                    <label for="compose" style="font-size: 20px">Compose:</label>
                                    <textarea name="message" id="" rows="4" cols="40" class="form-control summernote" placeholder="Compose your message..">{{$messagetostaff->mailtostaff}}</textarea>
                                    @error('message')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-success">Send Email</button> <a href="{{route('admin.editStaffMessage')}}" class="btn btn-primary">Edit Staff Compose</a>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="mailtoclient" role="tabpanel" aria-labelledby="mailtoclient-tab">
                        <form action="{{route('admin.client.email')}}" method="GET" id="form">
                            @csrf
                            @method('GET')
                            <div class="row">
                                <div class="col-md-1">
                                    <label for="to" style="font-size: 20px;">To:</label>
                                </div>
                                <div class="col-md-5 text-left">
                                    <div class="form-group" id="form-group1">
                                        <input type="text" class="form-control" name="email[]" placeholder="example@gmail.com">
                                        @error('email')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6"><a href="" onclick="add_fieldtoclient()" class="btn btn-primary"><i class="fa fa-plus"></i> Add Receiptant</a></div>

                                <div class="col-md-1 text-right">
                                    <label for="subject" style="font-size: 20px;">Subject:</label>
                                </div>
                                <div class="col-md-5 text-left">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="subject" placeholder="Eg: Request For Approval">
                                        @error('subject')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6"></div>

                                <div class="col-md-12 mt-3">
                                    <label for="compose" style="font-size: 20px">Compose:</label>
                                    <textarea name="message" id="" rows="4" cols="40" class="form-control summernote" placeholder="Compose your message..">{{$messagetostaff->mailtoclient}}</textarea>
                                    @error('message')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-success">Send Email</button> <a href="{{route('admin.editClientMessage')}}" class="btn btn-primary">Edit Client Compose</a>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="mailtothirdparty" role="tabpanel" aria-labelledby="mailtothirdparty-tab">
                        <form action="{{route('admin.customer.email')}}" method="GET" id="form">
                            @csrf
                            @method('GET')
                            <div class="row">
                                <div class="col-md-1">
                                    <label for="to" style="font-size: 20px;">To:</label>
                                </div>
                                <div class="col-md-5 text-left">
                                    <div class="form-group" id="form-group2">
                                        <input type="text" class="form-control" name="email[]" placeholder="example@gmail.com">
                                        @error('email')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6"><a href="" onclick="add_fieldtothirdparty()" class="btn btn-primary"><i class="fa fa-plus"></i> Add Receiptant</a></div>

                                <div class="col-md-1 text-right">
                                    <label for="subject" style="font-size: 20px;">Subject:</label>
                                </div>
                                <div class="col-md-5 text-left">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="subject" placeholder="Eg: Request For Approval">
                                        @error('subject')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6"></div>

                                <div class="col-md-12 mt-3">
                                    <label for="compose" style="font-size: 20px">Compose:</label>
                                    <textarea name="message" id="" rows="4" cols="40" class="form-control summernote" placeholder="Compose your message..">{{$messagetostaff->mailtothirdparty}}</textarea>
                                    @error('message')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-success">Send Email</button> <a href="{{route('admin.editThirdMessage')}}" class="btn btn-primary">Edit Compose</a>
                                </div>

                            </div>
                        </form>
                    </div>
                  </div>

            </div>
        </div>

    </div>
@endsection
@push('scripts')
<script>
    function add_fieldtostaff(){
        event.preventDefault();

        var x = document.getElementById("form-group");
        var new_field = document.createElement("input");
        new_field.setAttribute("type", "text");
        new_field.setAttribute("name", "email[]");
        new_field.setAttribute("class", "form-control");
        new_field.setAttribute("placeholder", "example@gmail.com");
        var pos = x.childElementCount;
        x.insertBefore(new_field, x.childNodes[pos]);
    }
    function add_fieldtoclient(){
        event.preventDefault();

        var x = document.getElementById("form-group1");
        var new_field = document.createElement("input");
        new_field.setAttribute("type", "text");
        new_field.setAttribute("name", "email[]");
        new_field.setAttribute("class", "form-control");
        new_field.setAttribute("placeholder", "example@gmail.com");
        var pos = x.childElementCount;
        x.insertBefore(new_field, x.childNodes[pos]);
    }
    function add_fieldtothirdparty(){
        event.preventDefault();

        var x = document.getElementById("form-group2");
        var new_field = document.createElement("input");
        new_field.setAttribute("type", "text");
        new_field.setAttribute("name", "email[]");
        new_field.setAttribute("class", "form-control");
        new_field.setAttribute("placeholder", "example@gmail.com");
        var pos = x.childElementCount;
        x.insertBefore(new_field, x.childNodes[pos]);
    }
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
<script>
    $(document).ready(function() {
    $('.summernote').summernote({
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


