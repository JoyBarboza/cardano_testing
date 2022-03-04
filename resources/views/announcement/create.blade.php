@extends('layouts.admin')
@section('page-bar')
        <!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('announcement/create.home')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('announcement/create.announcement')}}
    <!-- <small>{{trans('announcement/create.panel')}}</small> -->
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')

    <div class="row">
        <div class="col-md-12">
            <!-- @include('errors.input') -->
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-share font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">{{trans('announcement/create.Create_new_Announcement')}}{{--{{trans('setting/pre_sale.charge_settings')}}--}}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    @include('flash::message')
                    <form class="form-horizontal" role="form" action="{{ route('admin.announcement.store') }}"  method="post">
                        {{ csrf_field() }}
                        <div class="form-body">

                            <div class="form-group {{ $errors->has('title')?'has-error':'' }}">
                                <label class="col-md-3 control-label">{{trans('announcement/create.title')}}:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                    
                                                </span>
                                        <input name="title" value ="{{ (request()->title!='')?request()->title:old('title') }}" type="text" class="form-control" placeholder="{{trans('announcement/create.enter_title')}}">
                                    </div>
                                    @if($errors->has('title'))
                                        <span class="help-box">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('description')?'has-error':'' }}">
                                <label class="col-md-3 control-label">{{trans('announcement/create.description')}}:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <!-- <i class="fa fa-cart-arrow-down"></i> -->
                                        </span>
                                        <textarea name="description" class="form-control">{{ (request()->description!='')?request()->description:old('description') }}</textarea>
                                        <!-- <input name="description" value ="{{ (request()->description!='')?request()->description:old('description') }}" type="text" class="form-control" placeholder="{{trans('announcement/create.enter_description')}}"> -->
                                    </div>
                                    @if($errors->has('description'))
                                        <span class="help-box">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('bonus_discount')?'has-error':'' }}">
                                <label class="col-md-3 control-label">{{trans('announcement/create.status')}}:</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <!-- <i class="fa fa-cart-arrow-down"></i> -->
                                        </span>
                                        <select class="form-control" name="status">
                                            <option value="1">{{trans('announcement/create.enable')}}</option>
                                            <option value="0">{{trans('announcement/create.disable')}}</option>
                                        </select>
                                    </div>
                                    @if($errors->has('bonus_discount'))
                                        <span class="help-box">{{ $errors->first('bonus_discount') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-right">
                            <button type="button" class="btn default">{{trans('announcement/create.cancel')}}</button>
                            <button type="submit" class="btn blue check_unit">{{trans('announcement/create.submit')}}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')

@endpush
