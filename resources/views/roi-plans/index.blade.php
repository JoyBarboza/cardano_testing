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
            <span>{{trans('roi-plans/index.cloud_mining_plans')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
{{trans('roi-plans/index.cloud_mining')}}
    <small>{{trans('roi-plans/index.plans')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">{{trans('roi-plans/index.manage_cloud_mining')}}</span>
                    </div>
                    <div class="actions">
                        <a href="{{ route('admin.cloudmining.create') }}" class="btn red btn-outline sbold" name="create"> {{trans('roi-plans/index.add_cloud_mining')}}</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-left">{{trans('roi-plans/index.name')}}</th>
                                
                                <th class="text-center">{{trans('roi-plans/index.duration')}}</th>
                               
                                <th class="text-center">Payable Coin</th>
                                <th class="text-center">Received Coin</th>
                                <th class="text-center">If payin amount is 100 , Total Return amount </th>
                                <th class="text-center">{{trans('roi-plans/index.status')}}</th>
                                <th class="text-center">{{trans('roi-plans/index.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($plans as $plan)
                                <tr>
                                    <td>{{$plan->name}}</td>
                                    
                                    <td class="text-center">{{$plan->duration}} {{trans('roi-plans/index.days')}} </td>
                                
                                    <td class="text-center">{{($plan->payin_coin)}}  </td>
                                    <td class="text-center">{{($plan->payout_coin)}}  </td>
                                    <td class="text-center">{{($plan->token_price)}}  </td>
                                    <td class="text-center">{{($plan->status)?'Active':'Inactive'}}  </td>
                                    <td class="text-center">
                                        <a title="Edit" href="{{ route('admin.cloudmining.edit', $plan->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-danger">{{trans('setting/presalelist.no_transaction_exists')}}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
