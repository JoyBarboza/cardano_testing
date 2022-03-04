@extends('layouts.admin')
@section('page-bar')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/home') }}">{{trans('approve/document.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ url('/home') }}">{{trans('approve/document.approve')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{trans('approve/document.pending_document_list')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> {{trans('approve/document.document_approve')}} <small>{{trans('approve/document.panel')}}</small></h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
@endsection
@section('contents')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>{{trans('approve/document.pending_document_list')}}</div>
                </div>
                <div class="portlet-body flip-scroll">
                    <table class="table table-bordered table-striped table-condensed flip-content">
                        <thead class="flip-content">
                        <tr>
                            <th class="text-center" width="15%"> {{trans('approve/document.username')}} </th>
                            <th class="text-center"> {{trans('approve/document.address')}} </th>
                            <th class="text-center"> {{trans('approve/document.city')}}</th>
                            <th class="text-center"> {{trans('approve/document.state')}} </th>
                            <th class="text-center"> {{trans('approve/document.identification_no')}} </th>
                            <th class="text-center"> {{trans('approve/document.documents')}} </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="text-center">{{ $user->username }}</td>
                                <td class="text-center">
                                    {{ $user->profile->address }}
                                </td>
                                <td class="text-center">
                                    {{ $user->profile->city }}
                                </td>
                                <td class="text-center"  width="10%">
                                    {{ $user->profile->state }}
                                </td>
                                <td class="text-center">
                                    {{ $user->profile->ide_no }}
                                </td>
                                <td class="text-center">
                                    @foreach($user->document as $document)
                                    <div class="row" style="margin:0px">
                                        <div class="col-md-9" style="margin:0px; padding:0px">
                                        <a
                                                class="openDiag btn btn-circle blue btn-block"
                                                style="font-size:10pt"
                                                data-toggle="modal" href="#long"
                                                data-user = "{{$user->username}}"
                                                data-filename = "{{ $document->location }}"
                                                data-image="{{ route('photo.get', [$document->location,$user->username])  }}"
                                                @if($document->status == 1)
                                                data-action="admin/document/{{$user->id}}/{{$document->id}}" {{$document->status}}
                                                @endif
                                                >
                                            View {{ strtolower(str_replace('_', ' ', $document->name)) }}
                                        </a>
                                        </div>
                                        <div class="col-md-3" style="margin:0px; padding:0px">
                                        <a class="btn btn-circle blue btn-block" href="{{ route('photo.get', $document->location) }}"><i class="fa fa-download"></i></a>
                                        </div>
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-danger">{{trans('approve/document.req_pending')}}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div id="long" class="modal fade modal-scroll" tabindex="-1" data-replace="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{trans('approve/document.document_display')}}</h4>
                </div>
                <div class="modal-body">
                    <img style="height:380px;width:100%;" />
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
@endsection

@push('css')
<style>
    .btn.btn-outline.blue {
        width: 156px;
        margin: 2px auto;
    }
</style>
@endpush
@push('js')
<script>
    $(document).ready(function(){

        var url = '{!! url('/') !!}';
        $('a.openDiag').click(function(){
            var route = $(this).data('action');
            if(route != undefined) {
                $('div[id=long]').find('div.modal-footer').empty().prepend(
                    '<button name="approve" type="button"'+
                    '" class="btn green btn-outline" onclick="performAction(this, \''+route+'/approve\')">Approve</button>'+
                    '<button name="reject" type="button"'+
                    '" class="btn red btn-outline" onclick="performAction(this, \''+route+'/reject\')" data-style="contract">Reject</button>'+
                    '<button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>'
                );
            } else {
                $('div[id=long]').find('div.modal-footer').empty().prepend(
                        '<button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>'
                );
            }
            $('div[id=long]').find('img').attr('src', $(this).data('image'));
        });

    });

    function performAction(element, route) {
        $.ajax({
            url:route,
            type:'POST',
            dataType:'json',
            beforeSend:function(){
                $(element).prop('disabled', true);
            },
            success:function(result) {
                $('div[id=long]').modal('hide');
                location.reload(true);
            },
            error:function(result) {
                console.log(result);
                location.reload(true);
            }
        });
    }
</script>
@endpush
