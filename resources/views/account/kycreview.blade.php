@extends('layouts.master')
@section('page-content')
<div class="col-md-9 col-sm-8">
    <div class="recharge_section">
            <h4>{{trans('account/kycreview.account_under_review')}}</h4>
            <div class="alert alert-warning fade in alert-dismissable">

                {{trans('account/kycreview.account_under_verification')}}
            </div>
    </div>
</div>
@endsection
