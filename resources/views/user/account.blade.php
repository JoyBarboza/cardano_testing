@extends('layouts.admin')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('user/index.home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('user/account.User_account')}}</span>  
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
   {{trans('user/account.User_account')}}
    <small>{{--trans('user/index.management')--}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
         @include('flash::message')                                
        <div class="portlet light bordered">
			<div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">{{trans('user/account.user')}} {{trans('user/account.account')}}</span>
                </div>
                <div class="inputs">
                    <div class="portlet-input input-inline input-medium">
                        <form method="get" action="{{ route('admin.user.account') }}">
                            <div class="input-group">
                                <input type="text" name="query" value="{{ request()->get('query') }}" class="form-control input-circle-left" placeholder="Search By Email">
                                <span class="input-group-btn">
                                    <button class="btn btn-circle-right btn-default" type="submit">{{trans('user/account.go')}}</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover table-light">
                        <thead>
                        <tr>
                            <th>{{trans('user/account.Email')}}</th>  
                            <th>{{trans('user/account.Full_Name')}}</th>
                            <th>ADA</th>
                            <th>{{env('TOKEN_SYMBOL')}}</th>
                            <th>{{trans('user/account.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->eth_wallet }}</td>
                                <td>{{ $user->cjm_wallet }}</td>
                                <td>
									<a class="btn btn-success" title="Credit" href="{{ route('admin.account.credit.get', $user->id) }}">{{trans('user/account.Credit')}}</a>
									<a class="btn btn-danger" title="Debit"  href="{{ route('admin.account.debit.get', $user->id) }}">{{trans('user/account.Debit')}}</a>
								</td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                    
                </div>
                <div class="portlet-footer">
								<span style="float:left">{{ __('Showing') }} {{ $users->firstItem() }} {{ __('to') }} {{ $users->lastItem() }} of {{ $users->total() }} {{ __('records') }}</span>
								<span  style="float:right">{{ $users->links() }}</span>
							</div>
            </div>
        </div>
    </div>
</div>
<div id="dialog" class="modal" role="dialog"></div>

@include('template.loader')

@endsection
      
