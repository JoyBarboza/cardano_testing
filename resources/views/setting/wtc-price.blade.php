@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">        
        <li>
            <span>{{trans('setting/wtc_price.settings')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('setting/wtc_price.control')}}
    <small>{{trans('setting/wtc_price.panel')}}</small>
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
                    <span class="caption-subject font-dark bold uppercase">{{trans('setting/wtc_price.set_jpc_price')}}</span>
                </div>
            </div>
            <div class="portlet-body">
                @include('flash::message')
                <form role="form" action="{{ route('admin.setting.wtc.price.set') }}"  method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group{{ $errors->has('buy_price')?' has-error':'' }}">
                            <label>{{trans('setting/wtc_price.JPC_Buy_Price')}}:</label>
                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </span>
                                <input
                                        name="buy_price"
                                        value="{{ old('buy_price')?old('buy_price'):(isset($currentPrice)?$currentPrice->buy_price:'') }}"
                                        type="text" class="form-control" placeholder="{{trans('setting/wtc_price.current_buy_price')}}">
                            </div>
                            @if($errors->has('buy_price'))
                                <span class="help-box">{{ $errors->first('buy_price') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('sell_price')?' has-error':'' }}">
                            <label>{{trans('setting/wtc_price.JPC_sell_Price')}}:</label>
                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </span>
                                <input
                                        name="sell_price"
                                        value="{{ old('sell_price')?old('sell_price'):(isset($currentPrice)?$currentPrice->sale_price:'') }}"
                                        type="text" class="form-control" placeholder="{{trans('setting/wtc_price.current_sell_price')}}">
                            </div>
                            @if($errors->has('sell_price'))
                                <span class="help-box">{{ $errors->first('sell_price') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-actions text-right">
                        <button type="button" class="btn default">{{trans('setting/wtc_price.cancel')}}</button>
                        <button type="submit" class="btn blue">{{trans('setting/wtc_price.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
            
