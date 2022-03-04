@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('setting/banner.home')}}</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('setting/banner.banner')}}</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('setting/banner.setting')}}</span>
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
        <div class="note note-success">
            <h4>{{ trans('setting/banner.upload_instructions') }}</h4>
            <ul>
                <li>{{ trans('setting/banner.file_should_be_an_image') }}</li>
                <li>{{ trans('setting/banner.image_dimension_should_be') }}</li>
                <li>{{ trans('setting/banner.file_size_could_not_be') }}</li>
            </ul>
        </div>
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-share font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">{{trans('setting/banner.change_banner')}}</span>
                </div>
            </div>
            <div class="portlet-body">
                @include('flash::message')
                <form role="form" action="{{ route('admin.setting.banner') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group{{ $errors->has('banner')?' has-error':' has-feedback' }}">
                            <label for="banner" class="control-label">{{ trans('setting/banner.select_a_banner_to_display') }}</label>
                            <input class="form-control" type="file" name="banner" accept="image/*">
                            <span class="help-block">{{ $errors->first('banner') }}</span>
                        </div>
                    </div>
                    <div class="form-actions text-right">
                        <button type="submit" class="btn blue">{{trans('setting/charges.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
