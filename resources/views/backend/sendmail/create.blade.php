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
            <h1>New Mail Format <a href="{{route('admin.mail.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Mail Format</a></h1>
        <div class="card">
                  <div class="card-body">
                        <form action="{{route('admin.mail.store')}}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title" style="font-size: 20px;">Title:</label>
                                        <input type="text" class="form-control" name="title" placeholder="Offer Letter">
                                        @error('title')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subject" style="font-size: 20px;">Subject:</label>
                                        <input type="text" class="form-control" name="subject" placeholder="Eg: Request For Approval">
                                        @error('subject')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6"></div>

                                <div class="col-md-12 mt-3">
                                    <label for="compose" style="font-size: 20px">Compose:</label>
                                    <textarea name="message" class="form-control summernote"></textarea>
                                    @error('message')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-success">Save Format</button>
                                </div>

                            </div>
                        </form>
            </div>
        </div>

    </div>
@endsection
@push('scripts')

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


