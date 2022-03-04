@extends('layouts.master')
@section('page-content')
    <div class="col-md-9 col-sm-8">
        <div class="panel">
            <div class="panel-heading">
                {{trans('message/uview.messages')}}
            </div>
            <div class="panel-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="inbox-content">
                    <div class="inbox-content"><div class="inbox-header inbox-view-header">
                            <h3 class="">{{ $reciever->message->subject }}
                                <a href="javascript:;"> {{ $reciever->placeholder }} </a>
                            </h3>
                        </div>
                        <div class="inbox-view-info">
                            <div class="">
                                <div class="col-md-12 inbox_img">
                                    <img height="40" width="40" src="{{ $reciever->user->getDocumentPath('PHOTO') }}" class="inbox-author">
                                    @if(in_array($reciever->placeholder, ['inbox', 'important']))
                                        <span class="sbold">{{ $reciever->message->author->full_name }} </span>
                                        <span>&lt;{{ $reciever->message->author->username }}&gt; </span> to
                                        <span class="sbold"> me </span> on {{ Carbon\Carbon::parse($reciever->message->created_at)->toDayDateTimeString() }}
                                    @elseif(in_array($reciever->placeholder, ['sent']))
                                        <span class="sbold">{{ $reciever->message->author->full_name }} </span>
                                        <span>&lt;{{ $reciever->message->author->username }}&gt; </span> to
                                        <span class="sbold">{{ in_array($reciever->placeholder, ['sent'])?$reciever->message->reciever():'me' }}
                        </span> on {{ Carbon\Carbon::parse($reciever->message->created_at)->toDayDateTimeString() }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="inbox-view">
                            {!!  $reciever->message->body !!}
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
<style>
  .inbox_img{padding: 5px 0; margin: 10px 0px; border-top: solid 1px #c3c3c3;  border-bottom: solid 1px #c3c3c3;}
  .inbox_img img{border-radius: 50%!important;  margin-right: 10px;}
</style>
@endpush
