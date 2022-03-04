@extends('layouts.admin')
@section('page-bar')
        <!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('announcement/index.home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('announcement/index.announcement_list')}} </span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('announcement/index.announcement_list')}}
    <!-- <small>{{trans('announcement/index.list')}}</small> -->
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">{{trans('announcement/index.manage_announcement')}}</span>
                    </div>
                    <div class="actions">
                        <a href="{{ route('admin.announcement.create') }}" class="btn red btn-outline sbold" name="create"> {{trans('announcement/index.add_announcement')}}</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-left">{{trans('announcement/index.title')}}</th>
                                <th class="text-center">{{trans('announcement/index.description')}}</th>
                                <th class="text-center">{{trans('announcement/index.status')}}</th>
                                <th class="text-center">{{trans('announcement/index.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($announcements as $announcement)
                                <tr>
                                    <td class="text-center">{{$announcement->title}}</td>
                                    <td class="text-center">{{$announcement->description}} </td>
                                    <td class="text-center">
                                        <label>
                                            <a class="text-{{$announcement->status?'success':'danger'}}"
                                               href="{{ route('admin.announcement.change-status', $announcement->id) }}">
                                                @if ($announcement->status == 0)
                                                    {{trans('announcement/index.Inactive')}}
                                                @else
                                                    {{trans('announcement/index.Active')}}
                                                @endif
                                                
                                            </a>
                                        </label>


                                    </td>
                                    <td class="text-center">
                                        <a title="Edit" href="{{ route('admin.announcement.edit', $announcement->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i>{{--{{trans('announcement/index.edit')}}--}}</a>
                                        <a title="Delete" href="{{ route('admin.announcement.delete', $announcement->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i>{{--{{trans('announcement/index.delete')}}--}}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger">{{trans('announcement/index.no_announcement')}}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{$announcements->links()}}
                </div>
            </div>
        </div>
@endsection
@push('css')
    <link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('js')
    <script src="{{ asset('assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script>
        $(document).ready(function(){

            $('.date-picker').datepicker({
                orientation: "bottom",
                autoclose: true
            });

            $('a[title=Delete]').click(function(event){
                event.preventDefault();

                var url = $(this).attr('href');

                bootbox.confirm('Are you sure you want to delete this announcement?', function(result){
                    if(result) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {_method:'DELETE'},
                            context:this,
                            success: function( result ) {
                                var result = $.parseJSON(result);
                                if(result.status){
                                    $(this).closest("tr").remove();
                                }
                                bootbox.alert(result.message);
                                location.reload();
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
