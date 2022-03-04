@extends('message.index')
@section('message-page-content')
    <div class="inbox-body">
        <div class="inbox-header">
            <h1 class="pull-left">{{trans('message/important.important')}}</h1>
        </div>
        <div class="inbox-content table-responsive">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th colspan="3">
                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                            <input type="checkbox" class="mail-group-checkbox">
                            <span></span>
                        </label>
                        <div class="btn-group input-actions">
                            <a class="btn btn-sm blue btn-outline dropdown-toggle sbold" href="javascript:;" data-toggle="dropdown"> {{trans('message/important.actions')}}
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-pencil"></i> {{trans('message/important.mark_read')}} </a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-trash-o"></i> {{trans('message/important.delete')}} </a>
                                </li>
                            </ul>
                        </div>
                    </th>
                    <th class="pagination-control" colspan="3">
                        <span class="pagination-info"> {{ $recipient->firstItem()?:0 }} - {{ $recipient->lastItem()?:0 }} of {{$recipient->total()}} </span>
                        <a class="btn btn-sm blue btn-outline" href="{{ $recipient->previousPageUrl() }}">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="btn btn-sm blue btn-outline" href="{{ $recipient->nextPageUrl() }}">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($recipient as $reciever)
                    <tr {{ $reciever->is_read?:'class=unread' }} data-messageid="{{ $reciever->id }}">
                        <td class="inbox-small-cells">
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="mail-checkbox" value="{{ $reciever->message->id }}">
                                <span></span>
                            </label>
                        </td>
                        {{--<td class="inbox-small-cells">
                            <i class="fa fa-star"></i>
                        </td>--}}
                        <td class="view-message hidden-xs" onclick="javascript:location.href ='{{route('message.show', $reciever->id)}}'"> {{ $reciever->message->author->full_name }} </td>
                        <td class="view-message " onclick="javascript:location.href ='{{route('message.show', $reciever->id)}}'"> {{ $reciever->message->subject }} </td>
                        {{--<td class="view-message inbox-small-cells">
                            <i class="fa fa-paperclip"></i>
                        </td>--}}
                        <td class="view-message text-right" colspan="2"> {{ \Carbon\Carbon::parse($reciever->created_at)->diffForHumans() }} </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('js')
<script type="text/javascript">
    $(document).ready(function(){

        var base = '{!! url('/') !!}';
        // handle group checkbox:
        jQuery('body').on('change', '.mail-group-checkbox', function () {
            var set = jQuery('.mail-checkbox');
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                $(this).prop("checked", checked);
            });
        });
        var getMailIDs = function () {
            var set = jQuery('.mail-checkbox:checked');
            var IDS = {};
            jQuery(set).each(function (index) {
                IDS[index] = ($(this).closest('tr').data('messageid'));
            });
            return IDS;
        };
        var base = '{!! url('/') !!}';
        $('a[name=deletemail]').click(function(){
            var ids = getMailIDs();
            $.ajax({
                type:'DELETE',
                url:base + '/message',
                data:{ids:ids},
                dataType:'json',
                success: function(result) {
                    if(result.status) {
                        location.href='/message/inbox';
                    }
                }
            });
        });
        $('a[name=markasread]').click(function(){
            var ids = getMailIDs();
            $.ajax({
                type:'post',
                url:base + '/message/mark-as-read',
                data:{ids:ids},
                dataType:'json',
                success: function(result) {
                    if(result.status) {
                        location.href='/message/inbox';
                    }
                }
            });
        });
    });
</script>
@endpush
