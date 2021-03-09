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
                <h3>Sent Mail <a href="{{route('admin.sentmails.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View All Sent Mails</a></h3>
            </div>
                  <div class="card-body">
                      <div class="row">
                          <div class="col-md-4">
                              <div class="row">
                                <div class="col-md-3">
                                    <b>Sent To:</b>
                                </div>
                                <div class="col-md-9">
                                    <p>{{$sentmail->sent_to}}</p>
                                </div>
                                <div class="col-md-3">
                                      <b>Sent On:</b>
                                  </div>
                                  <div class="col-md-9">
                                      <p>{{date('F j, Y', strtotime($sentmail->created_at))}}</p>
                                  </div>
                                  <div class="col-md-3">
                                      <b>Subject:</b>
                                  </div>
                                  <div class="col-md-9">
                                      <p>{{$sentmail->subject}}</p>
                                  </div>
                              </div>
                          </div>
                            <div class="col-md-8">
                                <div class="row">
                                  <div class="col-md-12">
                                      <b>Message:</b>
                                  </div>
                                  <div class="col-md-11">
                                      <p>{!!$sentmail->message!!}</p>
                                  </div>
                                </div>
                            </div>
                      </div>
                  </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')

@endpush


