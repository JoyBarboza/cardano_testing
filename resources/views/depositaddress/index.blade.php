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
            <span> Deposit Address Details </span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    Deposit Address Details
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
                        <span class="caption-subject font-red sbold uppercase">Deposit Address Details</span>
                    </div>
                    <div class="actions">
                        <a href="{{ route('admin.depositaddress.create') }}" class="btn red btn-outline sbold" name="create"> Add Deposit Address Details</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">Coin</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">{{trans('announcement/index.status')}}</th>
                                <th class="text-center">{{trans('announcement/index.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($depositaddress as $row)
                                <tr>
                                    <td class="text-center">{{$row->coin}}</td>
                                    <td class="text-center">{{$row->address}} </td>
                                    <td class="text-center">
                                        <label>
                                            
                                                @if ($row->status == 0)
                                                    {{trans('announcement/index.Inactive')}}
                                                @else
                                                    {{trans('announcement/index.Active')}}
                                                @endif
                                                
                                           
                                        </label>


                                    </td>
                                    <td class="text-center">
                                        <a title="Edit" href="{{ route('admin.depositaddress.edit', $row->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i>{{--{{trans('announcement/index.edit')}}--}}</a>
                                                                            </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-danger">No Data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{$depositaddress->links()}}
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

         
        });
    </script>
@endpush
