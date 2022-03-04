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
            <span>{{trans('roi-plans/create.create_cloud_mining_plan')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
{{trans('roi-plans/create.create')}} 
    <small>{{trans('roi-plans/create.cloud_mining_plan')}}</small>
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
                        <span class="caption-subject font-dark bold uppercase">{{trans('roi-plans/create.create_cloud_mining_plan')}}</span>
                    </div>
					
					<div class="actions">
                        <a href="{{ route('admin.cloudmining.index') }}" class="btn red btn-outline sbold" name="create"> {{trans('roi-plans/create.cloud_mining_plan')}}</a>
                    </div>
                </div>
                <div class="portlet-body">
                    @include('flash::message')
                    <form class="form-horizontal" role="form" action="{{ route('admin.cloudmining.store') }}"  method="post">
                        {{ csrf_field() }}
                        <div class="form-body">

                            <div class="form-group {{ $errors->has('name')?'has-error':'' }}">
                                <label class="col-md-3 control-label">{{trans('roi-plans/create.name')}}:</label>
                                <div class="col-md-9">
                                    
                                        <input name="name" value ="{{ (request()->name!='')?request()->name:old('name') }}" type="text" class="form-control" placeholder="{{trans('roi-plans/create.placeholder_name')}}">
                                    
                                    @if($errors->has('name'))
                                        <span class="help-box">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
							<div class="form-group {{ $errors->has('payin_coin')?'has-error':'' }}">
                                <label class="col-md-3 control-label">Payin Coin:</label>
                                <div class="col-md-9">
										<select name="payin_coin" class="form-control">
											<option value="">select</option>
											<option {{(request()->payin_coin=='USD')?'selected':'' }} value="USD">USD</option>
											<option {{(request()->payin_coin=='CSM')?'selected':'' }} value="CSM">CSM</option>
										</select>
                                        
                                    @if($errors->has('payin_coin'))
                                        <span class="help-box">{{ $errors->first('payin_coin') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('payout_coin')?'has-error':'' }}">
                                <label class="col-md-3 control-label">Payout Coin:</label>
                                <div class="col-md-9">
										<select name="payout_coin" class="form-control">
											<option value="">select</option>
											<option {{(request()->payout_coin=='USD')?'selected':'' }} value="USD">USD</option>
											<option {{(request()->payout_coin=='CSM')?'selected':'' }} value="CSM">CSM</option>
										</select>
                                        
                                    @if($errors->has('payout_coin'))
                                        <span class="help-box">{{ $errors->first('payout_coin') }}</span>
                                    @endif
                                </div>
                            </div>
							{{--<div class="form-group {{ $errors->has('percentage')?'has-error':'' }}">
                                <label class="col-md-3 control-label">{{trans('roi-plans/create.percentage')}}:</label>
                                <div class="col-md-9">
                                    
                                        <input name="percentage" value ="{{ (request()->percentage!='')?request()->percentage:old('percentage') }}" type="text" class="form-control" placeholder="{{trans('roi-plans/create.placeholder_percentage')}}">
                                    
                                    @if($errors->has('percentage'))
                                        <span class="help-box">{{ $errors->first('percentage') }}</span>
                                    @endif
                                </div>
                            </div>--}}
                            <div class="form-group {{ $errors->has('min_coin')?'has-error':'' }}">
                                <label class="col-md-3 control-label">Minimum coin Per Investment :</label>
                                <div class="col-md-9">
                                    
                                        <input name="min_coin" value ="{{ (request()->min_coin!='')?request()->min_coin:old('min_coin') }}" type="text" class="form-control" placeholder="">
                                    
                                    @if($errors->has('min_coin'))
                                        <span class="help-box">{{ $errors->first('min_coin') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('max_coin')?'has-error':'' }}">
                                <label class="col-md-3 control-label">Max coin Per Investment :</label>
                                <div class="col-md-9">
                                    
                                        <input name="max_coin" value ="{{ (request()->max_coin!='')?request()->max_coin:old('max_coin') }}" type="text" class="form-control" placeholder="">
                                    
                                    @if($errors->has('max_coin'))
                                        <span class="help-box">{{ $errors->first('max_coin') }}</span>
                                    @endif
                                </div>
                            </div>
							
                            
							<div class="form-group {{ $errors->has('duration')?'has-error':'' }}">
                                <label class="col-md-3 control-label">{{trans('roi-plans/create.duration')}}:</label>
                                <div class="col-md-9">
                                    
                                        <input name="duration" value ="{{ (request()->duration!='')?request()->duration:old('duration') }}" type="text" class="form-control" placeholder="{{trans('roi-plans/create.placeholder_duration')}}">
                                    
                                    @if($errors->has('duration'))
                                        <span class="help-box">{{ $errors->first('duration') }}</span>
                                    @endif
                                </div>
                            </div>
							<div class="form-group {{ $errors->has('token_price')?'has-error':'' }}">
                                <label class="col-md-3 control-label">If payin amount is 100 , Total Return amount :</label>
                                <div class="col-md-9">
                                    
                                        <input name="token_price" value ="{{ (request()->token_price!='')?request()->token_price:'' }}" type="text" class="form-control" placeholder="token price">
                                    
                                    @if($errors->has('token_price'))
                                        <span class="help-box">{{ $errors->first('token_price') }}</span>
                                    @endif
                                </div>
                            </div>
							<div class="form-group {{ $errors->has('status')?'has-error':'' }}">
                                <label class="col-md-3 control-label">{{trans('roi-plans/create.status')}}:</label>
                                <div class="col-md-9">
                                    
                                        <select name="status" class="form-control">
											<option value="">{{trans('roi-plans/create.select')}}</option>
											<option {{(((request()->status!='')?request()->status:old('status'))=='1')?'selected':'' }} value="1">{{trans('roi-plans/create.active')}}</option>
											<option {{(((request()->status!='')?request()->status:old('status'))=='0')?'selected':'' }} value="0">{{trans('roi-plans/create.inactive')}}</option>
										</select>
                                    
                                    @if($errors->has('status'))
                                        <span class="help-box">{{ $errors->first('status') }}</span>
                                    @endif
                                </div>
                            </div>

                            
                        </div>
                        <div class="form-actions text-right">
                            <button type="submit" class="btn blue check_unit">{{trans('presale/create.submit')}}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
