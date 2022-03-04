@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">        
        <li>
            <span>{{trans('setting/charges.settings')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('setting/charges.control')}}
    <small>{{trans('setting/charges.panel')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">
     @include('flash::message')
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-share font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">{{trans('setting/charges.charge_settings')}}</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="{{ route('admin.setting.charges') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-body">
                        @foreach($currencies as $currency)
                        @php $sitefee = $currency->charge()->where('name','SITEFEE')->first(); @endphp
                        @php $taxfee = $currency->charge()->where('name','TAX')->first(); @endphp
                        @php $gateWayfee = $currency->charge()->where('name','OTHERS')->first(); @endphp
                            <fieldset>{{ $currency->name }}</fieldset>
                            <div class="form-group">
                                <label>{{trans('setting/charges.site_fee')}}(%)</label>
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </span>
                                    <input
                                            name="SITEFEE_{{ $currency->id }}"
                                            type="text" class="form-control"
                                            placeholder="Enter referal comission" value="{{ (($sitefee) ? $sitefee->amount : 0.00) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{trans('setting/charges.tax')}}(%)</label>
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </span>
                                    <input
                                            name="TAX_{{ $currency->id }}"
                                            type="text" class="form-control"
                                            placeholder="Enter referal comission" value="{{ (($taxfee) ? $taxfee->amount : 0.00) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{trans('setting/charges.additional_charges')}}(%):</label>
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </span>
                                    <input
                                            name="OTHERS_{{ $currency->id }}"
                                            type="text" class="form-control"
                                            placeholder="Enter referal comission" value="{{ (($gateWayfee) ? $gateWayfee->amount : 0.00) }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">{{trans('setting/charges.submit')}}</button>
                        <button type="button" class="btn default">{{trans('setting/charges.cancel')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
            
