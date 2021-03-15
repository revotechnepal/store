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
            @if(session()->has('failure'))
                <div class="alert alert-danger" style="position: none; margin-top: 4rem;">
                    {{ session()->get('failure') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        <div class="card">
            <div class="card-header">
                <h3>{{$mailformat->title}} <a href="{{route('admin.mail.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Mail Format</a></h3>
            </div>
                  <div class="card-body">
                   <form action="{{route('admin.customer.email')}}" method="POST" id="form" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
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
                                <div class="col-md-6"><a href="" onclick="add_fieldtostaff()" class="btn btn-primary"><i class="fa fa-plus"></i> Add Recipient</a></div>

                                <div class="col-md-1 text-right">
                                    <label for="subject" style="font-size: 20px;">Subject:</label>
                                </div>
                                <div class="col-md-5 text-left">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="subject" placeholder="Eg: Request For Approval" value="{{$mailformat->subject}}">
                                        @error('subject')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6"></div>

                                <div class="col-md-12 mt-3">
                                    <label for="compose" style="font-size: 20px">Compose:</label>
                                    <textarea name="message" class="form-control summernote">{{$mailformat->message}}</textarea>
                                    @error('message')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="attach" style="font-size: 20px;">Attach files (multiple files can be selected):</label>
                                        <input type="file" name="files[]" class="form-control" multiple>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-success">Send Email</button>
                                </div>

                            </div>
                        </form>

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
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
<script>
    $(document).ready(function() {
    $('.summernote').summernote({
        placeholder: "Compose your message..",
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


