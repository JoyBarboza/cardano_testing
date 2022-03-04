@extends('layouts.admin')
@section('page-bar')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/home') }}">{{trans('approve/index.home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ url('/home') }}">{{trans('approve/index.approve')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{trans('approve/index.approved_document_list')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">Document <small>{{trans('approve/index.approve')}}</small></h1>
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
                        <i class="fa fa-cogs"></i>{{trans('approve/index.approved_document_list')}}</div>
                </div>
                <div class="portlet-body flip-scroll">
                    <table class="table table-bordered table-striped table-condensed flip-content">
                        <thead class="flip-content">
                            <tr>                                            
                                <th class="text-center" width="15%"> {{trans('approve/index.username')}} </th>
                                <th class="text-center"> {{trans('approve/index.address')}} </th>
                                <th class="text-center"> {{trans('approve/index.city')}}</th>
                                <th class="text-center"> {{trans('approve/index.state')}} </th>
                                <th class="text-center"> {{trans('approve/index.identification_no')}} </th>
                                <th class="text-center"> {{trans('approve/index.verification_status')}} </th>
                                <th class="text-center"> {{trans('approve/index.documents')}} </th>
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
                                    {{ $user->profile->identification_no }}
                                </td>
                                <td class="text-center">
                                    @if($user->verificationPending())
                                        <span class="text-warning">{{trans('approve/index.Pending')}}</span>
                                    @elseif($user->isVerified())
                                        <span class="text-success">{{trans('approve/index.Verified')}}</span>
                                    @else
                                        <span class="text-danger">{{trans('approve/index.Rejected')}}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @foreach($user->document as $document)
                                        <a class="openDiag btn btn-circle blue btn-block" data-toggle="modal" href="#long" data-image="{{url('/').'/download/'.$user->username.'/'.$user->document()->where('name',$document->name)->first()->location}}">
                                            {{ str_replace('_', ' ', $document->name) }}
                                        </a>
                                    @endforeach
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">{{trans('approve/index.no_verification_pending')}}</td>
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
                <h4 class="modal-title">{{trans('approve/index.document_display')}}</h4>
            </div>
            <div class="modal-body">
                <img style="height:380px;width:100%;" />
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">{{trans('approve/index.close')}}</button>
            </div>
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
        display:block;
    }
</style>
@endpush
@push('js')
<script>
    $(document).ready(function(){

        var url = '{!! url('/') !!}';
        $('a.openDiag').click(function(){
            $('div[id=long]').find('img').attr('src', $(this).data('image'));
        });

    });
</script>
@endpush
