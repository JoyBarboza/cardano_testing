@extends('layouts.admin')
@section('page-bar')
        <!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('presale/edit.settings')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('presale/edit.control')}}
    <small>{{trans('presale/edit.panel')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')

    <div class="row">
        <div class="col-md-12">
            @include('errors.input')
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-share font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">{{trans('presale/edit.Modify_PreSale')}}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    @include('flash::message')
                    <form class="form-horizontal onSubmitdisableButton" role="form" action="{{ route('admin.presale.update', $preSale->id) }}"  method="post">
                        {{ csrf_field() }} {{ method_field('PUT') }}
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">{{trans('presale/edit.presale_start')}}:</label>
                                <div class="col-md-9">
                                    <div class="input-group date-picker input-daterange">
                                        <input class="form-control" name="start_date" type="text" value="{{ request()->from_date?:$preSale->start_date }}">
                                        <span class="input-group-addon">{{trans('presale/edit.to')}}</span>
                                        <input class="form-control" name="end_date" type="text"  value="{{ request()->end_date?:$preSale->end_date }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('total_unit')?'has-error':'' }}">
                                <label class="col-md-3 control-label">{{trans('presale/edit.Total_Coins_sold')}}</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-cart-arrow-down"></i>
                                                </span>
                                        <input name="total_unit" value ="{{ request()->total_unit?:$preSale->total_coin_unit }}" type="text" class="form-control" placeholder="{{trans('setting/pre_sale.limit_amount')}}">
                                    </div>
                                    @if($errors->has('total_unit'))
                                        <span class="help-box">{{ $errors->first('total_unit') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('unit_price')?'has-error':'' }}">
                                <label class="col-md-3 control-label">{{--{{$currency->name}}--}} {{--{{trans('setting/pre_sale.buy_limit')}}--}}{{trans('presale/edit.Coin_unit_price')}}:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-cart-arrow-down"></i>
                                        </span>
                                        <input name="unit_price" value ="{{ request()->unit_price?:$preSale->unit_price }}" type="text" class="form-control" placeholder="{{trans('setting/pre_sale.limit_amount')}}">
                                    </div>
                                    @if($errors->has('unit_price'))
                                        <span class="help-box">{{ $errors->first('unit_price') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('bonus_discount')?'has-error':'' }}">
                                <label class="col-md-3 control-label">{{--{{$currency->name}}--}} {{--{{trans('setting/pre_sale.buy_limit')}}--}}{{trans('presale/edit.bonus_discount_applied')}}:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-cart-arrow-down"></i>
                                        </span>
                                        <input name="bonus_discount" value ="{{ request()->discount_percent?:$preSale->discount_percent }}" type="text" class="form-control" placeholder="{{trans('setting/pre_sale.limit_amount')}}">
                                    </div>
                                    @if($errors->has('bonus_discount'))
                                        <span class="help-box">{{ $errors->first('bonus_discount') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-right">
                            <button type="button" class="btn default">{{trans('setting/pre_sale.cancel')}}</button>
                            <button type="submit" class="btn blue check_unit submitButton">{{trans('setting/pre_sale.submit')}}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script>
	$(document).on('submit', '.onSubmitdisableButton', function(e) {	
		  if (confirm("Are You Sure ?") == true) {
			$('.submitButton').attr('disabled',true);
			return true;
		  } else {
			return false;
		  }
	});
    $(document).ready(function(){
        $('.date-picker').datepicker({
            orientation: "bottom",
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
    });
</script>
@endpush
