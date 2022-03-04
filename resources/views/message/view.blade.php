@extends('message.index')
@section('message-page-content')
<!-- BEGIN CONTENT BODY -->
<div class="inbox-body">
    <div class="inbox-header">
        <h1 class="pull-left">{{trans('message/view.messages')}}</h1>
    </div>
    <div class="inbox-content">
        <div class="inbox-content"><div class="inbox-header inbox-view-header">
                <h1 class="pull-left">{{ $reciever->message->subject }}
                    <a href="javascript:;"> {{ $reciever->placeholder }} </a>
                </h1>
            </div>
            <div class="inbox-view-info">
                <div class="row">
                    <div class="col-md-12">
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
<!-- END CONTENT BODY -->
@endsection
