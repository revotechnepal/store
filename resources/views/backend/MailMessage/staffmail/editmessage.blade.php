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
                <h3>Edit Compose For Staff</h3>
            </div>
            <div class="card-body">
                <form action="{{route('admin.staff.message.update')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <textarea name="messagetostaff" class="form-control summernote" placeholder="Compose your message..">{{$messagetostaff->mailtostaff}}</textarea>
                        </div>
                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn btn-success">Save </button>
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
