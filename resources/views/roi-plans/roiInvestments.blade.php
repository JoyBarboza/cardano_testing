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
            <span>{{trans('roi-plans/roiInvestments.cloud_mining_subscriptions')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
{{trans('roi-plans/roiInvestments.cloud_mining')}}
    <small>{{trans('roi-plans/roiInvestments.subscriptions')}}</small>
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
                        <span class="caption-subject font-red sbold uppercase">{{trans('roi-plans/roiInvestments.cloud_mining_subscriptions')}}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-left">{{trans('roi-plans/roiInvestments.date')}}</th>
                                <th class="text-center">{{trans('roi-plans/roiInvestments.user')}}</th>
                                <th class="text-center">{{trans('roi-plans/roiInvestments.plan')}}</th>
                                <th class="text-center">{{trans('roi-plans/roiInvestments.amount')}} </th>
                          
                                <th class="text-center">{{trans('roi-plans/roiInvestments.return')}} </th>
                                <th class="text-center">{{trans('roi-plans/roiInvestments.duration')}}</th>
                                <th class="text-center">{{trans('roi-plans/roiInvestments.status')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($roiInvestments as $plan)
                                <tr>
                                    <td>{{$plan->created_at}}</td>
                                    <td class="text-center">{{$plan->user->email}}</td>
                                    <td class="text-center">{{$plan->roiPlan->name}}</td>
                                    <td class="text-center">{{ round($plan->amount_investment,8) }} {{$plan->payin_coin}}</td>
                            
                                    <td class="text-center">{{ round($plan->amount_return,8) }} {{$plan->payout_coin}}</td>
                                    <td class="text-center">{{$plan->duration}} {{trans('roi-plans/roiInvestments.days')}} </td>
                                    <td class="text-center">{{$plan->status}}  </td>
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-danger">{{trans('setting/presalelist.no_transaction_exists')}}</td>
                                </tr>
                            @endforelse
								<tr>
									<td colspan="7">
										
									<span class="text-right">{{ $roiInvestments->links() }}</span>
									</td>
								</tr>
                            </tbody>
                        </table>
                        <div class="">
								
							</div>
                    </div>
                     
                </div>
            </div>
        </div>
@endsection
