@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">        
        <li>
            <span>{{trans('setting/limit.settings')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('setting/limit.control')}}
    <small>{{trans('setting/limit.panel')}}</small>
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
                    <span class="caption-subject font-dark bold uppercase">{{trans('setting/limit.charge_settings')}}</span>
                </div>
            </div>
            <div class="portlet-body">
                @include('flash::message')
                <form role="form" action="{{ route('admin.setting.limit') }}"  method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        @foreach(\App\Currency::where('id','<>',3)->get() as $currency)
                            <div class="form-group {{ $errors->has($currency->name.'_BUY_LIMIT')?'has-error':'' }}">
                                <label>{{$currency->name}} {{trans('setting/limit.buy_limit')}}:</label>
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-cart-arrow-down"></i>
                                            </span>
                                    <input
                                            name="{{$currency->name}}_BUY_LIMIT"
                                            value ="{{ $settings->where('key', $currency->name.'_BUY_LIMIT')->isEmpty()?'':$settings->where('key', $currency->name.'_BUY_LIMIT')->last()->value }}"
                                            type="text" class="form-control" placeholder="{{trans('setting/limit.limit_amount')}}">
                                </div>
                                @if($errors->has($currency->name.'_BUY_LIMIT'))
                                    <span class="help-box">{{ $errors->first($currency->name.'_BUY_LIMIT') }}</span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has($currency->name.'_SELL_LIMIT')?'has-error':'' }}">
                                <label>{{$currency->name}} {{trans('setting/limit.sell_limit')}}:</label>
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-key"></i>
                                            </span>
                                    <input
                                            name="{{$currency->name}}_SELL_LIMIT"
                                            value ="{{ $settings->where('key', $currency->name.'_SELL_LIMIT')->isEmpty()?'':$settings->where('key', $currency->name.'_SELL_LIMIT')->last()->value }}"
                                            type="text" class="form-control" placeholder="{{trans('setting/limit.limit_amount')}}">
                                </div>
                                @if($errors->has($currency->name.'_SELL_LIMIT'))
                                    <span class="help-box">{{ $errors->first($currency->name.'_SELL_LIMIT') }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="form-actions text-right">
                        <button type="button" class="btn default">{{trans('setting/limit.cancel')}}</button>
                        <button type="submit" class="btn blue">{{trans('setting/limit.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
            
