@extends('layouts.admin')
@section('page-bar')
        <!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('setting/presalelist.home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('setting/presalelist.pre_sale')}} {{trans('setting/presalelist.list')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('setting/presalelist.pre_sale')}}
    <small>{{trans('setting/presalelist.list')}}</small>
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
                        <span class="caption-subject font-red sbold uppercase">{{trans('presale/index.Manage_Presale')}}</span>
                    </div>
                    <div class="actions">
                        <a href="{{ route('admin.presale.create') }}" class="btn red btn-outline sbold" name="create"> {{trans('presale/index.AddPreSale')}}</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-left">{{trans('setting/presalelist.start_date')}}</th>
                                <th class="text-center">{{trans('setting/presalelist.end_date')}}</th>
                                <th class="text-center">{{trans('setting/presalelist.total_coin')}}</th>
                                <th class="text-center">{{trans('presale/index.UnitPrice')}}</th>
                                <th class="text-center">{{trans('presale/index.DiscountPercent')}}</th>
                                <th class="text-center">{{trans('presale/index.Status')}}</th>
                                <th class="text-center">{{trans('setting/presalelist.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($sales as $sale)
                                <tr>
                                    <td>{{$sale->start_date}}</td>
                                    <td class="text-center">{{$sale->end_date}} </td>
                                    <td class="text-center">{{ number_format($sale->total_coin_unit, 8) }}</td>
                                    <td class="text-center">{{ $sale->unit_price }}</td>
                                    <td class="text-center">{{ $sale->discount_percent }}</td>
                                    <td class="text-center">
                                        <label>
                                            <a class="text-{{$sale->status?'danger':'success'}}"
                                               href="{{ route('admin.presale.change-status', $sale->id) }}">
                                                @if ($sale->status == 1)
                                                    {{trans('presale/index.Active')}}
                                                @else
                                                    {{trans('presale/index.Inactive')}}
                                                @endif
                                                {{--{{trans('setting/presalelist.activate')}}--}}
                                            </a>
                                        </label>


                                    </td>
                                    <td class="text-center">
                                        <a title="Edit" href="{{ route('admin.presale.edit', $sale->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i>{{--{{trans('setting/presalelist.edit')}}--}}</a>
                                        <a title="Delete" href="{{ route('admin.presale.delete', $sale->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i>{{--{{trans('setting/presalelist.delete')}}--}}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger">{{trans('setting/presalelist.no_transaction_exists')}}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{$sales->links()}}
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

                bootbox.confirm('Are you sure you want to delete this sale?', function(result){
                    if(result) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {_method:'DELETE'},
                            dataType: "json",
                            success: function( res ) {
                                if(res.status){
                                    //row.remove();
                                }
                                bootbox.alert(res.message);
                                location.reload();
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
