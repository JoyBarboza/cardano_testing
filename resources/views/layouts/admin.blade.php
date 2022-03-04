@extends('layouts.partial.admin.master')
@section('page-bar')
        <!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('layouts/admin.dashboard')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('layouts/admin.control')}}
    <small>{{trans('layouts/admin.panel')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
    <div class="row">
        <div class="col-md-12 col-sm-12">

        </div>
    </div>
@endsection
