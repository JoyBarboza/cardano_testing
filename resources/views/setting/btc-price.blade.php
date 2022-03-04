@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">        
        <li>
            <span>{{trans('setting/btc_price.setting')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    Control
    <small>Panel</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-share font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">{{trans('setting/btc_price.set_btc_variance')}}</span>
                </div>
            </div>
            <div class="portlet-body">
                @include('flash::message')
                <form role="form" action="{{ route('admin.setting.btc.price.set') }}"  method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group{{ $errors->has('buy_price')?' has-error':'' }}">
                            <h3>{{trans('setting/btc_price.btc_buy_price')}} : $ {{(isset($currentPrice)?$currentPrice->buy_price:0.00)}}</h3>
                            <label>{{trans('setting/btc_price.buy_price_varience')}} (+):</label>
                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </span>
                                <input
                                        name="buy_price_variance_btc"
                                        value="{{ $settings->where('key', 'buy_price_variance_btc')->isEmpty() ? 0.00 :$settings->where('key', 'buy_price_variance_btc')->last()->value }}"
                                        type="text" class="form-control" placeholder="{{trans('setting/btc_price.current_buy_price_varience')}}">
                            </div>
                            @if($errors->has('buy_price_variance'))
                                <span class="help-box">{{ $errors->first('buy_price_variance') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('sell_price_variance')?' has-error':'' }}">
                            <h3>{{trans('setting/btc_price.btc_sale_price')}}: $ {{(isset($currentPrice) ? $currentPrice->sale_price:0.00 )}}</h3>
                            <label>{{trans('setting/btc_price.sale_price_variance')}}(-):</label>
                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </span>
                                <input
                                        name="sell_price_variance_btc"
                                        value="{{ $settings->where('key', 'sell_price_variance_btc')->isEmpty() ? 0.00 :$settings->where('key', 'sell_price_variance_btc')->last()->value }}"
                                        type="text" class="form-control" placeholder="{{trans('setting/btc_price.btc_sale_price')}}">
                            </div>
                            @if($errors->has('sell_price_variance'))
                                <span class="help-box">{{ $errors->first('sell_price_variance') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-actions text-right">
                        <button type="button" class="btn default">{{trans('setting/btc_price.cancel')}}</button>
                        <button type="submit" class="btn blue">{{trans('setting/btc_price.submit')}}</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
            
