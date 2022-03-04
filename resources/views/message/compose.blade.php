@extends('message.index')
@section('message-page-content')
    <div class="inbox-body">
        <div class="inbox-header">
            <h1 class="pull-left">{{trans('message/compose.compose_email')}}</h1>
        </div>
        <form class="inbox-compose form-horizontal" id="fileupload" action="{{ route('admin.message.send') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="inbox-compose-btn">
                <button class="btn green">
                    <i class="fa fa-check"></i>{{trans('message/compose.send')}}</button>
                <button class="btn default inbox-discard-btn" type="reset">{{trans('message/compose.discard')}}</button>
                {{--<button class="btn default">Draft</button>--}}
            </div>
            <div class="inbox-form-group mail-to {{$errors->has('to')?' has-error':' has-feedback'}}">
                <label class="control-label">{{trans('message/compose.to')}}:</label>
                <div class="controls controls-to">
                    <select name="to[]" id="to" class="form-control" multiple style="width: 100%">
                        @foreach($children as $key => $child)
                            <option value="{{$key}}" @if(old("to.$key") == $child) selected @endif>{{ $child }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="help-block">{{$errors->first('to.*')}}</p>
            </div>
            <div class="inbox-form-group{{$errors->has('subject')?' has-error':' has-feedback'}}">
                <label class="control-label">{{trans('message/compose.subject')}}:</label>
                <div class="controls">
                    <input type="text" class="form-control" name="subject" value="{{ old('subject') }}">
                </div>
                <p class="help-block">{{$errors->first('subject')}}</p>
            </div>
            <div class="inbox-form-group{{$errors->has('message')?' has-error':' has-feedback'}}">
                <textarea class="inbox-editor inbox-wysihtml5 form-control" name="message" rows="3">{{ old('message') }}</textarea>
                <p class="help-block">{{$errors->first('message')}}</p>
            </div>
            <div class="inbox-compose-btn">
                <button class="btn green">
                    <i class="fa fa-check"></i>{{trans('message/compose.send')}}</button>
                <button class="btn default">{{trans('message/compose.discard')}}</button>
                {{--<button class="btn default">Draft</button>--}}
            </div>
        </form>
    </div>

@endsection
@push('css')
<link href="{{ asset('assets/global/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/apps/css/inbox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}">
@endpush

@push('js')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('assets/global/plugins/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<script type="text/javascript">
    $(document).ready(function() {
        $("select#to").select2();

        $('.inbox-wysihtml5').wysihtml5();
    });
</script>
@endpush
